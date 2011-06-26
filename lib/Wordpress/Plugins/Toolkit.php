<?php

namespace Wordpress\Plugins;

class Toolkit
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const name = 'foomo-toolkit';
	const title = 'Foomo Toolkit Plugin';

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
		$this->_loadOptions();

		# load language
		load_textdomain(self::name, WPP_UTILS_PATH . '/locales/' . get_locale() . '.mo');
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