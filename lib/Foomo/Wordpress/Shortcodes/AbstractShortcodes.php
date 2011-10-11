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

namespace Foomo\Wordpress\Shortcodes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractShortcode
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private static $registered = array();

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{

	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return array method_name => [shorcodes]
	 */
	abstract public function getShortcodes();

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------
	/**
	 * @see wp_enqueue_script
	 */
	public function enqueueScripts()
	{

	}
	/**
	 * @see wp_enqueue_style
	 */
	public function enqueueStyles()
	{
	}

	//---------------------------------------------------------------------------------------------
	// ~ Internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 */
	public function _no_texturize_shortcodes($shortcodes)
	{
		if (!$this->noTexturize()) return $shortcodes;
		foreach ($this->getShortcodes() as $codes) $shortcodes = array_merge($shortcodes, $codes);
		return $shortcodes;
	}

	/**
	 * @internal
	 */
	public function _no_wpautop_shortcodes($shortcodes)
	{
		if (!$this->noWpautop()) return $shortcodes;
		foreach ($this->getShortcodes() as $codes) $shortcodes = array_merge($shortcodes, $codes);
		return $shortcodes;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Include shortcodes in no_texturize_shortcodes
	 *
	 * @return boolean
	 */
	public static function noTexturize()
	{
		return true;
	}

	/**
	 * Include shortcodes in no_wpautop_shortcodes
	 *
	 * @return boolean
	 */
	public static function noWpautop()
	{
		return true;
	}

	/**
	 * @return boolean
	 */
	public static function register()
	{
		$className = \get_called_class();
		if (isset(self::$registered[$className])) return false;
		self::$registered[$className] = func_get_args();
		add_action('_foomo_shortcodes_loaded', array(__CLASS__, '_foomo_shortcodes_loaded'));
		return true;
	}

	/**
	 * @param string $oldClassName
	 * @param string $newClassName
	 * @return boolean
	 */
	public static function replace($oldClassName, $newClassName)
	{
		if (!isset(self::$registered[$oldClassName])) return false;
		self::$registered[$newClassName] = self::$registered[$oldClassName];
		unset(self::$registered[$oldClassName]);
		return true;
	}

	/**
	 * @param string $className
	 * @return boolean
	 */
	public static function remove($className)
	{
		if (!isset(self::$registered[$className])) return false;
		unset(self::$registered[$className]);
		return true;
	}

	/**
	 * @internal
	 */
	public static function _foomo_shortcodes_loaded()
	{
		foreach (self::$registered as $className => $args) {
			$inst = \Foomo\Reflection\Utils::createInstance($className, $args);
			add_filter('no_texturize_shortcodes', array($inst, '_no_texturize_shortcodes'));
			add_filter('no_wpautop_shortcodes', array($inst, '_no_wpautop_shortcodes'));
			$shortcodes = $inst->getShortcodes();
			$inst->enqueueScripts();
			$inst->enqueueStyles();
			foreach ($shortcodes as $method => $codes) {
				foreach ($codes as $code) add_shortcode($code, array($inst, $method));
			}
		}
	}
}