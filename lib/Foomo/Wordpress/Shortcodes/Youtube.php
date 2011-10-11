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
class Youtube extends \Foomo\Wordpress\Shortcodes\Swf
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
			'shortcode_youtube'	=> array('youtube'),
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
	public function shortcode_youtube($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('id' => null, 'url' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0'), $atts));
		if (is_null($id)) return 'No YouTube Video ID Set';
		$url = 'http://www.youtube.com/v/' . $id;
		$id = 'youtube-' . crc32($url);
		return $this->embed($id, $url, $content, $width, $height, array(), array(), array(), $version);
	}
}