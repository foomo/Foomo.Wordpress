<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\OEmbeds;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class SlideShare extends \Foomo\Wordpress\OEmbeds\AbstractOEmbed
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function enableOpenembed()
	{
		wp_oembed_add_provider('#http://(www\.)?slideshare.net/*#i', 'http://www.slideshare.net/api/oembed/1', true);
		wp_oembed_add_provider('http://slidesha.re/*', 'http://www.slideshare.net/api/oembed/1', false);
	}
}