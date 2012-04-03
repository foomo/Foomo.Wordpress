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
class Utils
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param mixed $class
	 */
	public static function registerHooks($class)
	{
		self::handleHookRegistration('add', $class);
	}

	/**
	 * @param mixed $class
	 */
	public static function unregisterHooks($class)
	{
		self::handleHookRegistration('remove', $class);
	}

	//---------------------------------------------------------------------------------------------
	// ~ Private static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @param string $action
	 * @param mixed $class
	 */
	private static function handleHookRegistration($action, $class)
	{
		# get reflection
		$reflection = new \ReflectionClass($class);
		
		# get class comment
		$comment = $reflection->getDocComment();
		
		# scan for @nohook
		if (preg_match('/@no_hooks[ \t\*\n]+/', $comment)) return;
		$filters = !(preg_match('/@no_filter_hooks[ \t\*\n]+/', $comment));
		$actions = !(preg_match('/@no_action_hooks[ \t\*\n]+/', $comment));

		foreach ($reflection->getMethods() as $method) {
			if ($method->isPublic() && !$method->isConstructor()) {
				$comment = $method->getDocComment();
				if (preg_match('/@no_hooks[ \t\*\n]+/', $comment)) continue;
				if ($filters) self::handleHookFilter($action, 'filter', $comment, $method, $class);
				if ($actions) self::handleHookFilter($action, 'action', $comment, $method, $class);
			}
		}
	}
	
	/**
	 *
	 * @param string $action
	 * @param string $type
	 * @param string $comment 
	 * @param object $method
	 * @param mixed $class
	 */
	private static function handleHookFilter($action, $type, $comment, $method, $class)
	{
		# scan for @add_action
		preg_match_all('/@add_' . $type . '?\s+(.*?)\n/s', $comment, $matches);
		if (!empty($matches[1])) {
			$filterHooks = $matches[1];
			foreach ($filterHooks as $filterHook) {
				$filterHook = trim(preg_replace('!\s+!', ' ', $filterHook));
				$parts = explode(' ', $filterHook);
				$name = (string) array_shift($parts);
				$priority = (!empty($parts)) ? intval(array_shift($parts)) : 10;
				$arguments = (!empty($parts)) ? intval(array_shift($parts)) : $method->getNumberOfParameters();
				call_user_func($action .'_' . $type , $name, array($class, $method->name), $priority, $arguments);
			}
		}
	}
}