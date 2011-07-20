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

namespace Foomo\Wordpress\Modules;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class ModuleBase extends \Foomo\Modules\ModuleBase
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	public static function getResources()
	{
		return array(
			\Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'tmp' . DIRECTORY_SEPARATOR . self::getModuleName()),
			\Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'modules' . DIRECTORY_SEPARATOR . self::getModuleName() . DIRECTORY_SEPARATOR . 'db'),
			\Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'htdocs' . DIRECTORY_SEPARATOR . 'modulesVar' . DIRECTORY_SEPARATOR . self::getModuleName() . DIRECTORY_SEPARATOR . 'cache'),
			\Foomo\Modules\Resource\Fs::getVarResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, 'htdocs' . DIRECTORY_SEPARATOR . 'modulesVar' . DIRECTORY_SEPARATOR . self::getModuleName() . DIRECTORY_SEPARATOR . 'uploads'),
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, self::getHtdocsDir() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'themes'),
			\Foomo\Modules\Resource\Fs::getAbsoluteResource(\Foomo\Modules\Resource\Fs::TYPE_FOLDER, self::getHtdocsDir() . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'plugins'),
			\Foomo\Modules\Resource\Symlink::getResource('../../../../Foomo.Wordpress/htdocs/content/wp-content/themes/twentyten', self::getThemesDir() . DIRECTORY_SEPARATOR . 'twentyten'),
			\Foomo\Modules\Resource\Symlink::getResource('../../../../Foomo.Wordpress/htdocs/plugins/foomo-toolkit', self::getPluginsDir() . DIRECTORY_SEPARATOR . 'foomo-toolkit'),
			\Foomo\Modules\Resource\Symlink::getResource('../../Foomo.Wordpress/htdocs/content', self::getWordpressDir()),
			\Foomo\Modules\Resource\Config::getResource(self::getModuleName(), 'Foomo.Wordpress.siteConfig'),
		);
	}

	/**
	 * @return string
	 */
	public static function getDbDir()
	{
		return self::getVarDir('db');
	}

	/**
	 * @return string
	 */
	public static function getUploadDir()
	{
		return self::getHtdocsVarDir('uploads');
	}

	/**
	 * @return string
	 */
	public static function getUploadPath()
	{
		return self::getHtdocsVarPath('uploads');
	}

	/**
	 * @return string
	 */
	public static function getCacheDir()
	{
		return self::getHtdocsVarDir('cache');
	}

	/**
	 * @return string
	 */
	public static function getCachePath()
	{
		return self::getHtdocsVarPath('cache');
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
	public static function getThemesDir()
	{
		return self::getContentDir() . DIRECTORY_SEPARATOR . 'themes';
	}

	/**
	 * @return string
	 */
	public static function getThemesPath()
	{
		return self::getHtdocsPath('themes');
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
		return self::getHtdocsDir('wordpress');
	}

	/**
	 * @return string
	 */
	public static function getWordpressPath()
	{
		return self::getHtdocsPath('wordpress');
	}

	/**
	 * @param string $pathname append optional additional relative path
	 * @return string
	 */
	public static function getHtdocsPath($pathname='')
	{
		$ret = DIRECTORY_SEPARATOR;
		if ($pathname != '') $ret .= $pathname;
		return $ret;
	}
}