<?php

use WOF\Org\Theme\Models\Overlay;
use WOF\Org\Theme\Tags;

defined( 'ABSPATH' ) || exit;

get_header();
?>
    <main id="site-content" role="main" class="single">
        <div class="single-inner">
			<?php
			if ( have_posts() ) {

				while ( have_posts() ) {

					the_post();

					$post_meta = get_post_meta( get_the_ID() );

					$author             = array();
					$author['name']     = get_the_author_meta( 'author_display_name' );
					$author['portrait'] = get_the_author_meta( 'author_portrait' );
					$author['is_bb']    = get_the_author_meta( 'author_bb' );

					$site_url = get_site_url();
					$category = get_the_category();
					$tags     = get_the_tags();
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

					$post_fields = get_fields();
					$overlay = new Overlay(Overlay::get_default_linear_black_args());
					?>

                    <article <?php post_class( 'index-post' ); ?> id="post-<?php the_ID(); ?>">

                        <header class="article-header-post-<?php the_ID() ?> article-header">

                            <style>
                                .article-header-post-<?php the_ID() ?> .tag-links__item {
                                    background-color:<?=  $tag['color'] ?>;
                                }
                            </style>

                            <figure class="article-header__image">
                                <?php

                                if ($post_fields) {
	                                $overlay->render($post_fields, 'article-header-post-' . get_the_ID());

                                }

                                ?>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail(); ?>
                                <?php endif; ?>
                            </figure>

                            <section class="article-header__content">

								<?php Tags::printCategoryLinks( $category[0], '', "&nbsp/ ", array('name' => 'Home', 'url' => $site_url) ); ?>

                                <h2 class="article-header__title"><?php the_title() ?></h2>

                                <div class="article-header__meta">
                                    <figure class="article-header__author-portrait">
                                        <a href="<?= get_author_posts_url( get_the_author_meta('ID') ) ?>">
	                                        <?= wp_get_attachment_image( $author['portrait'] ) ?>
                                        </a>
                                    </figure>
                                    <div class="article-header__meta-item">
                                        <a href="<?= get_author_posts_url( get_the_author_meta('ID') ) ?>">
                                            <h3><?= __('Author', WOFORG_THEME_TXT_DOMAIN) ?></h3>
                                            <p ><?= $author['name'] ?></p>
                                        </a>
                                    </div>
                                    <div class="article-header__meta-item">
                                        <h3><?= __('Published', WOFORG_THEME_TXT_DOMAIN) ?></h3>
                                        <p><?php the_date() ?></p>
                                    </div>
                                </div>

                                <?php Tags::printTagLinks($tags) ?>

                            </section>

                        </header>

                        <section class="single-content">
	                        <?php the_content(); ?>
                        </section>
                    </article>
					<?php

				}
			}
			?>
        </div>
    </main>
<?php
get_footer();
