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
class Text extends \Foomo\Wordpress\Widgets\AbstractWidget
{

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	public function __construct()
	{
		$widget_ops = array('classname' => 'widget_text', 'description' => __('Arbitrary text or HTML'));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('text', __('Text'), $widget_ops, $control_ops);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	public function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title'], $instance, $this->id_base);
		$title_link = apply_filters('widget_title_link', empty($instance['title_link']) ? '' : $instance['title_link'], $instance, $this->id_base);
		$text = apply_filters('widget_text', $instance['text'], $instance);
		$widget = $this;
		$model = (object) compact(
			'text',
			'title',
			'title_link',
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
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_link'] = $new_instance['title_link'];
		$instance['text'] = $new_instance['text'];
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	public function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array('title' => '', 'title_link' => '', 'text' => ''));
		$title = strip_tags($instance['title']);
		$title_link = $instance['title_link'];
		$text = esc_textarea($instance['text']);
		$widget = $this;
		$model = (object) compact(
			'text',
			'title',
			'title_link',
			'instance',
			'widget'
		);
		echo $this->renderView('form', $model);
	}
}