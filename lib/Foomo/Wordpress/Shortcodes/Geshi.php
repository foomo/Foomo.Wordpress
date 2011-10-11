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
 * @link	www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author	franklin <franklin@weareinteractive.com>
 */
class Geshi extends \Foomo\Wordpress\Shortcodes\AbstractShortcode
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
			'shortcode_geshi'	=> array('geshi'),
			'shortcode_github'	=> array('github'),
			'shortcode_gist'	=> array('gist'),
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
	public function shortcode_geshi($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('lang' => 'php'), $atts));

		if (is_null($content)) return null;

		$content = trim($content);

		$classes = array('geshiCode', 'language-' . $lang);

		$geshi = new \GeSHi($content, $lang);

		return '<div class="geshiCode">' . $geshi->parse_code() . '</div>';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public function shortcode_gist($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('id' => null, 'ttl' => '1 day', 'lang' => 'php'), $atts));

		if (is_null($id)) return null;
		$url = 'https://gist.github.com/' . $id . '/';
		$raw = 'https://raw.github.com/gist/' . $id . '/';

		$classes = array('geshi', 'remote-file', 'gist', 'language-' . $lang);

		$geshi = new \GeSHi(\Foomo\Wordpress\Utils\RemoteFile::getFile($raw, $ttl), $lang);

		return '
			<div class="remoteCode">
				<div class="meta">
					<span class="origin"><a href="' . $url . '" target="_blank">Gist</a></span>
					<span class="raw"><a href="' . $raw . '" target="_blank">raw</a></span>
				</div>
				<div class="geshiCode content">' . $geshi->parse_code() . '</div>
			</div>
		';
	}

	/**
	 * @internal
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public function shortcode_github($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('url' => null, 'ttl' => '1 day', 'lang' => 'php'), $atts));

		if (is_null($url)) return null;

		$raw = $url . '?raw=true';

		$classes = array('geshi', 'remote-file', 'github', 'language-' . $lang);

		$geshi = new \GeSHi(\Foomo\Wordpress\Utils\RemoteFile::getFile($raw, $ttl), $lang);

		return '
			<div class="remoteCode">
				<div class="meta">
					<span class="origin"><a href="' . $url . '" target="_blank">GitHub</a></span>
					<span class="raw"><a href="' . $raw . '" target="_blank">raw</a></span>
				</div>
				<div class="geshiCode content">' . $geshi->parse_code() . '</div>
			</div>
		';
	}
}