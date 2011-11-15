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

namespace Foomo\Wordpress\Widgets;

if (!class_exists('WP_Widget')) include_once(\Foomo\Wordpress\Module::getWordpressDir() . DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'widgets.php');

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractWidget extends \WP_Widget
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

	/**
	 *
	 */
	public function __construct( $id_base = false, $name, $widget_options = array(), $control_options = array() ) 
	{
		parent::__construct($id_base, $name, $widget_options, $control_options);
		\Foomo\Wordpress\Utils\Hooks::register($this);
	}	

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected function renderView($template, $model=null)
	{
		return \Foomo\Wordpress\View::render(get_called_class(), $template, $model);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 * @param string $file
	 * @param string $base
	 * @return boolean
	 */
	public static function register($file='', $base='')
	{
		$className = \get_called_class();
		if (isset(self::$registered[$className])) return false;
		self::$registered[$className] = func_get_args();
		add_action('_foomo_widgets_loaded', array(__CLASS__, '_foomo_widgets_loaded'));
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
	public static function _foomo_widgets_loaded()
	{
		foreach (self::$registered as $className => $args) \register_widget($className);
	}

}