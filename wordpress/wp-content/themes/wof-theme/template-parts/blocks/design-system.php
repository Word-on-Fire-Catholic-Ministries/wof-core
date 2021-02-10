<?php
$styles = get_fields();
$block_class = 'block-' . $block['id']
?>

<div class="wof-block design-system-block">
    <style>
        .<?= $block_class ?> p {
            display: inline-block;
            font-family: "<?= $styles['font_family'] ?>";
            font-size: <?= $styles['font_size'] ?>;
            font-weight: <?= $styles['font_weight'] ?>;
            font-style: <?= $styles['font_style'] ?>;
            text-decoration: <?= $styles['text_decoration'] ?>;
            text-transform: <?= $styles['text_transform'] ?>;
            letter-spacing: <?= $styles['letter_spacing'] ?>;
            line-height: <?= $styles['line_height'] ?>;
            color: <?= $styles['color'] ?>;
            background-color: <?= $styles['background_color'] ?>;
            border-radius: <?= $styles['border_radius'] ?>;

            <?php
            for ($i = 0; $i < count($styles['padding']); $i++) {
                $key = array_keys($styles['padding'])[$i];
                echo "padding-{$key}: {$styles['padding'][$key]};";
            }

            for ($i = 0; $i < count($styles['margin']); $i++) {
                $key = array_keys($styles['margin'])[$i];
                echo "margin-{$key}: {$styles['margin'][$key]} !important;";
            }

            if ($styles['border']) {
                foreach ($styles['border'] as $border) {
                    if ($border['side'] === 'full') {
                        echo "border: {$border['color']} {$border['style']} {$border['size']} ;";
                    } else {
                        echo "border-{$border['side']}: {$border['color']} {$border['style']} {$border['size']} ;";
                    }
                }
            }
            ?>
        }
    </style>

    <div class="design-system-block <?= $block_class ?>">
        <InnerBlocks allowedBlocks="core/paragraph" />
    </div>

</div>
