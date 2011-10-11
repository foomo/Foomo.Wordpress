<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\Shortcodes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Vimeo extends \Foomo\Wordpress\Shortcodes\Swf
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public function getShortcodes()
	{
		return array(
			'shortcode_vimeo'	=> array('vimeo'),
		);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public function shortcode_vimeo($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('id' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0', 'showtitle' => '0', 'showbyline' => '0', 'showportrait' => '0', 'color' => 'DEB400', 'fullscreen' => '1'), $atts));
		if (is_null($id)) return 'No Vimeo Video ID Set';
		$url = 'http://vimeo.com/moogaloop.swf?';
		$url .= 'clip_id=' . $id . '&';
		$url .= 'server=vimeo.com&';
		$url .= 'color=' . $color . '&';
		$url .= 'fullscreen=' . $fullscreen . '&';
		$url .= 'title=' . $showtitle . '&';
		$url .= 'byline=' . $showbyline . '&';
		$url .= 'portrait=' . $showportrait;
		$id = 'vimeo-' . crc32($url);
		return $this->embed($id, $url, $content, $width, $height, array(), array(), array(), $version);
	}
}