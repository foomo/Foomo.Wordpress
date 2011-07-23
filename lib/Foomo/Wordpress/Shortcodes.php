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

namespace Foomo\Wordpress;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Shortcodes
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private static $classes;

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	public static function init()
	{
		if (is_admin()) return;

		self::$classes = \Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Shortcodes\\AbstractShortcodes');

		self::setupSettings();
		self::validateSettings();

		add_filter('no_texturize_shortcodes', array(__CLASS__, '_no_texturize_shortcodes'));
		add_filter('no_wpautop_shortcodes', array(__CLASS__, '_no_wpautop_shortcodes'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Internal static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @param array $shortcodes
	 * @return string
	 */
	public static function _no_texturize_shortcodes($shortcodes)
	{
		foreach (self::$classes as $class) {
			if (!$class::noTexturize()) continue;
			foreach ($class::getShortcodes() as $codes) {
				$shortcodes = array_merge($shortcodes, $codes);
			}
		}
		return $shortcodes;
	}

	/**
	 * @internal
	 * @param array $shortcodes
	 * @return string
	 */
	public static function _no_wpautop_shortcodes($shortcodes)
	{
		foreach (self::$classes as $class) {
			if (!$class::noWpautop()) continue;
			foreach ($class::getShortcodes() as $codes) {
				$shortcodes = array_merge($shortcodes, $codes);
			}
		}
		return $shortcodes;
	}


	//---------------------------------------------------------------------------------------------
	// ~ Private satatic methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private static function setupSettings()
	{
		\Foomo\Wordpress\Admin::addSettingsSection('foomo-shortcodes', 'Enabled Shortcodes', function(){}, 'foomo-shortcodes');

		foreach (self::$classes as $class) {
			$id = 'foomo_enableShortcodes_' . str_replace('\\', '', $class);
			$args = array();
			$args['description'] = array();
			$shortcodes = $class::getShortcodes();
			foreach ($shortcodes as $method => $codes) {
				$args['description'] = array_merge($args['description'], $codes);
			}
			$args['description'] = implode(', ', $args['description']);
			\Foomo\Wordpress\Admin::registerSetting('foomo-shortcodes', $id);
			\Foomo\Wordpress\Admin::addSettingsField($id, substr($class, strrpos($class, '\\') + 1), array('Foomo\\Wordpress\\Settings\\Fields', 'checkbox'), 'foomo-shortcodes', 'foomo-shortcodes', $args);
		};
	}

	/**
	 *
	 */
	private static function validateSettings()
	{
		foreach (self::$classes as $class) {
			$id = 'foomo_enableShortcodes_' . str_replace('\\', '', $class);
			if (get_option($id, false)) {
				$shortcodes = $class::getShortcodes();
				$class::enqueueScripts();
				$class::enqueueStyles();
				foreach ($shortcodes as $method => $codes) {
					foreach ($codes as $code) {
						add_shortcode($code, array($class, $method));
					}
				}
			}
		}
	}
}