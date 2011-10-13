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

namespace Foomo\Wordpress\Themes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Foomo960 extends \Foomo\Wordpress\Themes\AbstractTheme
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'foomo-960';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	public static $debug = false;

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods implementations
	//---------------------------------------------------------------------------------------------

	/**
	 */
	public function setup()
	{
		add_filter('show_recent_comments_widget_style', '__return_false');
		add_action('after_setup_theme', array($this, 'after_setup_theme'));
		add_action('widgets_init', array($this, 'widgets_init'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Action methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * To override foomo_960_setup() in a child theme, add your own foomo_960_setup to your child theme's
	 * functions.php file.
	 *
	 * @action after_setup_theme
	 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
	 * @uses register_nav_menus() To add support for navigation menus.
	 * @uses add_custom_background() To add support for a custom background.
	 * @uses add_editor_style() To style the visual editor.
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_custom_image_header() To add support for a custom header.
	 * @uses register_default_headers() To register the default custom header images provided with the theme.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 */
	public function after_setup_theme()
	{
		// This theme styles the visual editor with editor-style.css to match the theme style.
		#add_editor_style();

		// Make theme available for translation
		$this->includeTextdomain(self::getConstant('ID'), TEMPLATEPATH . '/languages');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array('main' => __('Main Navigation', self::getConstant('ID'))));
		register_nav_menus(array('meta' => __('Meta Navigation', self::getConstant('ID'))));
	}

	/**
	 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
	 *
	 * To override foomo_960_widgets_init() in a child theme, remove the action hook and add your own
	 * function tied to the init hook.
	 *
	 * @uses register_sidebar
	 */
	public function widgets_init()
	{
		// before container
		register_sidebar(array(
			'id' => 'first-before-container-aside',
			'name' => __('1st before Container', self::getConstant('ID')),
			'description' => __('First before Container Widget area', self::getConstant('ID')),
		));
		register_sidebar(array(
			'id' => 'second-before-container-aside',
			'name' => __('2nd before Container', self::getConstant('ID')),
			'description' => __('Second before Container Widget area', self::getConstant('ID')),
		));
		register_sidebar(array(
			'id' => 'third-before-container-aside',
			'name' => __('3rd before Container', self::getConstant('ID')),
			'description' => __('Third before Container Widget area', self::getConstant('ID')),
		));
		// left of content
		register_sidebar(array(
			'id' => 'before-content-aside',
			'name' => __('Left of Content', self::getConstant('ID')),
			'description' => __('Left of Content Widget area', self::getConstant('ID')),
		));
		// right of content
		register_sidebar(array(
			'id' => 'after-content-aside',
			'name' => __('Right of Content', self::getConstant('ID')),
			'description' => __('Right of Content Widget area', self::getConstant('ID')),
		));
		// after container
		register_sidebar(array(
			'id' => 'first-after-container-aside',
			'name' => __('1st after Container', self::getConstant('ID')),
			'description' => __('First after Container Widget area', self::getConstant('ID')),
		));
		register_sidebar(array(
			'id' => 'second-after-container-aside',
			'name' => __('2nd after Container', self::getConstant('ID')),
			'description' => __('Second Container Widget area', self::getConstant('ID')),
		));
		register_sidebar(array(
			'id' => 'third-after-container-aside',
			'name' => __('3rd after Container', self::getConstant('ID')),
			'description' => __('Third after Container Widget area', self::getConstant('ID')),
		));
		// footer
		register_sidebar(array(
			'id' => 'first-footer-aside',
			'name' => __('1st Footer', self::getConstant('ID')),
			'description' => __('First footer Widget area', self::getConstant('ID')),
		));
		register_sidebar(array(
			'id' => 'second-footer-aside',
			'name' => __('2nd Footer', self::getConstant('ID')),
			'description' => __('Second Footer area', self::getConstant('ID')),
		));
		register_sidebar(array(
			'id' => 'third-footer-aside',
			'name' => __('3rd Footer', self::getConstant('ID')),
			'description' => __('Third Footer Widget area', self::getConstant('ID')),
		));
	}
}