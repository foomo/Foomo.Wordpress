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

namespace Foomo\Wordpress;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Shortcodes
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const FOOMO_RUN		= 'foomo_run';
	const GITHUB		= 'github';
	const GESHI			= 'geshi';
	const GIST			= 'gist';
	const BBCODE		= 'bbcode';
	const GVIDEO		= 'gvideo';
	const VIMEO			= 'vimeo';
	const YOUTUBE		= 'youtube';

	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	private static $enabled = array();

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function register($shortcode)
	{
		$shortcode = strtolower($shortcode);
		if (in_array($shortcode, self::$enabled)) return;
		switch ($shortcode) {
			case self::FOOMO_RUN:
			case self::GESHI:
			case self::GIST:
			case self::GITHUB:
			case self::YOUTUBE:
			case self::GVIDEO:
			case self::VIMEO:
				add_shortcode($shortcode, array(__CLASS__, $shortcode));
				self::$enabled[] = $shortcode;
				break;
			case self::BBCODE:
				add_shortcode('b', array(__CLASS__, 'bbcode'));
				add_shortcode('i', array(__CLASS__, 'bbcode'));
				add_shortcode('u', array(__CLASS__, 'bbcode'));
				add_shortcode('url', array(__CLASS__, 'bbcode'));
				add_shortcode('img', array(__CLASS__, 'bbcode'));
				add_shortcode('quote', array(__CLASS__, 'bbcode'));
				add_shortcode('color', array(__CLASS__, 'bbcode'));
				add_shortcode('s', array(__CLASS__, 'bbcode'));
				add_shortcode('center', array(__CLASS__, 'bbcode'));
				add_shortcode('code', array(__CLASS__, 'bbcode'));
				add_shortcode('size', array(__CLASS__, 'bbcode'));
				add_shortcode('ul', array(__CLASS__, 'bbcode'));
				add_shortcode('ol', array(__CLASS__, 'bbcode'));
				add_shortcode('li', array(__CLASS__, 'bbcode'));
				self::$enabled[] = $shortcode;
				break;
		}
		if (count(self::$enabled) == 1) add_filter('no_texturize_shortcodes', array(__CLASS__, 'no_texturize_shortcodes'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Internal static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function foomo_run($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('app' => null), $atts));

		if (is_null($app)) return null;

		if (!is_null($content)) {
			# read content
			$json = stripslashes(self::decodeHtmlEntities($content));
			$content = json_decode($json, true);
			if (is_null($content)) trigger_error('Could not decode ' . $content, E_USER_WARNING);

			# get reflection
			$appClass = new \ReflectionClass($app);
			$method = $appClass->getMethod('__construct');
			$methodParms = $method->getParameters();

			# set parameters
			if (count($methodParms) > 0) {
				# order parms
				$appParams = array();
				foreach ($methodParms as $methodParm) {
					$appParams[] = (isset($content[$methodParm->name])) ? $content[$methodParm->name] : null;
				}
				# create instance
				$app = $appClass->newInstanceArgs($appParams);
			}
		}

		$baseUrl = str_replace(home_url(), '', get_permalink($post->ID));
		if (substr($baseUrl, -1) == '/') $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);

		return \Foomo\MVC::run($app, $baseUrl . '/?');
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function gist($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('id' => null, 'ttl' => '1 day', 'lang' => 'php'), $atts));

		if (is_null($id)) return null;
		$url = 'https://raw.github.com/gist/' . $id . '/';

		$classes = array('geshi', 'remote-file', 'gist', 'language-' . $lang);

		$geshi = new \GeSHi(\Foomo\Wordpress\RemoteFile::getFile($url, $ttl), $lang);

		return str_replace(array('<pre class="' . $lang . '"'), array('<pre class="' . implode(' ', $classes) . '"'), $geshi->parse_code());
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function github($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('url' => null, 'ttl' => '1 day', 'lang' => 'php'), $atts));

		if (is_null($url)) return null;

		$url .= '?raw=true';

		$classes = array('geshi', 'remote-file', 'github', 'language-' . $lang);

		$geshi = new \GeSHi(\Foomo\Wordpress\RemoteFile::getFile($url, $ttl), $lang);

		return str_replace(array('<pre class="' . $lang . '"'), array('<pre class="' . implode(' ', $classes) . '"'), $geshi->parse_code());
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function geshi($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('lang' => 'php'), $atts));

		if (is_null($content)) return null;

		$content = str_replace('<br />', '', $content);
		$content = trim($content);


		$classes = array('geshi', 'language-' . $lang);

		$geshi = new \GeSHi($content, $lang);

		return str_replace(array('<pre class="' . $lang . '"'), array('<pre class="' . implode(' ', $classes) . '"'), $geshi->parse_code());
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function bbcode($atts, $content=null, $code="")
	{
		if (is_null($content)) return '';
		$hasAtts = (is_array($atts) && !empty($atts));

		switch (strtolower($code)) {
			case 'b':
				return '<b>' . do_shortcode($content) . '</b>';
				break;
			case 'i':
				return '<em>' . do_shortcode($content) . '</em>';
				break;
			case 'u':
				return '<span style="text-decoration:unterline">' . do_shortcode($content) . '</span>';
				break;
			case 'url':
				return '<a' . self::parseAttributes($atts) . '/>' . do_shortcode($content) . '</a>';
				break;
			case 'img':
				return '<img' . self::parseAttributes($atts) . '/>';
				break;
			case 'quote':
				return '<blockquote' . self::parseAttributes($atts) . '>' . do_shortcode($content) . '</blockquote>';
				break;
			case 'color':
				$color = (isset($atts['color'])) ? $atts['color'] : '#f00';
				return '<font style="color:' . $color .'">' . do_shortcode($content) . '</font>';
				break;
			case 'del':
				return '<del>' . do_shortcode($content) . '</del>';
				break;
			case 'center':
				return '<center>' . do_shortcode($content) . '</center>';
				break;
			case 'code':
				return '<code' . self::parseAttributes($atts) . '>' . do_shortcode($content) . '</code>';
				break;
			case 'code':
				$size = (isset($atts['size'])) ? $atts['size'] : '13';
				return '<span style="font-size:' . $size . 'px">' . do_shortcode($content) . '</span>';
				break;
			case 'ol':
				return '<ol' . self::parseAttributes($atts) . '>' . do_shortcode($content) . '</ol>';
				break;
			case 'ol':
				return '<ol' . self::parseAttributes($atts) . '>' . do_shortcode($content) . '</ol>';
				break;
			case 'li':
				return '<li' . self::parseAttributes($atts) . '>' . do_shortcode($content) . '</li>';
				break;
		}
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function youtube($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('width' => '400', 'height' => '325', 'fullscreen' => 'true'), $atts));
		if (is_null($content)) return 'No YouTube Video ID Set';
		return '
			<object width="' . $width . '" height="' . $height . '">
				<param name="allowfullscreen" value="' . $fullscreen . '"></param>
				<param name="movie" value="http://www.youtube.com/v/' .$content . '"></param>
				<embed src="http://www.youtube.com/v/' . $content . '" type="application/x-shockwave-flash" width="' . $width .'" height="' . $height . '" allowfullscreen="' . $fullscreen . '"></embed>
			</object>
		';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function gvideo($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('width' => '400', 'height' => '325', 'fullscreen' => 'true', 'lang' => 'en'), $atts));
		if (is_null($content)) return 'No Google Video ID Set';
		return '
			<object width="' . $width . '" height="' . $height . '">
				<param name="allowfullscreen" value="' . $fullscreen . '"></param>
				<param name="movie" value="http://video.google.com/googleplayer.swf?docId=' .$content . '&hl=' . $lang . '"></param>
				<embed src="http://video.google.com/googleplayer.swf?docId=' . $content . '&hl=' . $lang . '" type="application/x-shockwave-flash" width="' . $width .'" height="' . $height . '" allowfullscreen="' . $fullscreen . '"></embed>
			</object>
		';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function vimeo($atts, $content=null, $code="")
	{
		trigger_error($content);
		extract(shortcode_atts(array('width' => '400', 'height' => '325', 'fullscreen' => 'true', 'lang' => 'en'), $atts));
		if (is_null($content)) return 'No Vimeo Video ID Set';
		return '
			<object width="' . $width . '" height="' . $height . '">
				<param name="allowfullscreen" value="' . $fullscreen . '"></param>
				<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=' . $content . '&server=vimeo.com&show_title=1&show_byline=1&show_portrait=0&color=ff9933&fullscreen=1"></param>
				<embed src="http://vimeo.com/moogaloop.swf?clip_id=' . $content . '&server=vimeo.com&show_title=1&show_byline=1&show_portrait=0&color=ff9933&fullscreen=1" type="application/x-shockwave-flash" width="' . $width .'" height="' . $height . '" allowfullscreen="' . $fullscreen . '"></embed>
			</object>
		';
	}

	/**
	 * @param array $shortcodes_arr
	 * @return string
	 */
	public static function no_texturize_shortcodes($shortcodes)
	{
		return array_merge($shortcodes, self::$enabled);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param array $atts
	 * @return array
	 */
	private static function parseAttributes($atts)
	{
		$ret = array();
		foreach ($atts as $key => $value) $ret[] = $key . '="' . $value . '"';
		return (!empty($ret)) ? ' ' . implode(' ', $ret) : '';
	}

	/**
	 * @param string $string
	 * @return string
	 */
	private static function decodeHtmlEntities($value)
	{
		$trans_tbl['&#8216;'] = '"';
		$trans_tbl['&#8217;'] = '"';
		$trans_tbl['&#8220;'] = '"';
		$trans_tbl['&#8221;'] = '"';
		return strtr($value, $trans_tbl);
	}
}