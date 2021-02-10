<?php
/**
 * Signup Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */


use WOF\Org\Theme\Blocks;
use WOF\Org\Theme\Models\Overlay;

?>

<section class="sign-up">
    <h1>Stay Updated</h1>
    <p>Get the latest resources sent straight to your inbox by signing up below.</p>
    <form>
        <input type="text" id="wof-sign-up" name="wof-sign-up">
    </form>
</section>
