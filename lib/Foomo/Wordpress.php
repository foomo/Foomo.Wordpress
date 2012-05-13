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
class Wordpress extends \Foomo\Wordpress\Object
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------
	
	/**
	 * Enables hook on all objects
	 */
	public static function registerObjects()
	{
		# resiter object hooks
		\Foomo\Timer::addMarker('Registering wordpress object hooks :: start');
		$objects = self::getClasses('Foomo\\Wordpress\\Object');
		\Foomo\Timer::addMarker('Retrieved class list');
		foreach ($objects as $object) \Foomo\Wordpress\Utils::registerHooks($object);
		\Foomo\Timer::addMarker('Registering wordpress object hooks :: end');
	}
	
	/**
	 * Registeres all widgets with wordpress and enables hooks 
	 */
	public static function registerWidgets()
	{
		\Foomo\Timer::addMarker('Registering wordpress widgets hooks :: start');
		$widgets = self::getClasses('Foomo\\Wordpress\\Widget\\Base');
		\Foomo\Timer::addMarker('Retrieved class list');
		foreach ($widgets as $widget) {
			register_widget($widget);
			\Foomo\Wordpress\Utils::registerHooks($widget);
		}
		\Foomo\Timer::addMarker('Registering wordpress widgets hooks :: end');
	}
	
	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------
	
	/**
	 * @return string[] 
	 */
	private static function getClasses($className)
	{
		$classes = array();
		# get all classes from autoloader
		$objectClasses = \Foomo\AutoLoader::getClassesBySuperClass($className);
		# current active module
		$module = \Foomo\Modules\Manager::getDocumentRootModule();
		# list of all modules to autoload objects		
		$modules = array(\Foomo\Wordpress\Module::NAME, $module);
		# add configured modules
		if (\Foomo\Config::confExists(\Foomo\Modules\Manager::getDocumentRootModule(), \Foomo\Wordpress\Config::NAME)) {
			$modules = array_unique(array_merge($modules, \Foomo\Config::getConf(\Foomo\Modules\Manager::getDocumentRootModule(), \Foomo\Wordpress\Config::NAME)->modules));
		} else {
			\trigger_error('Config "' . \Foomo\Wordpress\Config::NAME . '" does not exist for current document root module "' . \Foomo\Modules\Manager::getDocumentRootModule() . '"', \E_USER_WARNING);
		}
		# only return classes that are in the loading path
		foreach ($objectClasses as $class) {
			if (!\in_array(\Foomo\Modules\Manager::getClassModule($class), $modules)) continue;
			$classes[] = $class;
		}
		return $classes;
	}
}