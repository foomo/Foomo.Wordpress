<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Utils
{

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function disableCoreUpdates()
	{
		add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
	}

	/**
	 *
	 */
	public static function disablePluginUpdates()
	{
		remove_action( 'load-update-core.php', 'wp_update_plugins' );
		add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public static function decodeHtmlEntities($value)
	{
		$trans_tbl['&#8216;'] = '"';
		$trans_tbl['&#8217;'] = '"';
		$trans_tbl['&#8220;'] = '"';
		$trans_tbl['&#8221;'] = '"';
		return strtr($value, $trans_tbl);
	}
}