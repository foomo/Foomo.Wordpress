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
	 * @var type
	 */
	private $file;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private function __construct($file)
	{
		$this->file = $file;
		add_action('activate_' . $this->getPluginBasename(), array(&$this, 'install'));
		add_action('deactivate_' . $this->getPluginBasename(), array(&$this, 'uninstall'));
		add_action('init', array(&$this, 'init'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	abstract public function install();

	/**
	 *
	 */
	abstract public function uninstall();

	/**
	 *
	 */
	abstract public function init();

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

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

	/**
	 * @return string
	 */
	protected function getPluginBasename()
	{
		return basename(dirname($this->file)) . '/' . basename($this->file);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return Foomo\Wordpress\Plugins\AbstractPlugin
	 */
	public static function setup($file)
	{
		$class = self::getClass();
		return new $class($file);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Protected static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	protected static function getCacheDir()
	{
		return WP_CONTENT_DIR . '/' . self::getId();
	}

	/**
	 * @return string
	 */
	protected static function getId()
	{
		return self::getConstant('ID');
	}

	/**
	 * @return string
	 */
	protected static function getName()
	{
		return self::getConstant('NAME');
	}

	/**
	 * @return string defined constant
	 */
	protected static function getConstant($name)
	{
		return constant(get_called_class() . '::' . $name);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	private static function getClass()
	{
		return get_called_class();
	}
}