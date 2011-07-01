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
	public $coreUpdatesDisabled = false;
	/**
	 * @var boolean
	 */
	public $pluginUpdatesDisabled = false;

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
			'coreUpdatesDisabled',
			'pluginUpdatesDisabled',
		);
	}

	/**
	 *
	 */
	protected function addHooks()
	{
		add_shortcode('foomo-run', array($this, 'foomo_run_shortcode_handler'));
	}

	/**
	 *
	 */
	protected function addAdminHooks()
	{
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}

	/**
	 *
	 */
	protected function run()
	{
		if ($this->coreUpdatesDisabled)	\Foomo\Wordpress\Utils::disableCoreUpdates();
		if ($this->coreUpdatesDisabled)	\Foomo\Wordpress\Utils::disablePluginUpdates();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Hooks
	//---------------------------------------------------------------------------------------------

    /**
     * Registeres the menu
     */
	public function admin_menu()
    {
		add_options_page(self::NAME, 'Foomo Toolkit', 'manage_options', self::ID, array(&$this, 'add_options_page'));
	}

    /**
     * Returns admin menu options
     */
	public function add_options_page()
    {
		$params = array();

		# save data
		switch (true) {
			case (isset($_POST['disableUpdatesSubmit'])):
				$this->coreUpdatesDisabled = (isset($_POST['coreUpdatesDisabled']) && $_POST['coreUpdatesDisabled'] = 'on');
				$this->pluginUpdatesDisabled = (isset($_POST['pluginUpdatesDisabled']) && $_POST['pluginUpdatesDisabled'] = 'on');
				$this->saveOptions();
				$params['message'] = __('Options Saved.', self::NAME);
				break;
		}

		# load options
		$params['options'] = $this->loadOptions();

		# render view
		echo $this->renderView('admin', $params);
	}

	/**
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public function foomo_run_shortcode_handler($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('app' => null), $atts));

		if (is_null($app)) return null;

		if (!is_null($content)) {
			# read content
			$json = stripslashes(\Foomo\Wordpress\Utils::decodeHtmlEntities($content));
			$content = json_decode($json, true);
			if (is_null($content)) trigger_error('Could not decode ' . $content, E_USER_WARNING);

			# get reflection
			$appClass = new \ReflectionClass($app);
			$method = $appClass->getMethod('__construct');
			$methodParms = $method->getParameters();

			# set parameters
			if (count($methodParms) > 0) {
				# order parms
				$appParams = array();
				foreach ($methodParms as $methodParm) {
					$appParams[] = (isset($content[$methodParm->name])) ? $content[$methodParm->name] : null;
				}
				# create instance
				$app = $appClass->newInstanceArgs($appParams);
			}
		}

		$baseUrl = str_replace(home_url(), '', get_permalink($post->ID));
		if (substr($baseUrl, -1) == '/') $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);

		return \Foomo\MVC::run($app, $baseUrl . '/?');
	}
}