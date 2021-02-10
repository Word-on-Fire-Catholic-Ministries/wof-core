<?php
/**
 * About WOF Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */


use WOF\Org\Theme\Blocks;
use WOF\Org\Theme\Models\Overlay;

$block_args   = get_fields();
$anchor       = Blocks::get_anchor( $block );
$classes      = Blocks::get_css_classes( $block );

?>

<section class="<?= $classes ?>">
    <h1>Bishop Barron's Word on Fire</h1>
    <div class="about-wof-wrap">
        <figure class="about-wof-img">
		    <?= wp_get_attachment_image(371, 'large') ?>
        </figure>

        <section class="about-wof-content">
            <h2 class="about-wof-heading">Bishop Robert Barron</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only fiv...</p>
            <a class="text-block--orange">About Bishop Barron</a>
            <h2 class="about-wof-heading">Word on Fire</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only fiv...</p>
            <a class="text-block--orange">About Word on Fire</a>
        </section>
        <figure class="about-wof-latest">
            <div class="about-wof-latest-wrap">
                <h2 class="about-wof-cap">Latest</h2>
                <h3>Watch these 3 powerful testimonies.</h3>
            </div>
            <div class="color-overlay color-overlay-black-fade"></div>
	        <?= wp_get_attachment_image(372, 'large') ?>

        </figure>
    </div>
</section>

