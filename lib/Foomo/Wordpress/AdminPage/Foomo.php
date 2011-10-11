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

namespace Foomo\Wordpress\AdminPage;

/**
 * Administration page base class
 *
 * @link	www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author	franklin <franklin@weareinteractive.com>
 * @see		https://github.com/scribu/wp-scb-framework
 */
class Foomo extends \Foomo\Wordpress\AdminPage\AbstractBoxesPage
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
			'ajax_submit' => true,
		);

		$this->boxes = array(
			array('plugins', 'Plugins', 'normal' ),
			array('oembeds', 'OEmbeds', 'normal' ),
			array('toolkit', 'Toolkit', 'side' ),
		);
	}

	/**
	 *
	 */
	public function plugins_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->enabled_plugins as $key => $value) {
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
	 *
	 */
	public function oembeds_box()
	{
		$out = '';
		$rows = array();

		# plugins
		foreach ($this->options->enabled_oembeds as $key => $value) {
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
	 *
	 */
	public function toolkit_box()
	{
		$out = '';
		$rows = array();

		# disable core updates
		$rows[] = array(
			'title' => 'Disable Core Updates',
			'type'	=> 'checkbox',
			'name'	=> array('toolkit', 'disable_core_updates')
		);

		# disable plugin updates
		$rows[] = array(
			'title' => 'Disable Plugin Updates',
			'type'	=> 'checkbox',
			'name'	=> array('toolkit', 'disable_plugin_updates')
		);

		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}


	/**
	 *
	 */
	public function validate($newData, $oldData)
	{
		# plugins
		foreach ($this->options->enabled_plugins as $key => $value) $newData['enabled_plugins'][$key] = (bool) @$newData['enabled_plugins'][$key];
		# oembeds
		foreach ($this->options->enabled_oembeds as $key => $value) $newData['enabled_oembeds'][$key] = (bool) @$newData['enabled_oembeds'][$key];
		# toolkit
		foreach (array('disable_core_updates', 'disable_plugin_updates') as $key) $newData['toolkit'][$key] = (bool) @$newData['toolkit'][$key];

		return $newData;
	}
}