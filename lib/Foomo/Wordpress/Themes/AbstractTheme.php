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

namespace Foomo\Wordpress\Themes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractTheme
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function __construct()
	{
		$admin = is_admin();
		$this->registerHoocks($admin);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	abstract function registerHoocks($admin);

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	protected function includeTextdomain($domain)
	{
		load_theme_textdomain($domain, TEMPLATEPATH . '/languages' );
		#$locale_file = TEMPLATEPATH . '/languages/' . get_locale() . '.php';
		#if (is_readable($locale_file)) require_once($locale_file);
	}

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected function renderView($template, $model=null)
	{
		$module = \Foomo\Modules\Manager::getModuleByClassName(get_called_class());
		$template = \Foomo\Config::getModuleDir($module) . '/views/' . str_replace('\\', '/', get_called_class()) . '/' . $template . '.tpl';
		$view = \Foomo\View::fromFile($template, $model);
		return $view->render();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Protected static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string defined constant
	 */
	protected static function getConstant($name)
	{
		return (!$name = constant(get_called_class() . '::' . $name)) ? str_replace('\\', '.', get_called_class()) : $name;
	}
}