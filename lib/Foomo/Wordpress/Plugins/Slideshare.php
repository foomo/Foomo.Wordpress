<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\Plugins;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Slideshare extends AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function init()
	{
		wp_oembed_add_provider('#http://(www\.)?slideshare.net/*#i', 'http://www.slideshare.net/api/oembed/1', true);
	}
}