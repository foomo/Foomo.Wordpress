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

namespace Foomo\Wordpress\Settings;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Section
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $page;
	/**
	 * @var string
	 */
	private $title;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	private function __construct($id, $page, $title)
	{
		$this->id = $id;
		$this->page = $page;
		$this->title = $title;
		add_settings_section($this->id, $title, null, $page);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @return Foomo\Wordpress\Settings\Section
	 */
	public function addToMetaBox()
	{
		add_meta_box($this->id, $this->title, array(&$this, 'render'), $this->page);
		return $this;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public intenal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @param array $args
	 */
	public function input_textarea($args=array())
	{
		$name = $args['id'];
		$group = isset($args['group']) ? $args['group'] : $this->page;
		$options = get_option($group);
		echo "<textarea id='{$name}' name='{$group}[{$name}]' rows='7' cols='50' type='textarea'>{$options[$name]}</textarea>";
	}

	/**
	 * @internal
	 * @param array $args
	 */
	public function input_checkbox($args=array())
	{
		$name = $args['id'];
		$group = isset($args['group']) ? $args['group'] : $this->page;
		$options = get_option($group);
		$checked = (isset($options[$name]) && $options[$name] == 'on') ? ' checked="checked"' : '';
		echo "<input id='{$name}' name='{$group}[$name]' type='checkbox'{$checked}>";
	}

	/**
	 * @internal
	 * @param array $args
	 */
	public function input_radio_buttons($args=array())
	{
		$name = $args['id'];
		$group = isset($args['group']) ? $args['group'] : $this->page;
		$options = get_option($group);
		$options = get_option(is_null($group) ? self::getConstant('ID') : $group);
		foreach($items as $item) {
			$checked = ($options[$name] == $item) ? ' checked="checked"' : '';
			echo "<label><input id='{$name}' name='{$group}[{$name}]' value='$item' type='radio'{$checked}/> $item</label><br />";
		}
	}

	/**
	 * @internal
	 * @param array $args
	 */
	public function input_password($args=array())
	{
		$name = $args['id'];
		$group = isset($args['group']) ? $args['group'] : $this->page;
		$options = get_option($group);
		echo "<input id='{$name}' name='{$group}[$name]' size='40' type='password' value='{$options[$name]}' />";
	}

	/**
	 * @internal
	 * @param array $args
	 */
	public function input_text($args=array())
	{
		$name = $args['id'];
		$group = isset($args['group']) ? $args['group'] : $this->page;
		$options = get_option($group);
		echo "<input id='{$name}' name='{$group}[$name]' size='40' type='text' value='{$options[$name]}' />";
	}

	/**
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $callback
	 * @param array $args
	 * @return Foomo\Wordpress\Settings\Section
	 */
	public function addSettingsField($id, $title, $callback, $args=array())
	{
		add_settings_field(
			$id,
			$title,
			$callback,
			$this->page,
			$this->id,
			array_merge(array('id' => $id), $args)
		);
		return $this;
	}

	/**
	 * @internal
	 * @param array $args
	 */
	public function render()
	{
		global $wp_settings_sections, $wp_settings_fields;

		if (!isset($wp_settings_sections) || !isset($wp_settings_sections[$this->page]) || !isset($wp_settings_sections[$this->page][$this->id])) return;

		$section = $wp_settings_sections[$this->page][$this->id];

		if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$this->page]) || !isset($wp_settings_fields[$this->page][$section['id']])) return;
		echo '<table class="form-table">';
		do_settings_fields($this->page, $section['id']);
		echo '</table>';
	}

	//---------------------------------------------------------------------------------------------
	// ~ Protected static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $page
	 * @param string $title
	 * @return Foomo\Wordpress\Settings\Section
	 */
	public static function create($id, $page, $title)
	{
		return new self($id, $page, $title);
	}
}