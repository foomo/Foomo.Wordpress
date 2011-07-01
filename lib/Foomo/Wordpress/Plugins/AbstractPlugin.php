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
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string[]
	 */
	private $options = array();


	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function __construct()
	{
        # get options
		$this->init();
		$this->options = $this->getOptions();
		$this->loadOptions();
		if (is_admin()) $this->addAdminHooks();
		$this->addHooks();
		$this->run();
	}


	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	abstract protected function getId();

	/**
	 * @return string
	 */
	abstract protected function getName();

	/**
	 * @return string[]
	 */
	abstract protected function getOptions();

	/**
	 *
	 */
	abstract protected function addHooks();

	/**
	 *
	 */
	abstract protected function addAdminHooks();

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	protected function init()
	{

	}

	/**
	 *
	 */
	protected function run()
	{
	}

    /**
     * Get options
     */
	protected function loadOptions()
    {
		$options = get_option($this->getId());
		if ($options !== false) {
			foreach ($this->options as $option) $this->$option = $options[$option];
		} else {
			$this->saveOptions();
			$options = get_option($this->getId());
		}
		return $options;
	}

    /**
     * Set options
     */
	protected function saveOptions()
	{
		$options = array();
		foreach ($this->options as $option) $options[$option] = $this->$option;
		update_option($this->getId(), $options);
	}

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected function renderView($template, $model=null)
	{
		$template = \Foomo\Wordpress\Module::getBaseDir('views/' . str_replace('\\', '/', get_called_class())) . '/' . $template . '.tpl';
		$view = \Foomo\View::fromFile($template, $model);
		return $view->render();
	}
}