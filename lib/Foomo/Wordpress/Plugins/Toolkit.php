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

namespace Foomo\Wordpress\Plugins;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Toolkit extends \Foomo\Wordpress\Plugins\AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const ID = 'foomo-toolkit';
	const NAME = 'Foomo Toolkit Plugin';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var boolean
	 */
	public $disableCoreUpdates = true;
	/**
	 * @var boolean
	 */
	public $disablePluginUpdates = true;
	/**
	 * @var boolean
	 */
	public $enableShortcodes = true;
	/**
	 * @var boolean
	 */
	public $enableTwig = true;

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return string
	 */
	protected function getId()
	{
		return self::ID;
	}

	/**
	 * @return string
	 */
	protected function getName()
	{
		return self::NAME;
	}

	/**
	 * @return string[]
	 */
	protected function getOptions()
	{
		return array(
			'enableTwig',
			'enableShortcodes',
			'disableCoreUpdates',
			'disablePluginUpdates',
		);
	}

	/**
	 *
	 */
	protected function addHooks()
	{
		if ($this->enableShortcodes) new \Foomo\Wordpress\Shortcodes();
		if ($this->enableTwig) new \Foomo\Wordpress\Twig();
	}

	/**
	 *
	 */
	protected function addAdminHooks()
	{
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	/**
	 *
	 */
	protected function run()
	{
		if ($this->disableCoreUpdates) \Foomo\Wordpress\Admin::disableCoreUpdates();
		if ($this->disablePluginUpdates) \Foomo\Wordpress\Admin::disablePluginUpdates();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Hooks
	//---------------------------------------------------------------------------------------------

    /**
     * Registeres the menu
     */
	public function admin_menu()
    {
		add_options_page(self::NAME, 'Foomo Toolkit', 'manage_options', self::ID, array($this, 'add_options_page'));
	}

    /**
     * Returns admin menu options
     */
	public function add_options_page()
    {
		$params = array();

		# save data
		switch (true) {
			case (isset($_POST['adminSettingsSubmit'])):
				$this->disableCoreUpdates = (isset($_POST['disableCoreUpdates']) && $_POST['disableCoreUpdates'] = 'on');
				$this->disablePluginUpdates = (isset($_POST['disablePluginUpdates']) && $_POST['disablePluginUpdates'] = 'on');
				$this->saveOptions();
				$params['message'] = __('Options Saved.', self::NAME);
				break;
			case (isset($_POST['themingSettingsSubmit'])):
				$this->enableTwig = (isset($_POST['enableTwig']) && $_POST['enableTwig'] = 'on');
				$this->enableShortcodes = (isset($_POST['enableShortcodes']) && $_POST['enableShortcodes'] = 'on');
				$this->saveOptions();
				$params['message'] = __('Options Saved.', self::NAME);
				break;
		}

		# load options
		$params['options'] = $this->loadOptions();

		# render view
		echo $this->renderView('admin', $params);
	}
}