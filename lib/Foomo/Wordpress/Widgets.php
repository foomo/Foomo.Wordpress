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
class Widgets
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const SECTION_WIDGETS_ENABLED	= 'foomo-widgets-enabled';
	const SETTINGS_GROUP			= 'foomo-widgets';

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
		self::$classes = \Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Widgets\\AbstractWidget');
		if (is_admin()) self::setupSettings();
		add_action('widgets_init', array(__CLASS__, '_remove_default_widgets'), 0);
		add_action('widgets_init', array(__CLASS__, '_widgets_init'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private satatic methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private static function setupSettings()
	{
		\Foomo\Wordpress\Admin::addSettingsSection(self::SECTION_WIDGETS_ENABLED, 'Enabled Widgets', function(){}, \Foomo\Wordpress\Admin::MENU_PAGE_FOOMO_WIDGETS);

		foreach (self::$classes as $class) {
			$id = 'foomo_enableWidget_' . str_replace('\\', '', $class);
			\Foomo\Wordpress\Admin::registerSetting(self::SETTINGS_GROUP, $id);
			\Foomo\Wordpress\Admin::addSettingsField($id, substr($class, strrpos($class, '\\') + 1), array('Foomo\\Wordpress\\Settings\\Fields', 'checkbox'), self::SETTINGS_GROUP, self::SECTION_WIDGETS_ENABLED);
		};
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 */
	public static function _widgets_init()
	{
		foreach (self::$classes as $class) {
			$id = 'foomo_enableWidget_' . str_replace('\\', '', $class);
			if (get_option($id, false)) register_widget($class);
		}
	}

	public static function _remove_default_widgets()
	{
		unregister_widget('WP_Widget_Pages');
		unregister_widget('WP_Widget_Calendar');
		unregister_widget('WP_Widget_Archives');
		unregister_widget('WP_Widget_Links');
		unregister_widget('WP_Widget_Meta');
		unregister_widget('WP_Widget_Search');
		unregister_widget('WP_Widget_Text');
		unregister_widget('WP_Widget_Categories');
		unregister_widget('WP_Widget_Recent_Posts');
		unregister_widget('WP_Widget_Recent_Comments');
		unregister_widget('WP_Widget_RSS');
		unregister_widget('WP_Widget_Tag_Cloud');
		unregister_widget('WP_Nav_Menu_Widget');
	}
}