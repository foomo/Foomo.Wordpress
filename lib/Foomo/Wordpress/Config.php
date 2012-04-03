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
	 * @var string
	 */
	public $lang = 'en_US';
	/**
	 * @var boolean
	 */
	public $cache = false;
	/**
	 * @var boolean
	 */
	public $allowMultiSite = false;
	/**
	 * @var array
	 */
	public $moduleList = array();
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
	/**
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