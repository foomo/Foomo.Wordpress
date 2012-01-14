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

namespace Foomo\Wordpress\Theme;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Base
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	public static $name;
	
	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Initialize your theme:
	 * 
	 * register_nav_menu('your-menu-handle', 'Your Menu Label');
	 * add_theme_support('post-thumbnails', array('post', 'page', 'cpt'));
	 * add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	 * add_theme_support('automatic-feed-links');
	 * add_theme_support('admin-nar');
	 * 
	 * @param string $name
	 */
	public static function init($name)
	{
		self::$name = $name;
		\Foomo\Wordpress\Utils::registerHooks(\get_called_class());
	}
	
	/**
	 * @return string
	 */
	public static function getThemeDir()
	{
		$module = \str_replace('.', '\\', \Foomo\Modules\Manager::getClassModule(\get_called_class())) . '\\Module';
		return call_user_func($module . '::getThemesDir') . DIRECTORY_SEPARATOR . self::$name;
	}
	
	/**
	 * @param boolean $prefixServer
	 * @param boolean $requireSSL
	 * @param boolean $addCredentials
	 * @return string
	 */
	public static function getThemePath($prefixServer=false, $requireSSL=false, $addCredentials=false)
	{
		$module = \str_replace('.', '\\', \Foomo\Modules\Manager::getClassModule(\get_called_class())) . '\\Module';
		$path = call_user_func($module . '::getThemesPath') . DIRECTORY_SEPARATOR . self::$name;
		return ($prefixServer) ? \Foomo\Utils::getServerUrl($requireSSL, $addCredentials) . $path : $path;
	}
}