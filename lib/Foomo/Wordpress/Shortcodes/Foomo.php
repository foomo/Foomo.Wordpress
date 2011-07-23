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

namespace Foomo\Wordpress\Shortcodes;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Foomo extends AbstractShortcodes
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract method implementations
	//---------------------------------------------------------------------------------------------

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public static function getShortcodes()
	{
		return array(
			'shortcode_foomo_run' => array('foomo_run'),
		);
	}

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public static function enqueueScripts()
	{
		wp_enqueue_script('swfobject');
	}

	/**
	 * @see Foomo\Wordpress\Shortcodes\AbstractShortcodes
	 */
	public static function enqueueStyles()
	{
	}

	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param array $atts
	 * @param string $content
	 * @param type $code
	 */
	public static function shortcode_foomo_run($atts, $content=null, $code="")
	{
		global $post;
		extract(shortcode_atts(array('app' => null), $atts));

		if (is_null($app)) return null;

		if (strpos($app, '.') >= 0) $app = str_replace('.', '\\', $app) . '\\Frontend';


		if (!is_null($content)) {
			# trim content
			$content = json_decode(trim($content), true);
			if (is_null($content)) trigger_error('Could not decode ' . $content, E_USER_WARNING);

			# get reflection
			$appClass = new \ReflectionClass($app);
			$method = $appClass->getMethod('__construct');
			$methodParms = $method->getParameters();

			# set parameters
			if (count($methodParms) > 0) {
				# order parms
				$appParams = array();
				foreach ($methodParms as $methodParm) {
					$appParams[] = (isset($content[$methodParm->name])) ? $content[$methodParm->name] : null;
				}
				# create instance
				$app = $appClass->newInstanceArgs($appParams);
			}
		}

		$baseUrl = str_replace(home_url(), '', get_permalink($post->ID));
		if (substr($baseUrl, -1) == '/') $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);

		return \Foomo\MVC::run($app, $baseUrl . '/?', false, true);
	}
}