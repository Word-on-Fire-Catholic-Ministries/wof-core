<?php
/**
 * Latest Content Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


use WOF\Org\Theme\Blocks;
use WOF\Org\Theme\Models\Overlay;

$block_args   = get_fields();
$anchor       = Blocks::get_anchor( $block );
$classes      = Blocks::get_css_classes( $block );
$unique_class = Blocks::get_block_unique_css_class( Blocks::parse_block_name( $block['name'] ), $block['id'] );
$title        = get_field( 'title' );
$limit        = get_field( 'limit' );
$overlay      = new Overlay( Overlay::get_default_linear_black_args() );

$query = new WP_Query( array(
	'posts_per_page' => $limit
) )

?>

<section id="<?= $anchor ?>" class="<?= $classes ?>">

    <ul class="latest-content__featured-list">

		<?php

		$first  = true;
		$active = '';

		if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
			$categories = get_the_category();
			if ( $first ) {
				$active = 'active';
			} else {
				$active = '';
			}
			?>

            <li class="latest-content__featured-item <?= $active ?>" data-lc-feat-id="<?php the_ID(); ?>">

                <figure class="latest-content__featured-image">
					<?php
					$overlay->render( $block_args, $unique_class );
					if ( has_post_thumbnail() ) {
						the_post_thumbnail();
					}
					?>

                    <div class="latest-content__featured-text txt--white">
                        <h3 class="text-block--orange"><a href="<?php get_category_link($categories[0]) ?>"><?= $categories[0]->name ?></a></h3>
                        <h2 class="h1 txt--white txt--xl"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h2>
                        <p class="h5 txt--gray-300 sp-mt-lg-r"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' )); ?>"><span class="latest-content__author txt--orange-500"><?php the_author(); ?></span> | <?php the_author_meta('author_title'); ?></a></p>
                        <div class="body-text txt--blue-300 sp-my-lg-r"><?php the_excerpt(); ?></div>
                        <a class="" href="<?php the_permalink(); ?>">See More > </a>
                    </div>

                </figure>

            </li>

			<?php $first = false; endwhile; endif;
		$query->rewind_posts(); ?>

    </ul>

    <div class="latest-content__content">

        <ul class="latest-content__posts-list">

			<?php

			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				$categories = get_the_category()
				?>

                <li class="latest-content__posts-item post-selector-<?php the_ID(); ?>" data-lc-list-id="<?php the_ID(); ?>">
                    <a href="<?php the_permalink(); ?>">
                        <div class="latest-content__posts-line"></div>
                        <h3 class="latest-content__posts-cat text-block--orange txt--sm"><?= $categories[0]->name ?></h3>
                        <h2 class="latest-content__posts-title txt--white"><?php the_title() ?></h2>
                        <p class="latest-content__posts-author h5 txt--orange-500" ><?php the_author() ?></p>
                    </a>
                </li>

			<?php endwhile; endif;
			wp_reset_query(); ?>
        </ul>

    </div>

</section>
