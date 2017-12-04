<?php
/*
	RouterService (router) service

	- service that permits to use the router


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

	namespace AzzurroFramework\Core\Modules\AF\Router;

	use \IllgealArgumentException;


	//--- RouterService provider ----
	final class RouterService {

		// Event to which start the routing
		const ROUTE_EVENT = "AF:callback";


		// Contructor
		public function __construct() {

		}

		// Method that route the request
		public function route() {

			echo "<br><b><i>ROUTING!</i></b><br>";

		}

		public function go(string $state) {

		}

		// Return the specific restful parameter
		public function get(string $name) {

		}

	}