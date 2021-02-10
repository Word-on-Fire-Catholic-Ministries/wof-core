<?php
/*
Block Name: Grid Block
Block Description: A content block that shows the most recent post from a category.
Post Types: post, page, custom-type
*/

$grid_class = 'grid-block-post-' . get_the_ID();

if (is_admin()) {
    $grid_class = $grid_class . ' .block-editor-block-list__layout';
}

$classes = array('grid-block-post-' . get_the_ID(), 'grid-block');

if( !empty($block['align']) ) {
	$classes[] = 'align' . $block['align'];
}

if ( ! empty( get_field('className' ) ) ) {
	$classes = array_merge( $classes, explode( ' ', get_field('className' ) ) );
}

$anchor = '';
if ( ! empty( get_field('anchor' ) ) ) {
	$anchor = ' id="' . sanitize_title(get_field('anchor' ) ) . '"';
}



?>

<div <?= $anchor ?> class="<?= implode(' ', $classes) ?>">
    <style>
        .<?= $grid_class ?> {
            display: grid;
            width: 100%;
            grid-template-columns: repeat( auto-fit, minmax(<?= get_field('grid_width' ) ?>, 1fr) );
            grid-auto-rows: <?= get_field('grid_height' ) ?>;
        }

        @media only screen and (max-width: <?= get_field('grid_width' ) ?>) {
            .<?= $grid_class ?> {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <InnerBlocks />
</div>
