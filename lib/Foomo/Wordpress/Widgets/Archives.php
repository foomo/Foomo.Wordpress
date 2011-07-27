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
class Archives extends \Foomo\Wordpress\Widgets\AbstractWidget
{

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	function __construct()
	{
		$widget_ops = array('classname' => 'widget_archive', 'description' => __('A monthly archive of your site&#8217;s posts'));
		parent::__construct('archives', __('Archives'), $widget_ops);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	public function widget($args, $instance)
	{
		extract($args);
		$count = $instance['count'] ? '1' : '0';
		$dropdown = $instance['dropdown'] ? '1' : '0';
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Archives') : $instance['title'], $instance, $this->id_base);
		$title_link = apply_filters('widget_title_link', empty($instance['title_link']) ? '' : $instance['title_link'], $instance, $this->id_base);
		$widget = $this;
		$model = (object) compact(
			'title',
			'title_link',
			'count',
			'dropdown',
			'instance',
			'before_widget',
			'after_widget',
			'before_title',
			'after_title',
			'widget'
		);
		echo $this->renderView('widget', $model);
	}

	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = $new_instance['count'] ? 1 : 0;
		$instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

		return $instance;
	}

	public function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
		$title = strip_tags($instance['title']);
		$count = $instance['count'] ? 'checked="checked"' : '';
		$dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
		$widget = $this;
		$model = (object) compact(
			'title',
			'count',
			'dropdown',
			'instance',
			'widget'
		);
		echo $this->renderView('widget', $model);
	}
}