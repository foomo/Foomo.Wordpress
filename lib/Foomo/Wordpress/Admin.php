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
class Admin
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private static $submenuPages = array();
	/**
	 * @var array
	 */
	private static $registerSettings = array();
	/**
	 * @var array
	 */
	private static $settingsSections = array();
	/**
	 * @var array
	 */
	private static $settingsFields	 = array();

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function init()
	{
	    add_action('admin_init', array(__CLASS__, 'admin_init'));
	    add_action('admin_menu', array(__CLASS__, 'admin_menu'));
	}

	/**
	 *
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $capability
	 * @param string $menu_slug
	 * @param mixed $function
	 * @param string $parent_slug
	 */
	public static function addSubmenuPage($page_title, $menu_title, $capability, $menu_slug, $function='', $parent_slug='foomo')
	{
		self::$submenuPages[] = (object) array('page_title' => $page_title, 'menu_title' => $menu_title, 'capability' => $capability, 'menu_slug' => $menu_slug, 'function' => $function, 'parent_slug' => $parent_slug);
	}

	/**
	 * @param string $option_group
	 * @param string $option_name
	 * @param mixed $default
	 * @param mixed $sanitize_callback
	 */
	public static function registerSetting($option_group, $option_name, $sanitize_callback='')
	{
		self::$registerSettings[] = (object) array('option_group' => $option_group, 'option_name' => $option_name, 'sanitize_callback' => $sanitize_callback);
	}

	/**
	 *
	 * @param string $id
	 * @param string $title
	 * @param mixed $callback
	 * @param string $page
	 */
	public static function addSettingsSection($id, $title, $callback, $page)
	{
		self::$settingsSections[] = (object) array('id' => $id, 'title' => $title, 'callback' => $callback, 'page' => $page);
	}

	/**
	 *
	 * @param string $id
	 * @param string $title
	 * @param mixed $callback
	 * @param string $page
	 * @param string $section
	 * @param array $args
	 */
	public static function addSettingsField($id, $title, $callback, $page, $section='default', $args=array())
	{
		$args['id'] = $id;
		$args['section'] = $section;
		self::$settingsFields[] = (object) array('id' => $id, 'title' => $title, 'callback' => $callback, 'page' => $page, 'section' => $section, 'args' => $args);
	}


	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 */
	public function admin_init()
	{
		foreach (self::$registerSettings as $registerSetting) {
			register_setting($registerSetting->option_group, $registerSetting->option_name, $registerSetting->sanitize_callback);
		}
		foreach (self::$settingsSections as $settingsSection) {
			add_settings_section($settingsSection->id, $settingsSection->title, $settingsSection->callback, $settingsSection->page);
		}
		foreach (self::$settingsFields as $settingsField) {
			add_settings_field($settingsField->id, $settingsField->title, $settingsField->callback, $settingsField->page, $settingsField->section, $settingsField->args);
		}
	}

	/**
	 * @internal
	 */
	public function admin_menu()
	{
		add_menu_page('Foomo', 'foomo', 'manage_options', 'foomo', array(__CLASS__, 'submenu_page_general'));
		self::addSubmenuPage('General', 'General', 'manage_options', 'foomo', array(__CLASS__, 'submenu_page_general'));
		self::addSubmenuPage('Plugins', 'Plugins', 'manage_options', 'foomo-plugins', array(__CLASS__, 'submenu_page_plugins'));
		self::addSubmenuPage('Shortcodes', 'Shortcodes', 'manage_options', 'foomo-shortcodes', array(__CLASS__, 'submenu_page_shortcodes'));

		foreach (self::$submenuPages as $submenuPage) {
	        add_submenu_page($submenuPage->parent_slug, $submenuPage->page_title, $submenuPage->menu_title, $submenuPage->capability, $submenuPage->menu_slug, $submenuPage->function);
		}
	}

	/**
	 * @internal
	 */
	public static function submenu_page_general()
	{
		echo self::renderView('General', 'general');
	}

	/**
	 * @internal
	 */
	public static function submenu_page_plugins()
	{
		echo self::renderView('Plugins', 'plugins');
	}

	/**
	 * @internal
	 */
	public static function submenu_page_shortcodes()
	{
		echo self::renderView('Shortcodes', 'shortcodes');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 * @param string $title
	 * @param string $template
	 * @return string
	 */
	private static function renderView($title, $template)
	{
		$model = (object) array('title' => $title);
		$template = \Foomo\Wordpress\Module::getViewsDir(str_replace('\\', '/', get_called_class())) . '/' . $template . '.tpl';
		$view = \Foomo\View::fromFile($template, $model);
		return $view->render();
	}
}