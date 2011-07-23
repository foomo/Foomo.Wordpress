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
class RemoteFile
{
	//---------------------------------------------------------------------------------------------
	// ~ Constants
	//---------------------------------------------------------------------------------------------

	const TTL = '1 day';

	//---------------------------------------------------------------------------------------------
	// ~ Public methods
	//---------------------------------------------------------------------------------------------

	/**
	 * @see http://inanimatt.com/php-curl.php for license & known issues
	 *
	 * @param string $url
	 * @param string $ttl
	 * @return string
	 */
	public static function getFile($url, $ttl='7 day')
	{
		$cache_path = \Foomo\Wordpress\Module::getCacheDir('RemoteFile');
		$cache_file = $cache_path . '/' . md5($url) . '.dat';
		$cache_exists = is_readable($cache_file);

		if ($cache_exists && (filemtime($cache_file) >= strtotime('-' . $ttl))) {
			return file_get_contents($cache_file);
		}

		#trigger_error('Getting remote file: ' . $url);

		/* Need to regenerate the cache. First thing to do here is update
		 * the modification time on the cache file so that no one else
		 * tries to update the cache while we're updating it.
		 */
		touch($cache_file);
		clearstatcache();


		/* Set up the cURL pointer. It's important to set a User-Agent
		 * that's unique to you, and provides contact details in case your
		 * script is misbehaving and a server owner needs to contact you.
		 * More than that, it's just the polite thing to do.
		 */
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_TIMEOUT, 15);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, TRUE);


		/* If we've got a cache, do the web a favour and make a
		 * conditional HTTP request. What this means is that if the
		 * server supports it, it will tell us if nothing has changed -
		 * this means we can reuse the cache for a while, and the
		 * request is returned faster.
		 */
		if ($cache_exists) {
			curl_setopt($c, CURLOPT_TIMECONDITION, CURL_TIMECOND_IFMODSINCE);
			curl_setopt($c, CURLOPT_TIMEVALUE, filemtime($cache_file));
		}


		/* Make the request and check the result. */
		$content = curl_exec($c);
		$status = curl_getinfo($c, CURLINFO_HTTP_CODE);

		// Document unmodified? Return the cache file
		if ($cache_exists && ($status == 304)) {
			return file_get_contents($cache_file);
		}

		/* You could be more forgiving of errors here. I've chosen to
		 * fail hard instead, because at least it'll be obvious when
		 * something goes wrong.
		 */
		if ($status != 200) {
			throw new \Exception('Unexpected HTTP return code ' .  $status . ' for ' . $url);
		}


		/* If everything is fine, save the new cache file, make sure
		 * it's world-readable, and writeable by the server
		 */
		file_put_contents($cache_file, $content);
		chmod($cache_file, 0644);
		return $content;
	}
}