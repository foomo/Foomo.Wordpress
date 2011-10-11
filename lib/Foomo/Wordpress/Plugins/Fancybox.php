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

namespace Foomo\Wordpress\Plugins;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Fancybox extends \Foomo\Wordpress\Plugins\AbstractPlugin
{
	//---------------------------------------------------------------------------------------------
	// ~ Variables
	//---------------------------------------------------------------------------------------------

	/**
	 * @var Foomo\Wordpress\Options
	 */
	private $options;

	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 *
	 */
	public function setup()
	{
		# Creating an options object
		$this->options = new \Foomo\Wordpress\Options('foomo_fancybox', $this->file, array(
			'automode' => false,
			'footer_script' => '$(document).ready(function() {$("a[rel^=fancybox]").fancybox();});',
		));

		# do plugin stuff
		if (!is_admin()) {
			wp_enqueue_style('jquery.fancybox', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath() . '/fancybox/jquery.fancybox-1.3.4.css', array(), '1.3.4', 'screen');
			wp_enqueue_script('jquery.easing', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath() . '/fancybox/jquery.easing-1.3.pack.js', array('jquery'), '1.3', true);
			wp_enqueue_script('jquery.fancybox', \Foomo\Utils::getServerUrl() . \Foomo\Wordpress\Module::getPluginsPath() . '/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery', 'jquery.easing'), '1.3.4', true);
			\Foomo\Wordpress\Frontend::addFooterScript($this->options->footer_script);
			if ($this->options->automode) {
				add_filter('the_content', array($this, '_the_content'), 99);
				add_filter('the_excerpt', array($this, '_the_content'), 99);
			}
		}



		# admin page
		\Foomo\Wordpress\AdminPage\Fancybox::register($this->file, $this->options);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public internal methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @internal
	 * @global type $post
	 * @param type $content
	 * @return type
	 */
	public function _the_content($content)
	{
		global $post;
		$pattern        = "/(<a(?![^>]*?rel=['\"]fancybox.*)[^>]*?href=['\"][^'\"]+?\.(?:bmp|gif|jpg|jpeg|png)['\"][^\>]*)>/i";
		$replacement    = '$1 rel="fancybox-' . $post->ID . '">';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}
}