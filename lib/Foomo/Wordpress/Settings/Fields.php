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
class Fields
{
	//---------------------------------------------------------------------------------------------
	// ~ Public intenal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param array $args
	 */
	public static function textarea($args=array())
	{
		$id = $args['id'];
		$option = get_option($id);
		$description = (isset($args['description'])) ? $args['description'] : '';
		echo "
			<fieldset>
				<p><label>{$description}</label></p>
				<p><textarea id='{$id}' name='{$id}' rows='10' cols='50' class='large-text code' type='textarea'>{$option}</textarea></p>
			</fieldset>
		";
	}

	/**
	 * @param array $args
	 */
	public static function checkbox($args=array())
	{
		$id = $args['id'];
		$description = (isset($args['description'])) ? $args['description'] : '';
		echo "
			<fieldset>
				<label>
					<input id='{$id}' name='{$id}' value='1' type='checkbox' " . checked(1, get_option($id), false) . "/> {$description}
				</label>
			</fieldset>
		";
	}

	/**
	 * @param array $args
	public static function radioButtons($args=array())
	{
		$id = $args['id'];
		$section = $args['section'];
		$options = get_option($section);
		$options = get_option(is_null($section) ? self::getConstant('ID') : $section);
		foreach($items as $item) {
			$checked = ($options[$id] == $item) ? ' checked="checked"' : '';
			echo "<label><input id='{$id}' name='{$section}[{$id}]' value='$item' type='radio'{$checked}/> $item</label><br />";
		}
	}
	 */

	/**
	 * @param array $args
	 */
	public static function password($args=array())
	{
		$id = $args['id'];
		$option = get_option($id);
		$description = (isset($args['description'])) ? $args['description'] : '';
		echo "
			<input id='{$id}' name='{$id}' class='regular-text' type='password' value='{$option}'/>
			<span class='description'>{$description}</span>
		";
	}

	/**
	 * @param array $args
	 */
	public static function text($args=array())
	{
		$id = $args['id'];
		$option = get_option($id);
		$description = (isset($args['description'])) ? $args['description'] : '';
		echo "
			<input id='{$id}' name='{$id}' class='regular-text' type='text' value='{$option}'/>
			<span class='description'>{$description}</span>
		";
	}
}