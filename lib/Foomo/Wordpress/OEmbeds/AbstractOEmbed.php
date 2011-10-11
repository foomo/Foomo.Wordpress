<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\OEmbeds;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractOEmbed
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private static $registered = array();

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
		add_action('init', array($this, 'enableOpenembed'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	abstract public function enableOpenembed();

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return boolean
	 */
	public static function register()
	{
		$className = \get_called_class();
		if (isset(self::$registered[$className])) return false;
		self::$registered[$className] = func_get_args();
		add_action('_foomo_oembeds_loaded', array(__CLASS__, '_foomo_oembeds_loaded'));
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
	public static function _foomo_oembeds_loaded()
	{
		foreach (self::$registered as $className => $args) \Foomo\Reflection\Utils::createInstance($className, $args);
	}
}