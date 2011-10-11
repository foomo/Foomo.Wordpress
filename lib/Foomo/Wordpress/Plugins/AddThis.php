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
class AddThis// extends AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function init()
	{
		self::initSettings();
		self::setupSettings();
		self::validateSettings();
	}

	/**
	 * @return string
	 */
	public static function getHtml()
	{
		return get_option('foomo_addthis_html', '');
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private satatic methods
	//---------------------------------------------------------------------------------------------

	private static function initSettings()
	{
		if (!is_admin()) return;
		if (get_option('foomo_addthis_config', '') == '') update_option('foomo_addthis_config', '{"data_track_clickback":true}');
	}

	/**
	 *
	 */
	private static function setupSettings()
	{
		\Foomo\Wordpress\Admin::addSettingsSection('foomo-plugins-addthis', 'AddThis Settings', function(){}, 'foomo-plugins');

		\Foomo\Wordpress\Admin::registerSetting('foomo-plugins', 'foomo_addthis_html');
		\Foomo\Wordpress\Admin::registerSetting('foomo-plugins', 'foomo_addthis_config');
		\Foomo\Wordpress\Admin::registerSetting('foomo-plugins', 'foomo_addthis_profileId');

		\Foomo\Wordpress\Admin::addSettingsField('foomo_addthis_profileId', 'Profile ID', array('Foomo\\Wordpress\\Settings\\Fields', 'text'), 'foomo-plugins', 'foomo-plugins-addthis');
		\Foomo\Wordpress\Admin::addSettingsField('foomo_addthis_config', 'Config (JSON)', array('Foomo\\Wordpress\\Settings\\Fields', 'textarea'), 'foomo-plugins', 'foomo-plugins-addthis');
		\Foomo\Wordpress\Admin::addSettingsField('foomo_addthis_html', 'HTML Tags', array('Foomo\\Wordpress\\Settings\\Fields', 'textarea'), 'foomo-plugins', 'foomo-plugins-addthis');
	}

	/**
	 *
	 */
	private static function validateSettings()
	{
		wp_enqueue_script('addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=' . get_option('foomo_addthis_profileId', ''), array(), false, true);
		\Foomo\Wordpress::addFooterScript('var addthis_config = ' . get_option('foomo_addthis_config') . ';', true);
	}
}