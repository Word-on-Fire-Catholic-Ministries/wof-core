<?php


namespace WOF\Org\Theme;


class Debug {
	public static function print_var ($var) {
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
}