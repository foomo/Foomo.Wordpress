<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\Plugins;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	abstract static function init();

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected static function renderView($template, $model=null)
	{
		$module = \Foomo\Modules\Manager::getModuleByClassName(get_called_class());
		$template = \Foomo\Config::getModuleDir($module) . '/views/' . str_replace('\\', '/', get_called_class()) . '/' . $template . '.tpl';
		$view = \Foomo\View::fromFile($template, $model);
		return $view->render();
	}
}