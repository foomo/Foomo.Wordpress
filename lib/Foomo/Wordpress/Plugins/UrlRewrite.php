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

namespace Foomo\Wordpress\Plugins;

/**
 * @link	www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author	franklin <franklin@weareinteractive.com>
 * 
 * Inspired by:
 * Plugin Name: WP No Category Base
 * Plugin URI: http://wordpresssupplies.com/wordpress-plugins/no-category-base/
 * Description: Removes '/category' from your category permalinks.
 * Version: 1.0
 * Author: iDope
 * Author URI: http://wordpresssupplies.com/
 */
class UrlRewrite extends \Foomo\Wordpress\Plugins\AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	//

	/**
	 * @var Foomo\Wordpress\Admin\Options
	 */
	private $options;

	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function setup()
	{
		//global $wp_rewrite;
		//$wp_rewrite->flush_rules();


		global $clean_category_rewrites, $clean_rewrites;
		$clean_category_rewrites = array();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @add_filter page_rewrite_rules
	 * 
	 * @internal
	 */
	public function _page_rewrite_rules($rules)
	{
		unset($rules["(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$"]);
		unset($rules["(.+?)/(feed|rdf|rss|rss2|atom)/?$"]);
		unset($rules["(.+?)/page/?([0-9]{1,})/?$"]);
		unset($rules["(.+?)(/[0-9]+)?/?$"]);
		return $rules;
	}

	/**
	 * @add_filter generate_rewrite_rules
	 * 
	 * @internal
	 * @global type $clean_category_rewrites
	 * @param type $wp_rewrite 
	 */
	public function _generate_rewrite_rules($wp_rewrite)
	{
		global $clean_category_rewrites;
		$wp_rewrite->rules = $wp_rewrite->rules + $clean_category_rewrites;
	}

	/**
	 *
	 * @add_filter category_rewrite_rules
	 * 
	 * @internal
	 * @global type $clean_category_rewrites
	 * @global type $wp_rewrite
	 * @param type $category_rewrite
	 * @return type 
	 */
	public function _category_rewrite_rules($category_rewrite)
	{
		global $clean_category_rewrites;
		global $wp_rewrite;

		// Make sure to use verbose rules, otherwise we'll clobber our
		// category permalinks with page permalinks
		//$wp_rewrite->use_verbose_page_rules = true; /// disabling this will make sure posts work, it was here already

		while (list($k, $v) = each($category_rewrite)) {
			// Strip off the category prefix
			$new_k = $this->remove_cat_base($k);
			$clean_category_rewrites[$new_k] = $v;
		}

		foreach ($category_rewrite AS $key => $item) {
			if (stripos($item, 'index.php?pagename') !== FALSE) {
				unset($category_rewrite[$key]);
			}
		}

		return $category_rewrite;
	}

	/** 	
	 * @add_filter category_link
	 * @add_filter_priority 10
	 * 
	 * @internal
	 * @param type $cat_link
	 * @return type 
	 */
	public function _category_link($cat_link)
	{
		return $this->remove_cat_base($cat_link);
	}

	/**
	 * @add_filter request
	 * 
	 * @internal
	 * @param type $query_string
	 * @return type 
	 */
	function _request($query_string)
	{
		//echo '<!-- before '.var_export( $query_string, true ).'-->';

		if (isset($query_string['category_name'])) {
			$test_query = new \WP_Query('pagename=' . $query_string['category_name']);
			//echo '<!-- test_query '.var_export( $test_query->post_count, true ).'-->';
			if ($test_query->post_count) {
				$query_string['pagename'] = $query_string['category_name'];
				unset($query_string['category_name']);
				//echo '<!-- after '.var_export( $query_string, true ).'-->';
				return $query_string;
			}
		}
		echo '<!-- after '.var_export( $query_string, true ).'-->';

		return $query_string; //  end
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $link
	 * @return string
	 */
	private function remove_cat_base($link)
	{
		$category_base = get_option('category_base');

		// WP uses "category/" as the default
		if ($category_base == '')
			$category_base = 'category';

		// Remove initial slash, if there is one (we remove the trailing slash in the regex replacement and don't want to end up short a slash)
		if (substr($category_base, 0, 1) == '/')
			$category_base = substr($category_base, 1);

		$category_base .= '/';

		return preg_replace('|' . $category_base . '|', '', $link, 1);
	}

}