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
class Plugins
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

	/**
	 * @todo only include classes that are within this context
	 */
	public static function init()
	{
		self::$classes = \Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Plugins\\AbstractPlugin');
		self::setupSettings();
		self::validateSettings();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private satatic methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private static function setupSettings()
	{
		\Foomo\Wordpress\Admin::addSettingsSection('foomo-plugins-enabled', 'Enabled Plugins', function(){}, 'foomo-plugins');

		foreach (self::$classes as $class) {
			$id = 'foomo_enablePlugin_' . str_replace('\\', '', $class);
			\Foomo\Wordpress\Admin::registerSetting('foomo-plugins', $id);
			\Foomo\Wordpress\Admin::addSettingsField($id, substr($class, strrpos($class, '\\') + 1), array('Foomo\\Wordpress\\Settings\\Fields', 'checkbox'), 'foomo-plugins', 'foomo-plugins-enabled');
		};
	}

	/**
	 *
	 */
	private static function validateSettings()
	{
		foreach (self::$classes as $class) {
			$id = 'foomo_enablePlugin_' . str_replace('\\', '', $class);
			if (get_option($id, false)) $class::init();
		}
	}
}