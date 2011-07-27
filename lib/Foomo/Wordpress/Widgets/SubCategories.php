<?php

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

namespace Foomo\Wordpress\Widgets;

/**
 * Plugin Name: Sub Categories Widget
 * Description: This Widget lists the sub-categories for a given category.
 * Author: BrokenCrust
 * Version: 0.1
 * Author URI: http://brokencrust.com/
 * Plugin URI: http://brokencrust.com/plugins/sub-categories-widget/
 * License: GPLv2 or later
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class SubCategories extends \Foomo\Wordpress\Widgets\AbstractWidget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function __construct()
	{
		$widget_ops = array('classname' => 'widget_sub_categories', 'description' => __('Lists the sub-categories for a given category.', 'sub_categories') );
		parent::__construct('sub_categories_widget', __('Sub Categories', 'sub_categories'), $widget_ops);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @see Foomo\Wordpress\Widgets\AbstractWidget
	 */
	public function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);

		$category_id = empty($instance['category_id']) ? 1 : $instance['category_id'];
		$hide_empty_cats = empty($instance['hide_empty_cats']) ? 0 : $instance['hide_empty_cats'];
		$show_post_count = empty($instance['show_post_count']) ? 0 : $instance['show_post_count'];
		$title = apply_filters('widget_title', empty($instance['title'] ) ? __('Sub Categories', 'sub_categories') : $instance['title'], $instance, $this->id_base);
		$title_link = apply_filters('widget_title_link', empty($instance['title_link']) ? '' : $instance['title_link'], $instance, $this->id_base);

		$categories = get_categories(array('parent' => $category_id, 'hide_empty' => $hide_empty_cats, 'show_count' => $show_post_count));

		if (!empty($categories)) {
			$model = (object) compact(
				'args',
				'instance',
				'categories',
				'title',
				'title_link',
				'category_id',
				'hide_empty_cats',
				'show_post_count',
				'before_widget',
				'after_widget',
				'before_title',
				'after_title'
			);
			echo $this->renderView('widget', $model);
		}
	}

	/**
	 * @see Foomo\Wordpress\Widgets\AbstractWidget
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = trim(strip_tags($new_instance['title']));
		$instance['title_link'] = $new_instance['title_link'];
		$instance['category_id'] = (int) $new_instance['category_id'];
		$instance['hide_empty_cats'] = (int) $new_instance['hide_empty_cats'];
		$instance['show_post_count'] = (int) $new_instance['show_post_count'];

		return $instance;
	}

	/**
	 * @see Foomo\Wordpress\Widgets\AbstractWidget
	 */
	public function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array('title' => __('Sub Categories', 'sub_categories'), 'title_link' => '', 'category_id' => 1, 'hide_empty_cats' => 0, 'show_post_count' => 1));
		$widget = $this;
		$model = (object) compact(
			'widget',
			'instance'
		);
		echo $this->renderView('form', $model);
	}
}