<?php
namespace Wordpress;

use Foomo\Modules\ModuleBase;

/**
 * Module Wordpress for foomo
 */
class Module extends ModuleBase
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	/**
	 * the name of this module
	 */
	const NAME = 'Wordpress';
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
		return array();
	}

	/**
	 * @return string
	 */
	public static function getHtdocsPath()
	{
		return \Foomo\ROOT_HTTP . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . self::NAME;
	}

	/**
	 * @return string
	 */
	public static function getHtdocsDir()
	{
		return \Foomo\CORE_CONFIG_DIR_MODULES . DIRECTORY_SEPARATOR . self::NAME . DIRECTORY_SEPARATOR . 'htdocs';
	}
}