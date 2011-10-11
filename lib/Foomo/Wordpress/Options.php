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

namespace Foomo\Wordpress;

/**
 * Container for an array of options
 *
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 * @todo mark dirty options due to default changes
 */
class Options
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * The option name
	 *
	 * @var string
	 */
	protected $key;
	/**
	 * The default values
	 *
	 * @var array
	 */
	protected $defaults;
	/**
	 * Used by WP hooks
	 *
	 * @var string
	 */
	public $wp_filter_id;

	//---------------------------------------------------------------------------------------------
	// ~ Constructor
	//---------------------------------------------------------------------------------------------

	/**
	 * Create a new set of options
	 *
	 * @param string $key Option name
	 * @param array $defaults An associative array of default values (optional)
	 */
	public function __construct($key, $file=null, $defaults=array())
	{
		$this->key = $key;
		$this->defaults = $defaults;

		if ($file) {
			\register_uninstall_hook($file, '__return_false' );	// dummy
			\register_activation_hook($file, array($this, '_activate_plugin'));
			\register_deactivation_hook($file, array($this, '_deactivate_plugin'));
			\add_action( 'uninstall_' . plugin_basename($file), array($this, '_uninstall_plugin'));
		}
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Get option name
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * Get option values for one, many or all fields
	 *
	 * @param string|array $field The field(s) to get
	 * @return mixed Whatever is in those fields
	 */
	public function get($field='')
	{
		$data = get_option($this->key, array());
		$data = $this->array_merge_recursive_simple($this->defaults, $data);
		return $this->_get($field, $data);
	}


	/**
	 * Get default values for one, many or all fields
	 *
	 * @param string|array $field The field( s ) to get
	 * @return mixed Whatever is in those fields
	 */
	public function getDefaults($field='')
	{
		return $this->_get($field, $this->defaults);
	}

	/**
	 * Set all data fields, certain fields or a single field
	 *
	 * @param string|array $field The field to update or an associative array
	 * @param mixed $value The new value ( ignored if $field is array )
	 * @return null
	 */
	public function set($field, $value='')
	{
		$newdata = (is_array($field)) ? $field : array($field => $value);
		$this->update($this->array_merge_recursive_simple($this->get(), $newdata));
	}

	/**
	 * Reset option to defaults
	 *
	 * @return null
	 */
	public function reset()
	{
		$this->update($this->defaults, false);
	}

	/**
	 * Remove any keys that are not in the defaults array
	 *
	 * @return bool
	 */
	public function cleanup()
	{
		$this->update($this->_clean($this->get()));
	}

	/**
	 * Update raw data
	 *
	 * @param mixed $newdata
	 * @param bool $clean wether to remove unrecognized keys or not
	 * @return null
	 */
	public function update($newdata, $clean = true)
	{
		if ($clean) $newdata = $this->_clean($newdata);
		update_option($this->key, $newdata);
	}

	/**
	 * Delete the option
	 *
	 * @return null
	 */
	public function delete()
	{
		delete_option($this->key);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Saves an extra query
	 *
	 * @internal
	 */
	public function _activate_plugin()
	{
		trigger_error(__FUNCTION__);
		add_option($this->key, $this->defaults);
	}

	/**
	 * Delete option
	 *
	 * @internal
	 */
	public function _deactivate_plugin()
	{
		trigger_error(__FUNCTION__);
		$this->delete();
	}

	/**
	 * Delete options
	 *
	 * @internal
	 */
	public static function _uninstall_plugin()
	{
		trigger_error(__FUNCTION__);
		$this->delete();
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Takes the first array as master only overwrites what is in the additional arrays
	 *
	 * @return array
	 */
	private function array_merge_recursive_simple()
	{
		$arrays = func_get_args();
		if (count($arrays) < 2) return (count($arrays) == 1) ? $arrays[0] : array();

		$first = true;
		$merged = array();
		while ($arrays) {
			$array = array_shift($arrays);
			if (!is_array($array)) {
				trigger_error(__FUNCTION__ .' encountered a non array argument', E_USER_WARNING);
				return;
			}
			if (!$array) continue;
			foreach ($array as $key => $value) {
				if (!$first && !isset($merged[$key])) continue;
				if (is_string($key)) {
					if (is_array($value) && array_key_exists($key, $merged) && is_array($merged[$key])) {
						$merged[$key] = call_user_func(array($this, __FUNCTION__), $merged[$key], $value);
					} else {
						$merged[$key] = $value;
					}
				} else {
					$merged[] = $value;
				}
			}
			$first = false;
		}
		return $merged;
	}

	/**
	 * Keep only the keys defined in $this->defaults
	 *
	 * @param array $data
	 * @return array
	 */
	private function _clean($data)
	{
		$r = array();
		foreach (array_keys($this->defaults) as $key) if (isset($data[$key])) $r[$key] = $data[$key];
		return $r;
	}

	/**
	 * Get one, more or all fields from an array
	 *
	 * @param string $field
	 * @param array $data
	 * @return  array
	 */
	private function &_get($field, $data)
	{
		if (empty($field)) return $data;
		if (is_string($field)) return $data[$field];
		$result = array();
		foreach ($field as $key) if (isset($data[$key])) $result[] = $data[$key];
		return $result;
	}

	//---------------------------------------------------------------------------------------------
	// ~ Magic methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Magic method: $options->field
	 *
	 * @param string $field
	 * @return mixed
	 */
	public function __get($field)
	{
		return $this->get($field);
	}

	/**
	 * Magic method: $options->field = $value
	 *
	 * @param string $field
	 * @param mixed $value
	 */
	public function __set($field, $value)
	{
		$this->set($field, $value);
	}

	/**
	 * Magic method: isset( $options->field )
	 *
	 * @param string $field
	 * @return boolean
	 */
	public function __isset($field)
	{
		$data = $this->get();
		return isset($data[$field]);
	}

}