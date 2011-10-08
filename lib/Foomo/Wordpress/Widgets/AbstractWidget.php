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

if (!class_exists('WP_Widget')) require(self::getWordpressDir() .  DIRECTORY_SEPARATOR . 'wp-includes' .  DIRECTORY_SEPARATOR . 'widgets.php');

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractWidget extends \WP_Widget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $id_base Optional Base ID for the widget, lower case,
	 * if left empty a portion of the widget's class name will be used. Has to be unique.
	 * @param string $name Name for the widget displayed on the configuration page.
	 * @param array $widget_options Optional Passed to wp_register_sidebar_widget()
	 *	 - description: shown on the configuration page
	 *	 - classname
	 * @param array $control_options Optional Passed to wp_register_widget_control()
	 *	 - width: required if more than 250px
	 *	 - height: currently not used but may be needed in the future
	 */
	public function __construct($id_base=false, $name, $widget_options=array(), $control_options=array())
	{
		parent::__construct($id_base, $name, $widget_options, $control_options);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args Display arguments including before_title, after_title, before_widget, and after_widget.
	 * @param array $instance The settings for the particular instance of the widget
	 */
	//abstract function widget($args, $instance);

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected static function renderView($template, $model=null)
	{
		return \Foomo\Wordpress\View::render(get_called_class(), $template, $model);
	}
}