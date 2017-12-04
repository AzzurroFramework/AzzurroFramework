<?php
/*
	RouterServiceProvider (routerProvider) service

	- provider that permits to setting up the $router service


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

	use \AzzurroFramework\Core\Interfaces\Service\ServiceProviderInterface;

	/*
		STATE DEFINITION

		$routeProvider.state([
			"name" => "state_name", 				// Optional, must be a valid variable name
			"url" => "state/url", 					// Mandatory
			"controller" => "controller_name", 		// Mandatory
			"template" => "template in string", 	// Optional, only template, templateUrl or message in the same state definition
			"templateUrl" => "path/to/find/tpl"		// Optional, only template, templateUrl or message in the same state definition
			"message" => "message in string",		// Optional, only template, templateUrl or message in the same state definition
			"api" => "true"							// Optional, must a be boolean
		]);

		If it's defined '"api" => true', only message can be defined: template, templateUrl will be considered errors.
		If it's defined 'template', 'templateUlr' will be considered error and vice versa.
	*/


	//--- RouterServiceProvider provider ----
	final class RouterServiceProvider implements ServiceProviderInterface {

		// Variable that contains all the configuration for the service
		private $config;


		// Constructor of the injector service
		public function __construct() {
			// Default settings
			$this->config = [
				"states" => array(),
				"when" => array(),
				"otherwhise" => null,
			];
		}

		// Register a state
		public function state(array $state) {

		}

		// Register a callback executed when the requested url matches
		public function when(string $url, callback $callback) {

		}

		// Register a callback executed when no states and no when conditions matches
		public function otherwhise(callback $callback) {
			
		}

		// Getting the service
		public function get() {
			return new RouterService($this->config);
		}

	}