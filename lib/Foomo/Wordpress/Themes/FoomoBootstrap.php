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
 * @link	www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author	franklin <franklin@weareinteractive.com>
 */
abstract class FoomoBootstrap extends \Foomo\Wordpress\Themes\AbstractTheme
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	public static $baseTemplateName;

	//---------------------------------------------------------------------------------------------
	// ~ Override methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @add_action init
	 * @add_action_priority 9
	 */
	public function _base_init()
	{
		if (\is_admin()) return;

		# replace scripts
		\wp_deregister_script('jquery');
		\wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js', array(), false, true);

		# register scripts
		\wp_register_script('bootstrap.alert', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-alert.js' , array('jquery'), false, true);
		\wp_register_script('bootstrap.dropdown', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-dropdown.js' , array('jquery'), false, true);
		\wp_register_script('bootstrap.modal', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-modal.js' , array('jquery'), false, true);
		\wp_register_script('bootstrap.popover', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-popover.js' , array('jquery'), false, true);
		\wp_register_script('bootstrap.scrollspy', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-scrollspy.js' , array('jquery'), false, true);
		\wp_register_script('bootstrap.tabs', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-tabs.js' , array('jquery'), false, true);
		\wp_register_script('bootstrap.twipsy', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getThemesPath() . '/foomo-bootstrap/vendor/bootstrap/js/bootstrap-twipsy.js' , array('jquery'), false, true);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 *
	 * @add_action after_setup_theme
	 * @add_action_priority 9
	 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
	 * @uses register_nav_menus() To add support for navigation menus.
	 * @uses add_custom_background() To add support for a custom background.
	 * @uses add_editor_style() To style the visual editor.
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_custom_image_header() To add support for a custom header.
	 * @uses register_default_headers() To register the default custom header images provided with the theme.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 */
	public function _base_after_setup_theme()
	{
		// Add default posts and comments RSS feed links to <head>.
		#add_theme_support('automatic-feed-links');

		// This theme uses wp_nav_menu() in one location.
		#register_nav_menus(array('main' => __('Main Menu', 'foomo-bootstrap')));
		#register_nav_menus(array('meta' => __('Meta Navigation', 'foomo-bootstrap')));
	}

	/**
	 * @internal
	 * @add_filter 404_template
	 * @param string $path
	 * @return string
	 */
	public function _base_404_template($path)
	{
		return $this->resolveTemplate($path, '404');
	}

	/**
	 * @add_filter archive_template
	 * @param string $path
	 * @return string
	 */
	public function _base_archive_template($path)
	{
		return $this->resolveTemplate($path, 'archive');
	}

	/**
	 * @internal
	 * @add_filter attachment_template
	 * @param string $path
	 * @return string
	 */
	public function _base_attachment_template($path)
	{
		return $this->resolveTemplate($path, 'attachment');
	}

	/**
	 * @internal
	 * @add_filter author_template
	 * @param string $path
	 * @return string
	 */
	public function _base_author_template($path)
	{
		return $this->resolveTemplate($path, 'author');
	}

	/**
	 * @internal
	 * @add_filter category_template
	 * @param string $path
	 * @return string
	 */
	public function _base_category_template($path)
	{
		return $this->resolveTemplate($path, 'category');
	}

	/**
	 * @internal
	 * @add_filter comments_popup_template
	 * @param string $path
	 * @return string
	 */
	public function _base_comments_popup_template($path)
	{
		return $this->resolveTemplate($path, 'comments-popup');
	}

	/**
	 * @internal
	 * @add_filter comments_template
	 * @param string $path
	 * @return string
	 */
	public function _base_comments_template($path)
	{
		return $this->resolveTemplate($path, 'comments');
	}

	/**
	 * @internal
	 * @add_filter date_template
	 * @param string $path
	 * @return string
	 */
	public function _base_date_template($path)
	{
		return $this->resolveTemplate($path, 'date');
	}

	/**
	 * @internal
	 * @add_filter home_template
	 * @param string $path
	 * @return string
	 */
	public function _base_home_template($path)
	{
		return $this->resolveTemplate($path, 'home');
	}

	/**
	 * @internal
	 * @add_filter page_template
	 * @param string $path
	 * @return string
	 */
	public function _base_page_template($path)
	{
		return $this->resolveTemplate($path, 'page');
	}

	/**
	 * @internal
	 * @add_filter paged_template
	 * @param string $path
	 * @return string
	 */
	public function _base_paged_template($path)
	{
		return $this->resolveTemplate($path, 'paged');
	}

	/**
	 * @internal
	 * @add_filter search_template
	 * @param string $path
	 * @return string
	 */
	public function _base_search_template($path)
	{
		return $this->resolveTemplate($path, 'search');
	}

	/**
	 * @internal
	 * @add_filter single_template
	 * @param string $path
	 * @return string
	 */
	public function _base_single_template($path)
	{
		return $this->resolveTemplate($path, 'single');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $path
	 * @param string $base
	 * @return string
	 */
	private function resolveTemplate($path, $base='index')
	{
		if ('index' == $base) $base = false;
		self::$baseTemplateName = $base;
		$templates = array('index.php');
		if ($base) array_unshift($templates, sprintf('index-%s.php', $base));
		#\trigger_error(\var_export($templates, true));
		return locate_template($templates);
	}
}