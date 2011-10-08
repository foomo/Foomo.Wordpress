<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */

$wp_did_header = true;

/** The config file resides in ABSPATH */
require_once(dirname(realpath(__FILE__)) . '/wp-config.php' );

wp();

require_once( ABSPATH . WPINC . '/template-loader.php' );
?>