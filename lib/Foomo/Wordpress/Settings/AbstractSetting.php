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

namespace Foomo\Wordpress\Settings;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractSetting
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function __construct()
	{
		if (is_admin()) {
			add_action('admin_init', array(&$this, 'init'));
			add_action('admin_menu', array(&$this, 'menu'));
		}
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

    /**
     * Registeres the menu
     */
	public function menu()
    {
		if (!function_exists('current_user_can') || !current_user_can('manage_options')) return;
		add_options_page(self::getName(), self::getName(), 'manage_options', self::getId(), array(&$this, 'render'));
	}

    /**
     * Returns admin menu options
     */
	public function render()
    {
		$model = array('id' => self::getId(), 'name' => self::getName(), 'title' => self::getTitle());
		$module = \Foomo\Modules\Manager::getModuleByClassName(get_called_class());
		$template = \Foomo\Config::getModuleDir($module) . '/views/' . str_replace('\\', '/', get_called_class()) . '/admin.tpl';
		if (!file_exists($template)) $template = \Foomo\Wordpress\Module::getViewsDir() . '/Foomo/Wordpress/Settings/admin.tpl';
		$view = \Foomo\View::fromFile($template, (object) $model);
		echo $view->render();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

    /**
     * Registeres the menu
     */
	abstract public function init();

	/**
	 * @param mixed $input
	 * @return mixed
	 */
	abstract public function validate($input);

	/**
	 * @param mixed $input
	 * @return mixed
	 */
	abstract public static function setDefaults();

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return mixed
	 */
	public static function getOptions()
	{
		static $instance;
		if (is_null($instance)) {
			$class = get_called_class();
			$instance = new $class;
		}
		return get_option(self::getId());
	}

	//---------------------------------------------------------------------------------------------
	// ~ Protected static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	protected static function getId()
	{
		return self::getConstant('ID');
	}

	/**
	 * @return string
	 */
	protected static function getName()
	{
		return self::getConstant('NAME');
	}

	/**
	 * @return string
	 */
	protected static function getTitle()
	{
		return self::getConstant('TITLE');
	}

	/**
	 * @return string defined constant
	 */
	protected static function getConstant($name)
	{
		return constant(get_called_class() . '::' . $name);
	}
}