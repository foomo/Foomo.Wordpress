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
class Media extends AbstractShortcodes
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public static function getShortcodes()
	{
		return array(
			'shortcode_youtube'	=> array('youtube'),
			'shortcode_gvideo'	=> array('gvideo'),
			'shortcode_vimeo'	=> array('vimeo'),
			'shortcode_swf'		=> array('swf')
		);
	}

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public static function enqueueScripts()
	{
		wp_enqueue_script('swfobject');
	}

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public static function enqueueStyles()
	{

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
	public static function shortcode_swf($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('url' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0', 'fullscreen' => '1'), $atts));
		if (is_null($url)) return 'No Url given' ;
		$containerId = 'swf-' . crc32($url);
		$expressInstallSWF = \Foomo\Flash\Module::getHtdocsPath('swf') . '/expressInsall.swf';
		$flashVars = new \Foomo\Flash\SwfObject2\FlashVars();
		$params = new \Foomo\Flash\SwfObject2\Params();
		$params->allowFullScreen(($fullscreen == '1'));
		$params->quality(\Foomo\Flash\SwfObject2\Params::QUALITY_AUTO_HIGH);
		$params->allowScriptAccess(\Foomo\Flash\SwfObject2\Params::ALLLOW_SCRIPT_ACCESS_ALWAYS);
		$attributes = new \Foomo\Flash\SwfObject2\Attributes();
		$attributes->id($containerId);
		$attributes->name($containerId);
		$attributes->styleclass('swfobject swf');
		$so = new \Foomo\Flash\SWFObject2($url, $containerId, $width, $height, $version, $expressInstallSWF, $flashVars, $params, $attributes);
		\Foomo\Wordpress::addFooterScript($so->embedSWF());
		return '<div id="' . $containerId . '" class="swfobject video gvideo">' . $content . '</div>';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function shortcode_youtube($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('id' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0', 'fullscreen' => '1'), $atts));
		if (is_null($id)) return 'No YouTube Video ID Set';
		$containerId = 'youtube-' . $id;
		$expressInstallSWF = \Foomo\Flash\Module::getHtdocsPath('swf') . '/expressInsall.swf';
		$flashVars = new \Foomo\Flash\SwfObject2\FlashVars();
		$params = new \Foomo\Flash\SwfObject2\Params();
		$params->allowFullScreen(($fullscreen == '1'));
		$params->quality(\Foomo\Flash\SwfObject2\Params::QUALITY_AUTO_HIGH);
		$params->allowScriptAccess(\Foomo\Flash\SwfObject2\Params::ALLLOW_SCRIPT_ACCESS_ALWAYS);
		$attributes = new \Foomo\Flash\SwfObject2\Attributes();
		$attributes->id($containerId);
		$attributes->name($containerId);
		$attributes->styleclass('swfobject youtube');
		$swf = 'http://www.youtube.com/v/' . $id;
		$so = new \Foomo\Flash\SWFObject2($swf, $containerId, $width, $height, $version, $expressInstallSWF, $flashVars, $params, $attributes);
		\Foomo\Wordpress::addFooterScript($so->embedSWF());
		return '<div id="' . $containerId . '" class="swfobject video youtube">' . $content . '</div>';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function shortcode_gvideo($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('id' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0', 'fullscreen' => '1'), $atts));
		if (is_null($id)) return 'No Google Video ID Set';
		$containerId = 'gvideo-' . $id;
		$expressInstallSWF = \Foomo\Flash\Module::getHtdocsPath('swf') . '/expressInsall.swf';
		$flashVars = new \Foomo\Flash\SwfObject2\FlashVars();
		$params = new \Foomo\Flash\SwfObject2\Params();
		$params->allowFullScreen(($fullscreen == '1'));
		$params->quality(\Foomo\Flash\SwfObject2\Params::QUALITY_AUTO_HIGH);
		$params->allowScriptAccess(\Foomo\Flash\SwfObject2\Params::ALLLOW_SCRIPT_ACCESS_ALWAYS);
		$attributes = new \Foomo\Flash\SwfObject2\Attributes();
		$attributes->id($containerId);
		$attributes->name($containerId);
		$attributes->styleclass('swfobject gvideo');
		$swf = 'http://video.google.com/googleplayer.swf?docId=' . $id;
		$so = new \Foomo\Flash\SWFObject2($swf, $containerId, $width, $height, $version, $expressInstallSWF, $flashVars, $params, $attributes);
		\Foomo\Wordpress::addFooterScript($so->embedSWF());
		return '<div id="' . $containerId . '" class="swfobject video gvideo">' . $content . '</div>';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function shortcode_vimeo($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('id' => null, 'width' => '400', 'height' => '325', 'version' => '8.0.0', 'showtitle' => '0', 'showbyline' => '0', 'showportrait' => '0', 'color' => 'DEB400', 'fullscreen' => '1'), $atts));
		if (is_null($id)) return 'No Vimeo Video ID Set';
		$containerId = 'vimeo-' . $id;
		$expressInstallSWF = \Foomo\Flash\Module::getHtdocsPath('swf') . '/expressInsall.swf';
		$flashVars = new \Foomo\Flash\SwfObject2\FlashVars();
		$params = new \Foomo\Flash\SwfObject2\Params();
		$params->allowFullScreen(($fullscreen == '1'));
		$params->quality(\Foomo\Flash\SwfObject2\Params::QUALITY_AUTO_HIGH);
		$params->allowScriptAccess(\Foomo\Flash\SwfObject2\Params::ALLLOW_SCRIPT_ACCESS_ALWAYS);
		$attributes = new \Foomo\Flash\SwfObject2\Attributes();
		$attributes->id($containerId);
		$attributes->name($containerId);
		$attributes->styleclass('swfobject vimeo');
		$swf = 'http://vimeo.com/moogaloop.swf?';
		$swf .= 'clip_id=' . $id . '&';
		$swf .= 'server=vimeo.com&';
		$swf .= 'color=' . $color . '&';
		$swf .= 'fullscreen=' . $fullscreen . '&';
		$swf .= 'title=' . $showtitle . '&';
		$swf .= 'byline=' . $showbyline . '&';
		$swf .= 'portrait=' . $showportrait;
		$so = new \Foomo\Flash\SWFObject2($swf, $containerId, $width, $height, $version, $expressInstallSWF, $flashVars, $params, $attributes);
		\Foomo\Wordpress::addFooterScript($so->embedSWF());
		return '<div id="' . $containerId . '" class="swfobject video vimeo">' . $content . '</div>';
	}
}