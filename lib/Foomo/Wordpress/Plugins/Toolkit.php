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
class Toolkit extends \Foomo\Wordpress\Plugins\AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const ID	= 'foomo-toolkit';
	const NAME	= 'Foomo Toolkit';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var Foomo\Wordpress\Settings\Toolkit
	 */
	public $settings;

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function install()
	{
		\Foomo\Wordpress\Settings\Toolkit::setDefaults();
	}

	/**
	 *
	 */
	public function uninstall()
	{
	}

	/**
	 *
	 */
	public function init()
	{
		$options = \Foomo\Wordpress\Settings\Toolkit::getOptions();

		if ($options['disableCoreUpdates']) \Foomo\Wordpress\Admin::disableCoreUpdates();
		if ($options['disablePluginUpdates']) \Foomo\Wordpress\Admin::disablePluginUpdates();

		if ($options['enableShortcodeFoomoRun']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::FOOMO_RUN);
		if ($options['enableShortcodeGithub']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::GITHUB);
		if ($options['enableShortcodeGist']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::GIST);
		if ($options['enableShortcodeGeshi']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::GESHI);

		if ($options['enableShortcodeYoutube']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::YOUTUBE);
		if ($options['enableShortcodeGvideo']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::GVIDEO);
		if ($options['enableShortcodeVimeo']) \Foomo\Wordpress\Shortcodes::register(\Foomo\Wordpress\Shortcodes::VIMEO);
	}
}