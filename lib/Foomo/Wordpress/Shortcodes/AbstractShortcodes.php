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

namespace Foomo\Wordpress\Shortcodes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractShortcodes
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return array method_name => [shorcodes]
	 */
	abstract static function getShortcodes();
	/**
	 * @see wp_enqueue_script
	 */
	abstract static function enqueueScripts();
	/**
	 * @see wp_enqueue_style
	 */
	abstract static function enqueueStyles();

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Include shortcodes in no_texturize_shortcodes
	 *
	 * @return boolean
	 */
	public static function noTexturize()
	{
		return true;
	}

	/**
	 * Include shortcodes in no_wpautop_shortcodes
	 *
	 * @return boolean
	 */
	public static function noWpautop()
	{
		return true;
	}
}