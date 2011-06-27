<?php

namespace Wordpress\Plugins;

class Toolkit
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'foomo-toolkit';
	const TITLE = 'Foomo Toolkit Plugin';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string[]
	 */
	private $options = array(
		'option',
	);

	//---------------------------------------------------------------------------------------------
	// ~ Options
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	private $option;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
        # get options
		#$this->_loadOptions();

		add_shortcode('foomo_run', array($this, 'foomo_run_shortcode_handler'));
	}

	/**
	 * @see http://codex.wordpress.org/Shortcode_API
	 *
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public function foomo_run_shortcode_handler($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('app' => null), $atts));
		if (is_null($app)) return null;
		$baseUrl = str_replace(home_url(), '', get_permalink($post->ID));
		if (substr($baseUrl, -1) == '/') $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);
		return \Foomo\MVC::run($app, $baseUrl);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

    /**
     * Get options
     */
	private function _loadOptions()
    {
		$options = get_option(self::name);
		if ($options !== false) {
			foreach ($this->options as $option) $this->$option = $options[$option];
		} else {
			$this->_loadOptions();
			$options = get_option(self::name);
		}
		return $options;
	}
    /**
     * Set options
     */
	private function _saveOptions()
	{
		$options = array();
		foreach ($this->options as $option) $options[$option] = $this->$option;
		update_option(self::name, $options);
	}

}