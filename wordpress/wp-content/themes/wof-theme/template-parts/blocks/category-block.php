<?php
/*
Block Name: Category Block
Block Description: A content block that shows the most recent post from a category.
Post Types: post, page, custom-type
*/

use WOF\Org\Theme\Models\Overlay;
use WOF\Org\Theme\Tags;

$block_ID = $block['id'];
$block_fields = get_fields();

$query_args = array(
	'posts_per_page' => 1
);
$category   = get_category(get_field('category'));

if ( isset( $category ) ) {
	$query_args['cat'] = $category->term_id;
}

// Vars switch from block to post
$query = new WP_Query( $query_args );
$query->the_post();

$icon_id = get_field( 'category_icon', $category );

$tags = get_the_tags();
$tag  = array(
	'name'  => 'Other',
	'color' => 'hsla(23, 73%, 51%, 0.7)'
);

if ( isset( $tags[0] ) ) {
	$tag['name'] = $tags[0]->name;
	$bg_color    = get_field( 'tag_color', $tags[0] );
	if ( isset( $bg_color ) ) {
		$tag['color'] = $bg_color;
	}
}

// Defaults for the Author
$author             = array(
	'name'     => 'Anonymous',
	'portrait' => 0,
	'is_bb'    => false
);
$author['name']     = get_the_author_meta( 'author_display_name' );
$author['portrait'] = get_the_author_meta( 'author_portrait' );
$author['is_bb']    = get_the_author_meta( 'author_bb' );

$classes = array('content-block-post-' . get_the_ID(), 'content-block-' . $block_ID, 'content-block', 'category-block');
if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, explode( ' ', get_field('className' ) ) );
}

$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
	$anchor = ' id="' . sanitize_title( get_field('anchor') ) . '"';
}

$overlay = new Overlay( Overlay::get_default_linear_black_args());

?>


    <article  <?= $anchor ?> class="<?= implode(' ', $classes) ?>">
        <style>
            .content-block-post-<?php the_ID() ?> .content-block__topic {
                background-color: <?= $tag['color'] ?>;
            }
        </style>

        <?php $overlay->render($block_fields, 'content-block-' . $block_ID, 'content-block__overlay'); ?>


	    <?php if ( has_post_thumbnail() ) : ?>

            <figure class="content-block__image">

			    <?php the_post_thumbnail(); ?>

            </figure>

	    <?php endif; ?>

        <a <?php if (!is_admin()) {  echo 'href="' . get_the_permalink() . '"'; } ?> >
            <section class="content-block__content">
                <header class="content-block__title">
                    <div>
                        <h2 class="content-block__title-text"><?php the_title() ?></h2>
                        <p class="content-block__author">by <?= $author['name'] ?></p>
                    </div>


					<?php if ( isset ( $icon_id ) && $icon_id > 0 ) : ?>
                        <i class="content-block__icon"><?php Tags::printSvg( $icon_id ); ?></i>
					<?php endif ?>

                </header>
                <div></div>
                <div class="content-block__meta">
                    <h3 class="content-block__topic"><?= $tag['name'] ?></h3>
                    <h4 class="content-block__category"><?= $category->name ?></h4>
					<?php if ( $author['is_bb'] === '1' ) : ?>
                        <figure class="content-block__author-portrait">
							<?= wp_get_attachment_image( $author['portrait'] ) ?>
                        </figure>
					<?php endif ?>
                </div>
            </section>
        </a>
    </article>
<?php
wp_reset_query();

