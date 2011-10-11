<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\Utils;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Wordpress
{
	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	// Enable delayed activation ( to be used with scb_init() )
	public static function add_activation_hook($file, $callback) {
		register_activation_hook($file, $callback );
	}

	// Have more than one uninstall hooks; also prevents an UPDATE query on each page load
	public static function add_uninstall_hook($file, $callback)
	{
		register_uninstall_hook( $file, '__return_false' );	// dummy

		add_action( 'uninstall_' . plugin_basename( $file ), $callback );
	}

}