<?php
/*
	CookieService (cookie) service

	Service that permits to handle cookies.


	Copyright 2017 Alessandro Pasqualini
	Licensed under the Apache License, Version 2.0 (the "License");
	you may not use this file except in compliance with the License.
	You may obtain a copy of the License at
    	http://www.apache.org/licenses/LICENSE-2.0
	Unless required by applicable law or agreed to in writing, software
	distributed under the License is distributed on an "AS IS" BASIS,
	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
	See the License for the specific language governing permissions and
	limitations under the License.

	@author    Alessandro Pasqualini <alessandro.pasqualini.1105@gmail.com>
	@url       https://github.com/alessandro1105
*/

	// Strict type hint
	declare(strict_types = 1);

	namespace AzzurroFramework\Core\Modules\AF\Superglobal\Cookie;

	use \InvalidArgumentException;


	//--- CookieService service ----
	final class CookieService {

		// Cookie superglobal array
		private $cookie;


		// Contructor
		public function __construct() {
			// Saving the reference to the $_COOKIE array
			$this->cookie = &$_COOKIE;
		}

		// Return the requested cookie
		public function get(string $name) {
			return $this->cookie[$name];
		}

		// Check if the requested cookie exists
		public function isset(string $name) {
			return isset($this->cookie[$name]);
		}

		// Send a cookie
		public function set(string $name, string $value, int $expire = 0, string $path, string $domain = "", bool $secure = false, bool $httponly = false) {
			// Setting up the cookie
			setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
		}

		// Expire a cookie
		public function expire(string $name) {
			setcookie($name, "", -1);
		}

	}