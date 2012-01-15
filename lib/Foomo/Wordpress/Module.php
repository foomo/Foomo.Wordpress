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

	const NAME		= 'Foomo.Wordpress';
	const VERSION	= '3.3.1';

	//---------------------------------------------------------------------------------------------
	// ~ Overriden static methods
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
		return 'foomo WordPress integration module';
	}

	/**
	 * get all the module resources
	 *
	 * @return Foomo\Modules\Resource[]
	 */
	public static function getResources()
	{
		return array(
			\Foomo\Modules\Resource\Module::getResource('Foomo', '0.2.0'),
			\Foomo\Modules\Resource\Config::getResource((null != $module = \Foomo\Modules\Manager::getDocumentRootModule()) ? $module : self::NAME, 'Foomo.Wordpress.config'),
		);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	public static function getWordpressDir()
	{
		return self::getVendorDir('wordpress');
	}

	/**
	 * @return string
	 */
	public static function getMuPluginsDir()
	{
		return self::getHtdocsDir('content/mu-plugins');
	}

	/**
	 * @return string
	 */
	public static function getMuPluginsPath()
	{
		return self::getHtdocsPath('content/mu-plugins');
	}

	/**
	 * @return Foomo\Wordpress\DomainConfig
	 */
	public static function getWordpressConfig()
	{
		return \Foomo\Config::getConf((null != $module = \Foomo\Modules\Manager::getDocumentRootModule()) ? $module : self::NAME, 'Foomo.Wordpress.config');
	}
}
