<?php
/*
	GlobalVarService (global) service

	- service that permits to access and handle superglobal variable $GLOBAL


	---- Changelog ---
	Rev 1.0 - November 20th, 2017
			- Basic functionality


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

	namespace AzzurroFramework\Core\Modules\AF\Superglobal\GlobalVar;

	use \InvalidArgumentException;


	//--- GlobalVarService service ----
	final class GlobalVarService {

		// $GLOBAL supervariable
		private $global;


		// Contructor
		public function __construct() {
			global $GLOBAL;

			// Save the pointer to $GLOBAL
			$this->global = &$GLOBAL;
		}

		// Return the requested value from its key
		public function get(string $name) {
			return $this->global[$name];
		}

		// Check if the requested key exists
		public function isSet(string $name) {
			return isset($this->global[$name]);
		}

	}