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
class Links extends \Foomo\Wordpress\Widgets\AbstractWidget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
		$widget_ops = array('description' => __("Your blogroll"));
		parent::__construct('links', __('Links'), $widget_ops);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	public function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);

		$show_description = isset($instance['description']) ? $instance['description'] : false;
		$show_name = isset($instance['name']) ? $instance['name'] : false;
		$show_rating = isset($instance['rating']) ? $instance['rating'] : false;
		$show_images = isset($instance['images']) ? $instance['images'] : true;
		$category = isset($instance['category']) ? $instance['category'] : false;

		if (is_admin() && !$category) {
			// Display All Links widget as such in the widgets screen
			echo $before_widget . $before_title . __('All Links') . $after_title . $after_widget;
			return;
		}

		$before_widget = preg_replace('/id="[^"]*"/', 'id="%id"', $before_widget);
		wp_list_bookmarks(apply_filters('widget_links_args', array(
					'title_before' => $before_title, 'title_after' => $after_title,
					'category_before' => $before_widget, 'category_after' => $after_widget,
					'show_images' => $show_images, 'show_description' => $show_description,
					'show_name' => $show_name, 'show_rating' => $show_rating,
					'category' => $category, 'class' => 'linkcat widget'
				)));
	}

	public function update($new_instance, $old_instance)
	{
		$new_instance = (array) $new_instance;
		$instance = array('images' => 0, 'name' => 0, 'description' => 0, 'rating' => 0);
		foreach ($instance as $field => $val) {
			if (isset($new_instance[$field]))
				$instance[$field] = 1;
		}
		$instance['category'] = intval($new_instance['category']);

		return $instance;
	}

	public function form($instance)
	{
		//Defaults
		$instance = wp_parse_args((array) $instance, array('images' => true, 'name' => true, 'description' => false, 'rating' => false, 'category' => false));
		$link_cats = get_terms('link_category');
		$widget = $this;
		$model = (object) compact(
			'instance',
			'link_cats',
			'widget'
		);
		echo $this->renderView('form', $model);
	}
}