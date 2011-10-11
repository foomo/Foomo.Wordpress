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

namespace Foomo\Wordpress\Utils;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Hooks
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param mixed $class
	 */
	public static function register($class)
	{
		self::_do('add', $class);
	}

	/**
	 * @param mixed $class
	 */
	public static function unregister($class)
	{
		self::_do('remove', $class);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $action
	 * @param mixed $class
	 */
	private static function _do($action, $class)
	{
		$reflection = new \ReflectionClass($class);

		foreach ($reflection->getMethods() as $method) {
			if ($method->isPublic() && !$method->isConstructor()) {
				$comment = $method->getDocComment();

				if (preg_match('/@nohook[ \t\*\n]+/', $comment)) {
					continue;
				}

				preg_match_all('/@add_filter?\s+([^\s]+)/', $comment, $filterMatches);

				if (!empty($filterMatches[1])) {
					$filterHooks = $filterMatches[1];
					$filterPriority = preg_match('/@filter_priority?\s+(\d+)/', $comment, $filterMatches) ? $filterMatches[1] : 10;
					foreach ($filterHooks as $filterHook) {
						call_user_func($action .'_filter', $filterHook, array($class, $method->name), $filterPriority, $method->getNumberOfParameters());
					}
				}

				preg_match_all('/@add_action?\s+([^\s]+)/', $comment, $actionMatches);
				if (!empty($actionMatches[1])) {
					$filterHooks = $actionMatches[1];
					$actionPriority = preg_match('/@action_priority?\s+(\d+)/', $comment, $actionMatches) ? $filterMatches[1] : 10;
					foreach ($filterHooks as $filterHook) {
						call_user_func($action . '_action', $filterHook, array($class, $method->name), $actionPriority, $method->getNumberOfParameters());
					}
				}
			}
		}
	}
}