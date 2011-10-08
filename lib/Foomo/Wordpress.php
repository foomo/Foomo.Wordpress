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

namespace Foomo;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Wordpress
{
	//---------------------------------------------------------------------------------------------
	// ~ Static variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var array
	 */
	private static $enqueuedScripts = array();
	/**
	 * @var array
	 */
	private static $enqueuedStyles = array();
	/**
	 * @var string
	 */
	private static $headerScript = '';
	/**
	 * @var string
	 */
	private static $prependFooterScript = '';
	/**
	 * @var string
	 */
	private static $appendFooterScript = '';

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public static function init()
	{
		if (is_admin()) return;

		# add some javascript libs
		// @todo don't require foomo/flash
		#wp_register_script('swfobject', \Foomo\Flash\Module::getHtdocsPath('js') . '/swfobject-2.2.min.js', array(), '2.2', true);

		# add actions
		add_action('print_head_scripts', array(__CLASS__, 'print_head_scripts'));
		add_action('wp_print_footer_scripts', array(__CLASS__, 'wp_print_footer_scripts'));
		add_action('print_footer_scripts', array(__CLASS__, 'print_footer_scripts'));

		# remove/add filters
		remove_filter('the_content', 'wpautop');
		add_filter('the_content', array(__CLASS__, 'wpautop'));
	}

	/**
	 * @param string $script
	 */
	public static function addHeaderScript($script)
	{
		self::$headerScript .= $script;
	}

	/**
	 * @param string $script
	 * @param boolean $prepend
	 */
	public static function addFooterScript($script, $prepend=false)
	{
		if ($prepend) {
			self::$prependFooterScript .= $script . PHP_EOL;
		} else {
			self::$appendFooterScript .= $script . PHP_EOL;
		}
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @return output
	 */
	public static function print_head_scripts()
	{
		#trigger_error(__FUNCTION__);
		if (empty(self::$headerScript)) return;
		echo '<script type="text/javascript">' . PHP_EOL . trim(self::$headerScript) . PHP_EOL . '</script>' . PHP_EOL;
	}
	/**
	 * @internal
	 * @return output
	 */
	public static function wp_print_footer_scripts()
	{
		#trigger_error(__FUNCTION__);
		if (empty(self::$prependFooterScript)) return;
		echo '<script type="text/javascript">' . PHP_EOL . trim(self::$prependFooterScript) . PHP_EOL . '</script>' . PHP_EOL;
	}

	/**
	 * @internal
	 * @return output
	 */
	public static function print_footer_scripts()
	{
		#trigger_error(__FUNCTION__);
		if (empty(self::$appendFooterScript)) return;
		echo '<script type="text/javascript">' . PHP_EOL . trim(self::$appendFooterScript) . PHP_EOL . '</script>' . PHP_EOL;
	}


	/**
	 * Calls "no_wpautop_shortcodes" and excludes the given shortcodes from formatting
	 *
	 * @internal
	 * @param string $pee
	 * @param boolean $br
	 * @return string
	 */
	public static function wpautop($pee, $br = 1)
	{
		if (trim($pee) === '') return '';

		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allc = apply_filters('no_wpautop_shortcodes', array());
		$allcodes = '(?:' . implode('|', $allc) . ')';
		$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|option|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

		$pee = preg_replace('!(\[' . $allcodes . '[^>]*\])!', "\n$1", $pee);
		$pee = preg_replace('!(\[/' . $allcodes . '\])!', "$1\n\n", $pee);

		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		if ( strpos($pee, '<object') !== false ) {
			$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
			$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
		}
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates

		// make paragraphs, including one at the end
		$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
		$pee = '';
		foreach ( $pees as $tinkle ) $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
		$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);

		$pee = preg_replace('!<p>\s*(\[/?' . $allcodes . '[^>]*\])\s*</p>!', "$1", $pee); // don't pee all over a tag

		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);

		$pee = preg_replace('!<p>\s*(\[/?' . $allcodes . '[^>]*\])!', "$1", $pee);
		$pee = preg_replace('!(\[/?' . $allcodes . '[^>]*\])\s*</p>!', "$1", $pee);

		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

		if ($br) {
			$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);
			$pee = preg_replace_callback('/\[(' . implode('|', $allc) . ').*?\[\/\\1\]/s', '_autop_newline_preservation_helper', $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(\[/?' . $allcodes . '[^>]*\])\s*<br />!', "$1", $pee);

		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);

		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		if (strpos($pee, '<pre') !== false)
			$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

		return $pee;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 * @param string $text
	 * @param array $stack
	 * @param array $disabled_elements
	 * @param string $opening
	 * @param string $closing
	 */
	private static function wpautop_pushpop_element($text, &$stack, $disabled_elements, $opening = '<', $closing = '>')
	{
		if (strncmp($opening . '/', $text, 2)) {
			if (preg_match('/^' . $disabled_elements . '\b/', substr($text, 1), $matches)) {
				array_push($stack, $matches[1]);
			}
		} else {
			$c = preg_quote($closing, '/');
			if (preg_match('/^' . $disabled_elements . $c . '/', substr($text, 2), $matches)) {
				$last = array_pop($stack);
				if ($last != $matches[1]) array_push($stack, $last);
			}
		}
	}
}