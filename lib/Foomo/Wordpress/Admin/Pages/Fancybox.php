<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Foomo\Wordpress\Admin\Pages;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Fancybox extends \Foomo\Wordpress\Admin\Pages\AbstractDefaultPage
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
			'page_title' => 'Foomo Fancybox Settings',
			'menu_title' => 'Fancybox',
			'parent' => 'foomo'
		);
	}

	/**
	 *
	 */
	public function page_content()
	{
		$out = '';
		$rows = array();


		# auto activate
		$rows[] = array(
			'title' => 'Automode',
			'type'	=> 'checkbox',
			'name'	=> 'automode'
		);

		# footer js script
		$rows[] = array(
			'title' => 'Footer Script',
			'type'	=> 'textarea',
			'name'	=> 'footer_script',
			'extra' => array( 'rows' => 7, 'cols' => 100 )
		);

		$out .= \Foomo\Wordpress\View::html('h3', 'Disable Updates');
		$out .= $this->table($rows);

		# output
		echo $this->form_wrap($out);
	}

	/**
	 *
	 */
	public function validate($options)
	{
		# checkboxes
		foreach (array('automode') as $key) $options[$key] = (bool) @$options[$key];

		return $options;
	}

}