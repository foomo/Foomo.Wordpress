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
class BBCode extends AbstractShortcodes
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
			'shortcode_bbcode'	=> array('b', 'i', 'u', 'url', 'img', 'quote', 'color', 's', 'center', 'code', 'size', 'ul', 'ol', 'li'),
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
	public static function shortcode_bbcode($atts, $content=null, $code="")
	{
		if (is_null($content)) return '';
		if (isset($atts[0]) && !empty($atts[0])) {
			if (0 !== preg_match('#=("|\')(.*?)("|\')#', $atts[0], $match)) $atts[0] = $match[2];
		}

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
}