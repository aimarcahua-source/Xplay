<?php
/**
 * FeedBuzz functions and definitions.
 *
 * @package FeedBuzz
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FEEDBUZZ_VERSION', '1.0.2' );
define( 'FEEDBUZZ_DIR', get_template_directory() );

require_once FEEDBUZZ_DIR . '/inc/options.php';
require_once FEEDBUZZ_DIR . '/inc/setup.php';
require_once FEEDBUZZ_DIR . '/inc/customizer.php';
require_once FEEDBUZZ_DIR . '/inc/block-editor.php';
require_once FEEDBUZZ_DIR . '/inc/template-tags.php';
require_once FEEDBUZZ_DIR . '/inc/dynamic-css.php';
