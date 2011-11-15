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

namespace Foomo\Wordpress\Admin\Pages;

/**
 * Administration page base class
 *
 * @link	www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author	franklin <franklin@weareinteractive.com>
 * @see		https://github.com/scribu/wp-scb-framework
 */
class Foomo extends \Foomo\Wordpress\Admin\Pages\AbstractBoxesPage
{
	//---------------------------------------------------------------------------------------------
	// ~ Overriden methods
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function setup()
	{
		$this->args = array(
			'page_title' => 'General Settings',
			'menu_title' => 'Foomo',
			'page_slug' => 'foomo',
			'toplevel' => 'menu',
			'screen_icon' => 'options-general',
			'icon_url' => $this->plugin_url . 'foomo/images/foomofish-16x16.png',
			'ajax_submit' => true,
		);

		$this->boxes = array(
			# normal
			array('enabledPlugins', 'Enabled Plugins', 'normal'),
			array('enabledOEmbeds', 'Enabled oEmbeds', 'normal'),
			array('enabledShortcodes', 'Enabled Shortcodes', 'normal'),
			array('enabledWidgets', 'Enabled Widgets', 'normal'),
			# side
			array('toolkit', 'Toolkit', 'side'),
			array('disabledDefaultWidgets', 'Disabled Default Widgets', 'side'),
		);
	}

	/**
	 * @internal
	 */
	public function enabledPlugins_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->enabled_plugins as $key => $value) {
			$out .= '<input type="hidden" name="enabled_plugins[' . $key . ']" value="" />';
			$rows[] = array(
				'title' => \substr($key, \strripos($key, '\\') + 1),
				'desc'	=> $key,
				'type'	=> 'checkbox',
				'name'	=> array('enabled_plugins', $key)
			);
		}
		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	/**
	 * @internal
	 */
	public function enabledOEmbeds_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->enabled_oembeds as $key => $value) {
			$out .= '<input type="hidden" name="enabled_oembeds[' . $key . ']" value="" />';
			$rows[] = array(
				'title' => \substr($key, \strripos($key, '\\') + 1),
				'desc'	=> $key,
				'type'	=> 'checkbox',
				'name'	=> array('enabled_oembeds', $key)
			);
		}
		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	/**
	 * @internal
	 */
	public function disabledDefaultWidgets_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->disabled_default_widgets as $key => $value) {
			$out .= '<input type="hidden" name="disabled_default_widgets[' . $key . ']" value="" />';
			$rows[] = array(
				'title' => \str_replace('_', ' ', \str_replace('WP_Widget_', '', $key)),
				'desc' => $key,
				'type'	=> 'checkbox',
				'name'	=> array('disabled_default_widgets', $key)
			);
		}
		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	/**
	 * @internal
	 */
	public function enabledWidgets_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->enabled_widgets as $key => $value) {
			$out .= '<input type="hidden" name="enabled_widgets[' . $key . ']" value="" />';
			$rows[] = array(
				'title' => \substr($key, \strripos($key, '\\') + 1),
				'desc'	=> $key,
				'type'	=> 'checkbox',
				'name'	=> array('enabled_widgets', $key)
			);
		}
		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	/**
	 * @internal
	 */
	public function enabledShortcodes_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->enabled_shortcodes as $key => $value) {
			$out .= '<input type="hidden" name="enabled_shortcodes[' . $key . ']" value="" />';
			$rows[] = array(
				'title' => \substr($key, \strripos($key, '\\') + 1),
				'desc'	=> $key,
				'type'	=> 'checkbox',
				'name'	=> array('enabled_shortcodes', $key)
			);
		}
		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	/**
	 * @internal
	 */
	public function toolkit_box()
	{
		$out = '';
		$rows = array();

		# disable core updates
		$out .= '<input type="hidden" name="toolkit[disable_core_updates]" value="" />';
		$rows[] = array(
			'title' => 'Disable Core Updates',
			'type'	=> 'checkbox',
			'value' => true,
			'name'	=> array('toolkit', 'disable_core_updates')
		);

		# disable plugin updates
		$out .= '<input type="hidden" name="toolkit[disable_plugin_updates]" value="" />';
		$rows[] = array(
			'title' => 'Disable Plugin Updates',
			'type'	=> 'checkbox',
			'value' => true,
			'name'	=> array('toolkit', 'disable_plugin_updates')
		);

		# disable core updates
		$out .= '<input type="hidden" name="toolkit[custom_feed_templates]" value="" />';
		$rows[] = array(
			'title' => 'Custom Feed Templates',
			'type'	=> 'checkbox',
			'value' => true,
			'name'	=> array('toolkit', 'custom_feed_templates')
		);

		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	public function form_handler()
	{
		if (empty($_POST)) return false;

		check_admin_referer($this->nonce);

		if (!isset($this->options)) {
			trigger_error('options handler not set', E_USER_WARNING);
			return false;
		}

		$new_data = wp_array_slice_assoc($_POST, array_keys($this->options->getDefaults()));

		$new_data = stripslashes_deep($new_data);

		$new_data = $this->validate($new_data, $this->options->get());

		$this->options->set($new_data);

		$this->admin_msg();
	}

	/**
	 * @internal
	 */
	public function validate($newData, $oldData)
	{
		$checkboxBoxes = array(
			'enabled_plugins',
			'enabled_oembeds',
			'enabled_widgets',
			'enabled_shortcodes',
			'disabled_default_widgets',
			'toolkit',
		);

		foreach ($checkboxBoxes as $checkboxBox) {
			if (isset($newData[$checkboxBox])) {
				foreach ($newData[$checkboxBox] as $key => $value) {
					$oldData[$checkboxBox][$key] = (bool) $newData[$checkboxBox][$key];
				}
			}
		}

		return $oldData;
	}
}