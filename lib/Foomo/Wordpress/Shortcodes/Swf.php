<?php

/*
 * This file is part of the foomo Opensource Framework.
 *
 * The foomo Opensource Framework is free software: you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public License as
 * published  by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * The foomo Opensource Framework is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along with
 * the foomo Opensource Framework. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Foomo\Wordpress\Shortcodes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Swf extends \Foomo\Wordpress\Shortcodes\AbstractShortcode
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
			'shortcode_swf'	=> array('swf'),
		);
	}

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public function enqueueScripts()
	{
		wp_enqueue_script("swfobject");
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public function shortcode_swf($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('url' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0'), $atts));
		if (is_null($url)) return 'No Url given' ;
		$id = 'swf_' . crc32($url);
		return $this->embed($id, $url, $content, $width, $height, array(), array(), array(), $version);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $id
	 * @param string $url
	 * @param string $content
	 * @param string $width
	 * @param string $height
	 * @param array $attributes
	 * @param array $params
	 * @param array $flashVars
	 * @param string $version
	 * @return string
	 */
	protected function embed($id, $url, $content, $width, $height, $attributes=array(), $params=array(), $flashVars=array(), $version='8.0.0')
	{
		$params = \array_merge(array('allowFullScreen' => 'true', 'scriptAccess' => 'always'), $params);
		$script = 'jQuery(document).ready(function($){swfobject.embedSWF("' . $url . '", "' . $id . '", "' . $width . '", "' . $height . '", "' . $version . '", false, ' . \json_encode((object) $flashVars) . ', ' . \json_encode((object) $params) . ', ' . \json_encode((object) $params) . ')});';
		\Foomo\Wordpress\Frontend::addFooterScript($script);
		return '<div id="' . $id . '" class="swfobject">' . $content . '</div>';
	}
}