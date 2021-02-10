<?php


namespace WOF\Org\Theme\Models;


class Overlay {

	private array $default_args;

	public function __construct (array $default_args) {
		$this->default_args = $default_args;
	}

	public static function get_default_linear_black_args () : array {
	    return array(
            'overlay_type' => 'linear_gradient',
            'overlay_linear_degrees' => 0,
            'overlay_gradient_color_1' => '#000',
            'overlay_gradient_position_1' => 0,
            'overlay_gradient_color_2' => 'rgba(0,0,0,0.3)',
            'overlay_gradient_position_2' => 80
        );
    }

	public function render (array $args, string $parent_class = '', $overlay_class = 'color-overlay') {

		$background_css = $this->get_background_css($args);

		if ($background_css !== '') {
			$this->render_style_tags($background_css, $parent_class, $overlay_class);
		}

		echo '<div class="' . $overlay_class . '"></div>';
	}

	private function render_style_tags (string $background_css, $parent_class = '', $overlay_class = 'color-overlay') {
		$selector = '.' . $overlay_class;

		if ($parent_class !== '') {
			$selector = '.' . $parent_class . ' ' . $selector;
		}

		?>
		<style>
			<?= $selector ?> {
				<?= $background_css ?>
			}
		</style>
		<?php
	}

	public function get_background_css (array $args) : string {
		$r_args = $args;

		if (empty($args['overlay_override']) || !$args['overlay_override']) {
			$r_args = $this->default_args;
		}

		if ($r_args['overlay_type'] === 'none') {
			return '';
		}

		if ( $r_args['overlay_type'] === 'solid' ) {
			return 'background-color: ' . $r_args['solid_color'] . ';';
		}

		if ( $r_args['overlay_type'] === 'radial_gradient' ) {
			return 'background: radial-gradient(circle, ' . $r_args['overlay_gradient_color_1'] . ' ' . $r_args['overlay_gradient_position_1'] . '%, ' . $r_args['overlay_gradient_color_2'] . ' ' . $r_args['overlay_gradient_position_2'] . '%);';
		}

		if ( $r_args['overlay_type'] === 'linear_gradient' ) {
			return 'background: linear-gradient(' . $r_args['overlay_linear_degrees'] . 'deg, ' . $r_args['overlay_gradient_color_1'] . ' ' . $r_args['overlay_gradient_position_1'] . '%, ' . $r_args['overlay_gradient_color_2'] . ' ' . $r_args['overlay_gradient_position_2'] . '%);';
		}

		return '';

	}

}