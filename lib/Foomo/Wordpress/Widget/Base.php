<?php
/*
 * This file is part of the foomo Opensource Framework.
 * 
 * The foomo Opensource Framework is free software: you can redistribute it
 * and/or modify it under the terms of the GNU Lesser General Public License as
 * published  by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * The foomo Opensource Framework is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License along with
 * the foomo Opensource Framework. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Foomo\Wordpress\Widget;

if (!class_exists('WP_Widget')) include_once(\Foomo\Wordpress\Module::getWordpressDir() . DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'widgets.php'); 

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 * 
 * @nohook
 */
class Base extends \WP_Widget
{
	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------
	
	/**
	 * @see WP_Widget::__construct
	 * 
	 * @param string $id_base
	 * @param string $name
	 * @param array $widget_options
	 * @param array $control_options 
	 */
	public function __construct($id_base=false, $name, $widget_options=array(), $control_options=array())
	{
		parent::__construct($id_base, $name, $widget_options, $control_options);
	}
	
	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Us in YourWidget::widget to receive a value
	 * 
	 * @param array $instance
	 * @param string $value
	 * @param mixed $default
	 * @return mixed
	 */
	protected function getWidgetArguement($instance, $value, $default)
	{
		return apply_filters('widget_' . $value, empty($instance[$value]) ? $default : $instance[$value], $instance, $this->id_base);
	}


	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected function renderView($template, $model=null)
	{
		return \Foomo\Wordpress\View::render(get_called_class(), $template, $model);
	}	
}