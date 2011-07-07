<?php

namespace Foomo\Wordpress\Site;

class Config extends \Foomo\Config\AbstractConfig
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Wordpress.siteConfig';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	public $database = array(
		'name' => 'databasename',
		'username' => 'username',
		'password' => 'password',
		'host' => 'localhost',
		'charset' => 'utf8',
		'collate' => '',
		'prefix' => 'wp_'
	);
}