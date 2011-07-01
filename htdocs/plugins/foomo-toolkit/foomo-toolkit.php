<?php
/**
 * Plugin Name: Foomo Toolkit Plugin
 * Plugin URI: http://www.foomo.org/
 * Description: Plugin for common foomo tools
 * Author: franklin
 * Version: 0.1
 * Author URI: http://www.foomo.org/
 */

# define constants
define('FOOMO_TOOLKIT_PLUGIN_PATH', dirname(__FILE__));

# load plugin
$foomoToolkitPlugin = new Foomo\Wordpress\Plugins\Toolkit();
