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

namespace Foomo\Wordpress\Walkers;

// this is a autoloader hack
include_once(\Foomo\CORE_CONFIG_DIR_MODULES . DIRECTORY_SEPARATOR . \Foomo\Wordpress\Module::NAME . DIRECTORY_SEPARATOR . 'htdocs' . DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . 'wp-includes' . DIRECTORY_SEPARATOR . 'class-wp-walker.php');

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
abstract class AbstractWalker extends \Walker
{
	//---------------------------------------------------------------------------------------------
	// ~ Abstract methods
	//---------------------------------------------------------------------------------------------

	/**
	 * Starts the list before the elements are added.
	 *
	 * Additional parameters are used in child classes. The args parameter holds
	 * additional values that may be used with the child class methods. This
	 * method is called at the start of the output list.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 */
	#function start_lvl(&$output) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * Additional parameters are used in child classes. The args parameter holds
	 * additional values that may be used with the child class methods. This
	 * method finishes the list at the end of output of the elements.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 */
	#function end_lvl(&$output)   {}

	/**
	 * Start the element output.
	 *
	 * Additional parameters are used in child classes. The args parameter holds
	 * additional values that may be used with the child class methods. Includes
	 * the element output also.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 */
	#function start_el(&$output)  {}

	/**
	 * Ends the element output, if needed.
	 *
	 * Additional parameters are used in child classes. The args parameter holds
	 * additional values that may be used with the child class methods.
	 *
	 * @since 2.1.0
	 * @abstract
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 */
	#function end_el(&$output)    {}

	/**
	 * This function is designed to enhance Walker::display_element() to
	 * display children of higher nesting levels than selected inline on
	 * the highest depth level displayed. This prevents them being orphaned
	 * at the end of the comment list.
	 *
	 * Example: max_depth = 2, with 5 levels of nested content.
	 * 1
	 *  1.1
	 *    1.1.1
	 *    1.1.1.1
	 *    1.1.1.1.1
	 *    1.1.2
	 *    1.1.2.1
	 * 2
	 *  2.2
	 *
	 */
	#public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {}

	//---------------------------------------------------------------------------------------------
	// ~ Protected methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $template
	 * @param mixed $model
	 * @return string
	 */
	protected static function renderView($template, $model=null)
	{
		return \Foomo\Wordpress\View::render(get_called_class(), $template, $model);
	}
}