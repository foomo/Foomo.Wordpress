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

namespace Foomo\Wordpress\Plugins;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Fancybox extends AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function init()
	{
		if (is_admin()) self::initSettings();
		if (is_admin()) self::setupSettings();
		if (!is_admin()) self::validateSettings();

		if (!is_admin()) add_filter('the_content', array(__CLASS__, '_the_content'), 99);
		if (!is_admin()) add_filter('the_excerpt', array(__CLASS__, '_the_content'), 99);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private satatic methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private static function initSettings()
	{
		if (get_option('foomo_fancybox_script', '') == '') update_option('foomo_fancybox_script', '$(document).ready(function() {$("a[rel^=fancybox]").fancybox();});');
	}

	/**
	 *
	 */
	private static function setupSettings()
	{
		\Foomo\Wordpress\Admin::addSettingsSection('foomo-plugins-fancybox', 'Fancybox Settings', function(){}, 'foomo-plugins');

		\Foomo\Wordpress\Admin::registerSetting('foomo-plugins', 'foomo_fancybox_script');
		\Foomo\Wordpress\Admin::registerSetting('foomo-plugins', 'foomo_fancybox_automode');

		\Foomo\Wordpress\Admin::addSettingsField('foomo_fancybox_automode', 'Activate automode', array('Foomo\\Wordpress\\Settings\\Fields', 'checkbox'), 'foomo-plugins', 'foomo-plugins-fancybox');
		\Foomo\Wordpress\Admin::addSettingsField('foomo_fancybox_script', 'Footer script', array('Foomo\\Wordpress\\Settings\\Fields', 'textarea'), 'foomo-plugins', 'foomo-plugins-fancybox');
	}

	/**
	 *
	 */
	private static function validateSettings()
	{
		wp_register_style('jquery.fancybox', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath('fancybox') . '/jquery.fancybox-1.3.4.css', array(), '1.3.4', 'screen');
		wp_register_script('jquery.easing', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath('fancybox') . '/jquery.easing-1.3.pack.js', array('jquery'), '1.3', true);
		wp_register_script('jquery.fancybox', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath('fancybox') . '/jquery.fancybox-1.3.4.pack.js', array('jquery', 'jquery.easing'), '1.3.4', true);
		\Foomo\Wordpress::addFooterScript(get_option('foomo_fancybox_script'));

		if (get_option('foomo_fancybox_automode', false)) {
			wp_enqueue_script('jquery.fancybox');
			wp_enqueue_style('jquery.fancybox');
		}
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @global type $post
	 * @param type $content
	 * @return type
	 */
	public static function _the_content($content)
	{
		global $post;
		$pattern        = "/(<a(?![^>]*?rel=['\"]fancybox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
		$replacement    = '$1 rel="fancybox-' . $post->ID . '">';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}
}