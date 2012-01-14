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

namespace Foomo\Wordpress\Module;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Base extends \Foomo\Modules\ModuleBase
{
	//---------------------------------------------------------------------------------------------
	// ~ Overriden static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return array
	 */
	public static function getResources()
	{
		return array(
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FILE, self::getHtdocsDir() . DIRECTORY_SEPARATOR . '.htaccess'),
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, self::getHtdocsDir() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'themes'),
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, self::getHtdocsDir() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'plugins'),
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, self::getHtdocsDir() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'uploads'),
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, self::getHtdocsDir() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'mu-plugins'),
			\Foomo\Modules\Resource\Symlink::getResource('../../../../Foomo.Wordpress/vendor/wordpress/wp-content/themes/twentyeleven', self::getThemesDir() . DIRECTORY_SEPARATOR . 'twentyeleven'),
			\Foomo\Modules\Resource\Symlink::getResource('../../../../Foomo.Wordpress/htdocs/content/mu-plugins/foomo.php', self::getHtdocsDir() . '/content/mu-plugins/foomo.php'),
			\Foomo\Modules\Resource\Symlink::getResource('../../Foomo.Wordpress/htdocs/index.php', self::getHtdocsDir() . '/index.php'),
			\Foomo\Modules\Resource\Module::getResource('Foomo.Wordpress', \Foomo\Wordpress\Module::VERSION),
			\Foomo\Modules\Resource\Config::getResource(self::getModuleName(), 'Foomo.Wordpress.config'),
		);
	}

	/**
	 * Overrides to act as root path
	 * 
	 * @param string $pathname append optional additional relative path
	 * @return string
	 */
	public static function getHtdocsPath($pathname='')
	{
		$ret = DIRECTORY_SEPARATOR;
		if ($pathname != '') $ret .= $pathname;
		return $ret;
	}
	
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	public static function getUploadDir()
	{
		return self::getContentDir() . DIRECTORY_SEPARATOR . 'uploads';
	}

	/**
	 * @return string
	 */
	public static function getUploadPath()
	{
		return self::getContentPath() . DIRECTORY_SEPERATOR . 'uploads';
	}

	/**
	 * @return string
	 */
	public static function getPluginsDir()
	{
		return self::getContentDir() . DIRECTORY_SEPARATOR . 'plugins';
	}

	/**
	 * @return string
	 */
	public static function getPluginsPath()
	{
		return self::getContentPath() . DIRECTORY_SEPARATOR . 'plugins';
	}

	/**
	 * @return string
	 */
	public static function getMuPluginsDir()
	{
		return self::getContentDir() . DIRECTORY_SEPARATOR . 'mu-plugins';
	}

	/**
	 * @return string
	 */
	public static function getMuPluginsPath()
	{
		return self::getContentPath() . DIRECTORY_SEPARATOR . 'mu-plugins';
	}

	/**
	 * @return string
	 */
	public static function getThemesDir()
	{
		return self::getContentDir() . DIRECTORY_SEPARATOR . 'themes';
	}

	/**
	 * @return string
	 */
	public static function getThemesPath()
	{
		return self::getContentPath() . DIRECTORY_SEPARATOR . 'themes';
	}

	/**
	 * @return string
	 */
	public static function getContentDir()
	{
		return self::getHtdocsDir('content');
	}

	/**
	 * @return string
	 */
	public static function getContentPath()
	{
		return self::getHtdocsPath('content');
	}

	/**
	 * @return string
	 */
	public static function getWordpressDir()
	{
		return \Foomo\Wordpress\Module::getWordpressDir();
	}

	/**
	 * @return string
	 */
	public static function getWordpressPath()
	{
		return self::getHtdocsPath('wordpress');
	}
}
