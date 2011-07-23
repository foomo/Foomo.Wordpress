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
class Toolkit extends AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function init()
	{
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
		\Foomo\Wordpress\Admin::addSettingsSection('foomo-general-admin', 'Admin Settings', function(){}, 'foomo');

		\Foomo\Wordpress\Admin::registerSetting('foomo', 'foomo_disableCoreUpdates');
		\Foomo\Wordpress\Admin::registerSetting('foomo', 'foomo_disablePluginUpdates');

		\Foomo\Wordpress\Admin::addSettingsField('foomo_disableCoreUpdates', 'Disable Core Updates', array('Foomo\\Wordpress\\Settings\\Fields', 'checkbox'), 'foomo', 'foomo-general-admin');
		\Foomo\Wordpress\Admin::addSettingsField('foomo_disablePluginUpdates', 'Disable Plugin Updates', array('Foomo\\Wordpress\\Settings\\Fields', 'checkbox'), 'foomo', 'foomo-general-admin');
	}

	/**
	 *
	 */
	private static function validateSettings()
	{
		if (!is_admin()) return;

		if (get_option('foomo_disableCoreUpdates', false)) {
			add_filter('pre_site_transient_update_core', create_function('$a', "return null;"));
		}

		if (get_option('foomo_disablePluginUpdates', false)) {
			remove_action('load-update-core.php', 'wp_update_plugins');
			add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
		}
	}
}