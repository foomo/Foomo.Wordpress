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
class BBCode extends \Foomo\Wordpress\Shortcodes\AbstractShortcode
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
			'shortcode_bbcode'	=> array('b', 'i', 'u', 'url', 'img', 'quote', 'color', 's', 'center', 'code', 'size', 'ul', 'ol', 'li'),
		);
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
	public function shortcode_bbcode($atts, $content=null, $code="")
	{
		if (is_null($content)) return '';
		if (isset($atts[0]) && !empty($atts[0])) {
			if (0 !== preg_match('#=("|\')(.*?)("|\')#', $atts[0], $match)) $atts[0] = $match[2];
		}

		switch (strtolower($code)) {
			case 'b':
				return \Foomo\Wordpress\View::html('strong', do_shortcode($content));
				break;
			case 'i':
				return \Foomo\Wordpress\View::html('em', do_shortcode($content));
				break;
			case 'u':
				return \Foomo\Wordpress\View::html('span', do_shortcode($content), array('style' => 'text-decoration:underline'));
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

				return \Foomo\Wordpress\View::link($url, do_shortcode($text));
				break;
			case 'img':
				return \Foomo\Wordpress\View::html('img', null, array('src' => $content));
				break;
			case 'quote':
				return \Foomo\Wordpress\View::html('blockquote', do_shortcode($content));
				break;
			case 'color':
				$attribs = implode("",$atts);
				$subattribs = substr ($attribs, 1);
				return \Foomo\Wordpress\View::html('span', do_shortcode($content), array('style' => 'color:' . $subattribs));
				break;
			case 's':
				return \Foomo\Wordpress\View::html('del', do_shortcode($content));
				break;
			case 'center':
				return \Foomo\Wordpress\View::html('center', do_shortcode($content));
				break;
			case 'code':
				return \Foomo\Wordpress\View::html('code', do_shortcode($content));
				break;
			case 'size':
				$attribs = implode("",$atts);
				$subattribs = substr ( $attribs, 1);
				return \Foomo\Wordpress\View::html('span', do_shortcode($content), array('style' => 'font-size:' . $subattribs . 'px'));
				break;
			case 'ol':
				return \Foomo\Wordpress\View::html('ol', do_shortcode($content));
				break;
			case 'ul':
				return \Foomo\Wordpress\View::html('ul', do_shortcode($content));
				break;
			case 'li':
				return \Foomo\Wordpress\View::html('li', do_shortcode($content));
				break;
		}
	}
}