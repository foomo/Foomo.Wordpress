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
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class View
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $class
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	public static function render($class, $template, $model=null)
	{
		$module = \Foomo\Modules\Manager::getModuleByClassName($class);
		$docRootModule = \Foomo\Modules\Manager::getDocumentRootModule();
		$template = '/views/' . str_replace('\\', '/', $class) . '/' . $template . '.tpl';
		if ($module != $docRootModule && file_exists(\Foomo\Config::getModuleDir($docRootModule) . $template)) {
			$template = \Foomo\Config::getModuleDir($docRootModule) . $template;
		} else {
			$template = \Foomo\Config::getModuleDir($module) . $template;
		}
		return \Foomo\View::fromFile($template, $model)->render();
	}

	/**
	 * @param string $tag
	 * @param string $content
	 * @param array $attributes
	 * @return string
	 */
	public static function html($tag, $content=null, $attributes=array())
	{
		$closing = $tag;
		foreach ( $attributes as $key => $value ) {
			if (false === $value) continue;
			if (true === $value) $value = $key;
			$tag .= ' ' . $key . '="' . esc_attr( $value ) . '"';
		}
		return (in_array($closing, array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta'))) ? "<{$tag} />" : "<{$tag}>{$content}</{$closing}>";
	}

	/**
	 *
	 * @param string $url
	 * @param string $title
	 * @return string
	 */
	public static function link($url, $title=null)
	{
		if (is_null($title)) $title = $url;
		return self::html('a', $title, array('href' => $url));
	}
}