<?php

/*
 * This file is part of the foomo Opensource Framework.
 *
 * The foomo Opensource Framework is free software: you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public License as
 * published  by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * The foomo Opensource Framework is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with
 * the foomo Opensource Framework. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Foomo;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Wordpress
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	private static $file;
	/**
	 * @var Foomo\Wordpress\Admin\Options
	 */
	private static $options;

	//---------------------------------------------------------------------------------------------
	// ~ Internal static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 */
	public static function init($file)
	{
		self::$file = $file;


		$defaults = array();

		# plugins
		$defaults['enabled_plugins'] = array();
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Plugins\\AbstractPlugin') as $class) $defaults['enabled_plugins'][$class] = false;

		# oembdeds
		$defaults['enabled_oembeds'] = array();
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\OEmbeds\\AbstractOEmbed') as $class) $defaults['enabled_oembeds'][$class] = false;

		# default widgets
		$defaults['disabled_default_widgets'] = array(
			'WP_Widget_Pages' => false,
			'WP_Widget_Calendar' => false,
			'WP_Widget_Archives' => false,
			'WP_Widget_Links' => false,
			'WP_Widget_Meta' => false,
			'WP_Widget_Search' => false,
			'WP_Widget_Text' => false,
			'WP_Widget_Categories' => false,
			'WP_Widget_Recent_Posts' => false,
			'WP_Widget_Recent_Comments' => false,
			'WP_Widget_RSS' => false,
			'WP_Widget_Tag_Cloud' => false,
			'WP_Nav_Menu_Widget' => false,
		);

		# widgets
		$defaults['enabled_widgets'] = array();
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Widgets\\AbstractWidget') as $class) $defaults['enabled_widgets'][$class] = false;

		# shortcodes
		$defaults['enabled_shortcodes'] = array();
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Shortcodes\\AbstractShortcode') as $class) $defaults['enabled_shortcodes'][$class] = false;

		# toolkit
		$defaults['toolkit'] = array(
			'disable_core_updates' => false,
			'disable_plugin_updates' => false,
			'overwrite_jquery_script' => false,
		);


		# Creating an options object
		self::$options = new \Foomo\Wordpress\Admin\Options('foomo', self::$file, $defaults);

		\Foomo\Wordpress\Admin\Pages\Foomo::register(self::$file, self::$options);

		\Foomo\Wordpress\Utils\Hooks::register(__CLASS__);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------


	/**
	 * @add_action plugins_loaded
	 */
	public static function enablePlugins()
	{
		foreach (self::$options->enabled_plugins as $key => $value) {
			if (!$value) continue;
			$key::register(self::$file);
		}
		do_action('_foomo_plugins_loaded');
		do_action('foomo_plugins_loaded');
	}

	/**
	 * @add_action plugins_loaded
	 */
	public static function enableOembeds()
	{
		foreach (self::$options->enabled_oembeds as $key => $value) {
			if (!$value) continue;
			$key::register();
		}
		do_action('_foomo_oembeds_loaded');
		do_action('foomo_oembeds_loaded');
	}

	/**
	 * @add_action widgets_init
	 */
	public static function disableDefaultWidgets()
	{
		foreach (self::$options->disabled_default_widgets as $key => $value) {
			if (!$value) continue;
			$key::register();
		}
		do_action('foomo_default_widgets_disabled');
	}

	/**
	 * @add_action widgets_init
	 */
	public static function enableWidgets()
	{
		foreach (self::$options->enabled_widgets as $key => $value) {
			if (!$value) continue;
			$key::register();
		}
		do_action('_foomo_widgets_loaded');
		do_action('foomo_widgets_loaded');
	}

	/**
	 * @add_action plugins_loaded
	 */
	public static function enableShortcodes()
	{
		foreach (self::$options->enabled_shortcodes as $key => $value) {
			if (!$value) continue;
			$key::register();
		}
		do_action('_foomo_shortcodes_loaded');
		do_action('foomo_shortcodes_loaded');
	}

	/**
	 * @add_action foomo_plugins_loaded
	 */
	public static function toolkit()
	{
		# disable updates
		if (self::$options->toolkit['disable_core_updates']) {
			add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));
		}

		if (self::$options->toolkit['disable_plugin_updates']) {
			remove_action('load-update-core.php', 'wp_update_plugins');
			add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
		}
	}
}