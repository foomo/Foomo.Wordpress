<?php

namespace Foomo\Wordpress;

class DomainConfig extends \Foomo\Config\AbstractConfig
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Wordpress.config';

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