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
class Module extends \Foomo\Modules\ModuleBase
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	/**
	 * the name of this module
	 */
	const NAME = 'Foomo.Wordpress';
	/**
	 * current wordpress version
	 */
	const WORDPRESS_VERSION = '3.1.3';

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Your module needs to be set up, before being used - this is the place to do it
	 */
	public static function initializeModule()
	{
	}

	/**
	 * Get a plain text description of what this module does
	 *
	 * @return string
	 */
	public static function getDescription()
	{
		return 'Wordpress integration';
	}

	/**
	 * get all the module resources
	 *
	 * @return Foomo\Modules\Resource[]
	 */
	public static function getResources()
	{
		return array(
			\Foomo\Modules\Resource\Module::getResource('Foomo', self::VERSION),
			\Foomo\Modules\Resource\Config::getResource(self::NAME, 'Foomo.Wordpress.config'),
		);
	}

	/**
	 * @return string
	 */
	public static function getPluginsPath()
	{
		return self::getHtdocsPath('plugins');
	}

	/**
	 * @return string
	 */
	public static function getPluginsDir()
	{
		return self::getHtdocsDir('plugins');
	}

	/**
	 * @return string
	 */
	public static function getWordpressPath()
	{
		return self::getHtdocsPath('content');
	}

	/**
	 * @return string
	 */
	public static function getWordpressDir()
	{
		return self::getHtdocsDir('content');
	}

	/**
	 * @return Foomo\Wordpress\DomainConfig
	 */
	public static function getConfig()
	{
		return \Foomo\Config::getConf(self::NAME, 'Foomo.Wordpress.config');
	}
}