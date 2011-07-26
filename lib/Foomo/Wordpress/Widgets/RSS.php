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

namespace Foomo\Wordpress\Widgets;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class RSS extends \Foomo\Wordpress\Widgets\AbstractWidget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @see WP_Wigets
	 */
	public function __construct()
	{
		$widget_ops = array('description' => __('Entries from any RSS or Atom feed'));
		$control_ops = array('width' => 400, 'height' => 200);
		parent::__construct('rss', __('RSS'), $widget_ops, $control_ops);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @see WP_Wigets
	 */
	public function widget($args, $instance)
	{
		if (isset($instance['error']) && $instance['error']) return;

		$default_args = array('show_author' => 0, 'show_date' => 0, 'show_summary' => 0, 'title' => '', 'url' => '', 'items' => 10);
		$inputs = wp_parse_args( $instance, $default_args );
		extract($args);
		extract($inputs, EXTR_SKIP);

		$url = $instance['url'];
		while (stristr($url, 'http') != $url) $url = substr($url, 1);

		if (empty($url)) return;

		// self-url destruction sequence
		if (in_array(untrailingslashit($url), array(site_url(), home_url()))) return;

		$rss = fetch_feed($url);
		$title = $instance['title'];
		$desc = '';
		$link = '';

		if (!is_wp_error($rss)) {
			$desc = esc_attr(strip_tags(@html_entity_decode($rss->get_description(), ENT_QUOTES, get_option('blog_charset'))));
			if (empty($title)) $title = esc_html(strip_tags($rss->get_title()));
			$link = esc_url(strip_tags($rss->get_permalink()));
			while (stristr($link, 'http') != $link) $link = substr($link, 1);
		} else {
			if (is_admin() || current_user_can('manage_options')) echo '<p>' . sprintf( __('<strong>RSS Error</strong>: %s'), $rss->get_error_message() ) . '</p>';
			return;

		}

		if (empty($title)) $title = empty($desc) ? __('Unknown Feed') : $desc;

		$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		$url = esc_url(strip_tags($url));
		$icon = includes_url('images/rss.png');
		if ($title) $title = "<a class='rsswidget' href='$url' title='" . esc_attr__('Syndicate this content') . "'><img style='border:0' width='14' height='14' src='$icon' alt='RSS' /></a> <a class='rsswidget' href='$link' title='$desc'>$title</a>";


		$items = (int) $instance['items'];
		if ($items < 1 || 20 < $items) $items = 10;
		$show_summary  = (int) $show_summary;
		$show_author   = (int) $show_author;
		$show_date     = (int) $show_date;

		if (!$rss->get_item_quantity()) {
			echo '<ul><li>' . __( 'An error has occurred; the feed is probably down. Try again later.' ) . '</li></ul>';
			$rss->__destruct();
			unset($rss);
			return;
		}

		$widget = $this;
		$model = (object) compact(
			'title',
			'rss',
			'items',
			'show_date',
			'show_author',
			'show_summary',
			'instance',
			'before_widget',
			'after_widget',
			'before_title',
			'after_title',
			'widget'
		);
		echo $this->renderView('widget', $model);

		if (!is_wp_error($rss)) $rss->__destruct();
		unset($rss);
	}

	/**
	 * @see WP_Wigets
	 */
	public function update($new_instance, $old_instance)
	{
		$testurl = ( isset($new_instance['url']) && ($new_instance['url'] != $old_instance['url']) );
		return wp_widget_rss_process($new_instance, $testurl);
	}

	/**
	 * @see WP_Wigets
	 */
	public function form($instance)
	{
		if (empty($instance)) $instance = array( 'title' => '', 'url' => '', 'items' => 10, 'error' => false, 'show_summary' => 0, 'show_author' => 0, 'show_date' => 0 );
		$instance['number'] = $this->number;
		$default_inputs = array('url' => true, 'title' => true, 'items' => true, 'show_summary' => true, 'show_author' => true, 'show_date' => true );
		$inputs = wp_parse_args($instance, $default_inputs);
		extract($inputs);
		extract($inputs, EXTR_SKIP);
		$number = esc_attr($number);
		$title = esc_attr($title);
		$url = esc_url($url);

		$items = (int) $items;
		if ($items < 1 || 20 < $items) $items = 10;
		$show_summary = (int) $show_summary;
		$show_author = (int) $show_author;
		$show_date = (int) $show_date;

		$widget = $this;
		$model = (object) compact(
			'title',
			'url',
			'items',
			'number',
			'show_summary',
			'default_inputs',
			'show_author',
			'show_date',
			'instance',
			'widget'
		);
		echo $this->renderView('form', $model);
	}
}