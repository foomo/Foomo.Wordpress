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

	private static $available = array(
		'foomo_run' => array('foomo_run'),
		'geshi'		=> array('geshi'),
		'gist'		=> array('gist'),
		'github'	=> array('github'),
		'youtube'	=> array('youtube'),
		'vimeo'		=> array('vimeo'),
		'bbcode'	=> array('b', 'i', 'u', 'url', 'img', 'quote', 'color', 's', 'center', 'code', 'size', 'ul', 'ol', 'li'),

	);

	/**
	 *
	 */
	public static function register($shortcode)
	{
		$shortcode = strtolower($shortcode);
		if (!isset(self::$available[$shortcode]) || in_array($shortcode, self::$enabled)) return;
		self::$enabled[] = $shortcode;
		foreach (self::$available[$shortcode] as $code) add_shortcode($code, array(__CLASS__, 'shortcode_' . $shortcode));
		if (count(self::$enabled) == 1) {
			add_filter('no_texturize_shortcodes', array(__CLASS__, 'no_texturize_shortcodes'));
			add_filter('no_wpautop_shortcodes', array(__CLASS__, 'no_wpautop_shortcodes'));
		}
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
	public static function shortcode_foomo_run($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('app' => null), $atts));

		if (is_null($app)) return null;

		if (strpos($app, '.') >= 0) $app = str_replace('.', '\\', $app) . '\\Frontend';


		if (!is_null($content)) {
			# trim content
			$content = json_decode(trim($content), true);
			#return var_export($content, true);
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
	public static function shortcode_gist($atts, $content=null, $code="")
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
	public static function shortcode_github($atts, $content=null, $code="")
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
	public static function shortcode_geshi($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('lang' => 'php'), $atts));

		if (is_null($content)) return null;

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
	public static function shortcode_bbcode($atts, $content=null, $code="")
	{
		if (is_null($content)) return '';
		if (isset($atts[0]) && !empty($atts[0])) {
			if (0 !== preg_match('#=("|\')(.*?)("|\')#', $atts[0], $match)) $atts[0] = $match[2];
		}

		trigger_error($code);

		switch (strtolower($code)) {
			case 'b':
				return '<strong>' . do_shortcode($content) . '</strong>';
				break;
			case 'i':
				return '<em>' . do_shortcode($content) . '</em>';
				break;
			case 'u':
				return '<span style="text-decoration:underline">' . do_shortcode($content) . '</span>';
				break;
			case 'url':
				if (isset($atts[0]) ) {
					// [url="http://www.google.com/"]Google[/url]
					$url = $atts[0];
					$url = implode("",$atts);
				}
				if (substr($url,0,1) == '=') {
					//If it starts with an = start 1 more along [URL=http://..]
					$suburl = substr ( $url, 1);
					$text =  $content;
				} elseif ( substr($url,0,1) !== '"') {
					//If it starts with an " start at 0 [URL="http://..]
					$suburl = substr ( $url, 0);
					$text =  $content;
				} else {
					// [url]http://www.google.com/[/url]
					$url = $text = $content;
				}

				if (empty($url)) return '';
				if (empty($text)) $text = $url;

				return '<a href="' . $url . '">' . do_shortcode($text) . '</a>';
				break;
			case 'img':
				return '<img src="' . $content . '" alt="" />';
				break;
			case 'quote':
				return '<blockquote>' . do_shortcode($content) . '</blockquote>';
				break;
			case 'color':
				$attribs = implode("",$atts);
				$subattribs = substr ($attribs, 1);
				return '<span style="color:' . $subattribs . '">' . do_shortcode($content) . '</span>';
				break;
			case 's':
				return '<del>' . do_shortcode($content) . '</del>';
				break;
			case 'center':
				return '<center>' . do_shortcode($content) . '</center>';
				break;
			case 'code':
				return '<code>' . do_shortcode($content) . '</code>';
				break;
			case 'size':
				$attribs = implode("",$atts);
				$subattribs = substr ( $attribs, 1);
				return '<span style="font-size:' . $subattribs . 'px">' . do_shortcode($content) . '</span>';
				break;
			case 'ol':
				return '<ol>' . do_shortcode($content) . '</ol>';
				break;
			case 'ul':
				return '<ul>' . do_shortcode($content) . '</ul>';
				break;
			case 'li':
				return '<li>' . do_shortcode($content) . '</li>';
				break;
		}
	}


	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function shortcode_youtube($atts, $content=null, $code="")
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
	public static function shortcode_gvideo($atts, $content=null, $code="")
	{
		extract(shortcode_atts(array('width' => '400', 'height' => '325', 'fullscreen' => 'true'), $atts));
		if (is_null($content)) return 'No Google Video ID Set';
		return '
			<object width="' . $width . '" height="' . $height . '">
				<param name="allowfullscreen" value="' . $fullscreen . '"></param>
				<param name="movie" value="http://video.google.com/googleplayer.swf?docId=' .$content . '"></param>
				<embed src="http://video.google.com/googleplayer.swf?docId=' . $content . '" type="application/x-shockwave-flash" width="' . $width .'" height="' . $height . '" allowfullscreen="' . $fullscreen . '"></embed>
			</object>
		';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function shortcode_vimeo($atts, $content=null, $code="")
	{
		trigger_error($content);
		extract(shortcode_atts(array('width' => '400', 'height' => '325', 'fullscreen' => 'true'), $atts));
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
	 * @internal
	 * @param array $shortcodes
	 * @return string
	 */
	public static function no_texturize_shortcodes($shortcodes)
	{
		foreach (self::$enabled as $enabled) $shortcodes = array_merge($shortcodes, self::$available[$enabled]);
		return $shortcodes;
	}

	/**
	 * @internal
	 * @param array $shortcodes
	 * @return string
	 */
	public static function no_wpautop_shortcodes($shortcodes)
	{
		foreach (self::$enabled as $enabled) $shortcodes = array_merge($shortcodes, self::$available[$enabled]);
		return $shortcodes;
	}
}