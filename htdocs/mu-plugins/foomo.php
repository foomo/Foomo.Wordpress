<?
/*
Plugin Name: foomo
Description: foomo integration plugin
Author: franklin <franklin@weareinteractive.com>
Author URI: http://www.weareinteractive.com/
Plugin URI: http://www.foomo.org/
Version: 0.1
@todo add screenshot
*/

\Foomo\Wordpress::init();
\Foomo\Wordpress\Admin::init();
\Foomo\Wordpress\Plugins::init();
\Foomo\Wordpress\Widgets::init();
\Foomo\Wordpress\Shortcodes::init();
