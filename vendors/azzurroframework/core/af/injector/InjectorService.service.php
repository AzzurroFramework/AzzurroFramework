<?php
/*
	InjectorService (injector) service

	- service that permits dependency injection
	- registration throw factory function 


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

	namespace AzzurroFramework\Core\AF\Injector;

	use \AzzurroFramework\Core\Injector\Injector;
	

	//--- InjectorService service ----
	final class InjectorService {

		// Injector instance
		private $injector;


		// Constructor of the injector service
		public function __construct(Injector $injector) {
			$this->injector = $injector;
		}

		// Get method that returns the service or constant specified
		public function get(string $name) {
			return $this->injector->getService($name);
		}

		// Returns the resolution of the dependencies of the callback
		public function resolve($callback) {
			return $this->injector->resolve($callback);
		}

		// Resolve the dependencies of the callaback and execute it
		public function call($callback) {
			return $this->injector->call($callback);
		}

	}