<?php
/**
 * The main template file
 */

get_header();
?>
    <main id="site-content" role="main" class="index">
        <div class="index-inner posts-loop">
            <?php
            if ( have_posts() ) {

                while ( have_posts() ) {

                    the_post();
                    ?>
                    <article <?php post_class('index-post block-content allow-wide-blocks'); ?> id="post-<?php the_ID(); ?>">

                        <?php if (!get_field('hide_title')) : ?>

                            <header class="post-title">

                                <h1><?php the_title() ?></h1>

                            </header>

                        <?php endif; ?>

                        <?php the_content(); ?>

                    </article>
                    <?php

                }
            }
            ?>
        </div>
    </main>
<?php
get_footer();