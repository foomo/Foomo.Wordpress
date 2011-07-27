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
class RecentComments extends \Foomo\Wordpress\Widgets\AbstractWidget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @see WP_Wigets
	 */
	public function __construct()
	{
		$widget_ops = array('classname' => 'widget_recent_comments', 'description' => __('The most recent comments'));
		parent::__construct('recent-comments', __('Recent Comments'), $widget_ops);
		$this->alt_option_name = 'widget_recent_comments';

		if (is_active_widget(false, false, $this->id_base)) add_action('wp_head', array(&$this, '_recent_comments_style'));

		add_action('comment_post', array(&$this, '_flush_widget_cache'));
		add_action('transition_comment_status', array(&$this, '_flush_widget_cache'));
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @see WP_Wigets
	 */
	public function widget($args, $instance)
	{
		global $comments, $comment;

		$cache = wp_cache_get('widget_recent_comments', 'widget');

		if (!is_array($cache))
			$cache = array();

		if (isset($cache[$args['widget_id']])) {
			echo $cache[$args['widget_id']];
			return;
		}

		extract($args, EXTR_SKIP);
		$output = '';
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Comments') : $instance['title']);
		$title_link = apply_filters('widget_title_link', empty($instance['title_link']) ? '' : $instance['title_link'], $instance, $this->id_base);

		if (!$number = absint($instance['number'])) $number = 5;

		$comments = get_comments(array('number' => $number, 'status' => 'approve', 'post_status' => 'publish'));

		$widget = $this;
		$model = (object) compact(
			'title',
			'title_link',
			'comments',
			'instance',
			'before_widget',
			'after_widget',
			'before_title',
			'after_title',
			'widget'
		);
		$output = $this->renderView('widget', $model);
		$cache[$args['widget_id']] = $output;
		wp_cache_set('widget_recent_comments', $cache, 'widget');
		echo $output;
	}

	/**
	 * @see WP_Wigets
	 */
	public function update($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_link'] = $new_instance['title_link'];
		$instance['number'] = absint($new_instance['number']);
		$this->flush_widget_cache();

		$alloptions = wp_cache_get('alloptions', 'options');
		if (isset($alloptions['widget_recent_comments']))
			delete_option('widget_recent_comments');

		return $instance;
	}

	/**
	 * @see WP_Wigets
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
	public function _recent_comments_style()
	{
		if (!current_theme_supports('widgets') // Temp hack #14876
				|| !apply_filters('show_recent_comments_widget_style', true, $this->id_base))
			return;
		?>
		<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
		<?php
	}

	/**
	 * @internal
	 */
	public function _flush_widget_cache()
	{
		wp_cache_delete('widget_recent_comments', 'widget');
	}
}