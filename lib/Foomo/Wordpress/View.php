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
class View extends \Foomo\View
{
	//---------------------------------------------------------------------------------------------
	// ~ Public static methods
	//---------------------------------------------------------------------------------------------

	/**
	 * 
	 * @param mixed $className
	 * @param string $fileName
	 * @param mixed $model
	 * @return Foomo\Wordpress\View 
	 */
	public static function locate($className, $fileName, $model)
	{
		$className = (\is_object($className)) ? \get_class($className) : $className;
		$moduleName = \Foomo\Modules\Manager::getModuleByClassName($className);
		$viewsDir = \call_user_func(array(\Foomo\Modules\Manager::getModuleClassByName($moduleName), 'getViewsDir')) ;
		$path =  $viewsDir . \DIRECTORY_SEPARATOR . \implode(\DIRECTORY_SEPARATOR, explode('\\', $className)) . \DIRECTORY_SEPARATOR . $fileName;
		return self::fromFile($path, $model);
	}
}