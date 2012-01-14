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

namespace Foomo;

/**
 * @link www.foomo.org
 * @license www.gnu.org/licenses/lgpl.txt
 * @author franklin <franklin@weareinteractive.com>
 */
class Wordpress
{
	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------
	
	public static function registerObjects()
	{
		# resiter object hooks
		\Foomo\Timer::addMarker('Registering wordpress object hooks :: start');
		foreach (\Foomo\AutoLoader::getClassesBySuperClass('Foomo\\Wordpress\\Object') as $class) {
			if ($class == 'Foomo\Wordpress\Object') continue;
			if (\substr($class, -5) == '\Base') continue;
			\Foomo\Wordpress\Utils::registerHooks($class);
		}
		\Foomo\Timer::addMarker('Registering wordpress object hooks :: end');
	}
}