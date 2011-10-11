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
class Gvideo extends \Foomo\Wordpress\Shortcodes\Swf
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
			'shortcode_gvideo'	=> array('gvideo'),
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
	public static function shortcode_gvideo($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('id' => null, 'url' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0'), $atts));
		if (is_null($id)) return 'No GVideo Video ID Set';
		$url = 'http://video.google.com/googleplayer.swf?docId=' . $id;
		$id = 'gvideo-' . crc32($url);
		return $this->embed($id, $url, $content, $width, $height, array(), array(), array(), $version);
	}
}