<?php

namespace Foomo\Wordpress;

class Config extends \Foomo\Config\AbstractConfig
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const NAME = 'Foomo.Wordpress.config';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------
	
	/**
	 * Additional definitions
	 * 
	 * @var array
	 */
	public $settings = array(
		'WPLANG' => 'en_US',
		'WP_CACHE' => false,
		'WP_ALLOW_MULTISITE' => false
	);
	/**
	 * Modules to autoload wordpress hooks
	 * 
	 * @var array
	 */
	public $modules = array();
	/**
	 * Database connection settings
	 * 
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
	/**
	 * Securtiy keys
	 * 
	 * @var array
	 */
	public $security = array(
		'authKey' => '',
		'secureAuthKey' => '',
		'loggedInKey' => '',
		'nonceKey' => '',
		'authSalt' => '',
		'secureAuthSalt' => '',
		'loggedInSalt' => '',
		'nonceSalt' => '',
	);
}