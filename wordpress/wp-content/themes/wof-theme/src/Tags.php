<?php


namespace WOF\Org\Theme;


use WP_Term;

class Tags {

	public static function printIcon( string $name ) {
		echo file_get_contents( WOFORG_THEME_URI . '/assets/img/icons/' . $name . '.svg' );
	}

	public static function printSvg( int $attachment_id ) {
		echo file_get_contents( WP_CONTENT_DIR . self::getSvgDir( $attachment_id ) );
	}

	public static function getSvgDir( int $attachmentId ) {
		$atUrl = wp_get_attachment_url( $attachmentId );

		return substr( $atUrl, strpos( $atUrl, '/uploads/' ) );
	}

	public static function getColorOverlayCss( array $overlay_args ) {

		if ( ! isset( $overlay_args['overlay_type'] ) || $overlay_args['overlay_type'] === 'none' ) {
			return '';
		}

		if ( $overlay_args['overlay_type'] === 'solid' ) {
			return 'background-color: ' . $overlay_args['solid_color'] . ';';
		}

		if ( $overlay_args['overlay_type'] === 'radial_gradient' ) {
			return 'background: radial-gradient(circle, ' . $overlay_args['gradient_color_1'] . ' ' . $overlay_args['gradient_position_1'] . '%, ' . $overlay_args['gradient_color_2'] . ' ' . $overlay_args['gradient_position_2'] . '%);';
		}

		if ( $overlay_args['overlay_type'] === 'linear_gradient' ) {
			return 'background: linear-gradient(' . $overlay_args['linear_degrees'] . 'deg, ' . $overlay_args['gradient_color_1'] . ' ' . $overlay_args['gradient_position_1'] . '%, ' . $overlay_args['gradient_color_2'] . ' ' . $overlay_args['gradient_position_2'] . '%);';
		}

		return '';
	}

	public static function printCategoryLinks( WP_Term $category, $classes = '', $seperator = "&nbsp/ ", $extra_links = false ) {
		$cats        = array( $category );
		$current_cat = $category;
		while ( $current_cat->parent > 0 ) {
			$current_cat = get_term( $current_cat->parent );
			$cats[]      = $current_cat;
		}
		$cats  = array_reverse( $cats );
		$first = true;
		?>

        <ul class="category-links <?= $classes ?>">

			<?php if ( $extra_links ) : ?>

                <li class="category-links__item"><?php if ( ! $first ) {
						echo( $seperator );
					}
					$first = false; ?><a href="<?= $extra_links['url'] ?>"><?= $extra_links['name'] ?></a></li>

			<?php endif; ?>

			<?php foreach ( $cats as $cat ) : ?>

                <li class="category-links__item"><?php if ( ! $first ) {
						echo( $seperator );
					}
					$first = false; ?><a href="<?= get_term_link( $cat->term_id ) ?>"><?= $cat->name; ?></a></li>

			<?php endforeach; ?>

        </ul>
		<?php
	}

	public static function printTagLinks( array $tags, $classes = '' ) {
		?>

        <ul class="tag-links <?= $classes ?>">

			<?php foreach ( $tags as $tag ) : ?>

                <li class="tag-links__item"><a href="<?= get_term_link( $tag->term_id ) ?>"><?= $tag->name; ?></a></li>

			<?php endforeach; ?>

        </ul>
		<?php
	}

	public static function getTagColor( WP_Term $tag ) {
		$bg_color    = get_field( 'tag_color', $tag );
		if ( isset( $bg_color ) ) {
			return $bg_color;
		}
		return false;
	}

	public static function print_search_icon_svg () {
	    echo '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 40 40"> <path d="M26.804 29.01c-2.832 2.34-6.465 3.746-10.426 3.746C7.333 32.756 0 25.424 0 16.378 0 7.333 7.333 0 16.378 0c9.046 0 16.378 7.333 16.378 16.378 0 3.96-1.406 7.594-3.746 10.426l10.534 10.534c.607.607.61 1.59-.004 2.202-.61.61-1.597.61-2.202.004L26.804 29.01zm-10.426.627c7.323 0 13.26-5.936 13.26-13.26 0-7.32-5.937-13.257-13.26-13.257C9.056 3.12 3.12 9.056 3.12 16.378c0 7.323 5.936 13.26 13.258 13.26z"></path> </svg>';
	}

}