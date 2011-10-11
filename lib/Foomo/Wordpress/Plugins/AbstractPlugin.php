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
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private static $registered = array();

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	protected $file;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function __construct($file)
	{
		$this->file = $file;
		$this->setup();
		\Foomo\Wordpress\Utils\Hooks::register($this);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	abstract public function setup();

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $plugin
	 * @return string
	 */
	protected function getPluginPath($plugin)
	{
		return \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath() . '/' . $plugin;
	}

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected function renderView($template, $model=null)
	{
		return \Foomo\Wordpress\View::render(get_class($this), $template, $model);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $file
	 * @return boolean
	 */
	public static function register($file)
	{
		$className = \get_called_class();
		if (isset(self::$registered[$className])) return false;
		self::$registered[$className] = func_get_args();
		add_action('_foomo_plugins_loaded', array(__CLASS__, '_foomo_plugins_loaded'));
		return true;
	}

	/**
	 * @param string $oldClassName
	 * @param string $newClassName
	 * @return boolean
	 */
	public static function replace($oldClassName, $newClassName)
	{
		if (!isset(self::$registered[$oldClassName])) return false;
		self::$registered[$newClassName] = self::$registered[$oldClassName];
		unset(self::$registered[$oldClassName]);
		return true;
	}

	/**
	 * @param string $className
	 * @return boolean
	 */
	public static function remove($className)
	{
		if (!isset(self::$registered[$className])) return false;
		unset(self::$registered[$className]);
		return true;
	}

	/**
	 * @internal
	 */
	public static function _foomo_plugins_loaded()
	{
		foreach (self::$registered as $className => $args) \Foomo\Reflection\Utils::createInstance($className, $args);
	}
}