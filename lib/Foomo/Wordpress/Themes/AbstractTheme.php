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
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	protected $id;
	protected $name;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
		\Foomo\Wordpress\Utils\Hooks::register($this);
		$this->setup();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	abstract function setup();
	
	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	protected function includeTextdomain($domain)
	{
		load_theme_textdomain($domain, $this->getThemePath() . '/languages' );
	}

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected function renderView($template, $model=null)
	{
		return \Foomo\Wordpress\View::render(get_called_class(), $template, $model);
	}
}