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
	 * @var Foomo\Wordpress\Options
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

		if (is_admin()) self::initAdmin();
		\Foomo\Wordpress\Hooks::add(__CLASS__);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private static function initAdmin()
	{
		$defaults = array();

		# plugins
		$defaults['enabled_plugins'] = array();
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Plugins\\AbstractPlugin') as $class) $defaults['enabled_plugins'][$class] = false;

		# oembdeds
		$defaults['enabled_oembeds'] = array();
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\OEmbeds\\AbstractOEmbed') as $class) $defaults['enabled_oembeds'][$class] = false;

		# toolkit
		$defaults['toolkit'] = array(
			'disable_core_updates' => false,
			'disable_plugin_updates' => false
		);


		# Creating an options object
		self::$options = new \Foomo\Wordpress\Options('foomo', self::$file, $defaults);

		#trigger_error(var_export($defaults, true));

		new \Foomo\Wordpress\AdminPage\Foomo(self::$file, self::$options);
	}

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