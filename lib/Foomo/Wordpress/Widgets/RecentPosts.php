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
class RecentPosts extends \Foomo\Wordpress\Widgets\AbstractWidget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @see WP_Wigets
	 */
	public function __construct()
	{
		$widget_ops = array('classname' => 'widget_recent_entries', 'description' => __("The most recent posts on your site"));
		parent::__construct('recent-posts', __('Recent Posts'), $widget_ops);
		$this->alt_option_name = 'widget_recent_entries';

		add_action('save_post', array(&$this, '_flush_widget_cache'));
		add_action('deleted_post', array(&$this, '_flush_widget_cache'));
		add_action('switch_theme', array(&$this, '_flush_widget_cache'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @see WP_Wigets
	 */
	public function widget($args, $instance)
	{
		$cache = wp_cache_get('widget_recent_posts', 'widget');

		if (!is_array($cache)) $cache = array();

		if (isset($cache[$args['widget_id']])) {
			echo $cache[$args['widget_id']];
			return;
		}

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'], $instance, $this->id_base);
		$title_link = apply_filters('widget_title_link', empty($instance['title_link']) ? '' : $instance['title_link'], $instance, $this->id_base);
		if (!$number = absint($instance['number'])) $number = 10;

		$output = '';
		$r = new \WP_Query(array('posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));
		if ($r->have_posts()) {
			$widget = $this;
			$model = (object) compact(
				'title',
				'title_link',
				'r',
				'instance',
				'before_widget',
				'after_widget',
				'before_title',
				'after_title',
				'widget'
			);
			$output = $this->renderView('widget', $model);
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
		}

		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_posts', $cache, 'widget');
		echo $output;
	}

	/**
	 * @see WP_Widgets
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_link'] = $new_instance['title_link'];
		$instance['number'] = (int) $new_instance['number'];
		$this->_flush_widget_cache();

		$alloptions = wp_cache_get('alloptions', 'options');
		if (isset($alloptions['widget_recent_entries'])) delete_option('widget_recent_entries');

		return $instance;
	}

	/**
	 * @see WP_Widgets
	 */
	public function form($instance)
	{
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$title_link = isset($instance['title_link']) ? $instance['title_link'] : '';
		$number = isset($instance['number']) ? absint($instance['number']) : 5;
		$widget = $this;
		$model = (object) compact(
			'title',
			'title_link',
			'number',
			'instance',
			'widget'
		);
		echo $this->renderView('form', $model);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 */
	public function _flush_widget_cache()
	{
		wp_cache_delete('widget_recent_posts', 'widget');
	}
}