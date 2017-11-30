<?php
/*
	Azzurro Framework main class

	- define the AzzurroFramework class
	- instantiate the $af global Object


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

	namespace AzzurroFramework\Core;

	use \InvalidArgumentException;
	use \AzzurroFramework\Core\Exception\App\AppModuleNotRegisteredException;
	use \AzzurroFramework\Core\Exception\Module\ModuleAlreadyRegisteredException;
	use \AzzurroFramework\Core\Exception\Module\ModuleNotFoundException;

	use \AzzurroFramework\Core\Injector\Injector;
	use \AzzurroFramework\Core\Module\Module;

	use \AzzurroFramework\Core\AF\Injector\InjectorService;
	use \AzzurroFramework\Core\AF\Filters\FiltersService;



	//--- AzzurroFramework class ----
	final class AzzurroFramework {

		// Singleton instance
		private static $self = null;

		// Application modules
		private $modules;
		// App module
		private $app;
		// Injector
		private $injector;


		//--- SINGLETON COSTRUCTOR ----
		// Singleton object
		public static function getInstance() {
			// If there isn't an instance, then create it
			if (self::$self == null) {
				self::$self = new self();
			}

			// Return the instance
			return self::$self;
		}

		// Private contructor because is singleton
		private function __construct() {
			// Prepare the variables
			$this->modules = array();
			$this->app = null;
			$this->injector = new Injector($this->modules);

			// Reister af module components
			$this->registerAFModuleComponent();
		}

		//--- CERATING AND GETTING THE MAIN MODULE ---
		// Method to create and get the main module of the application
		public function app(string $name, array $dependencies = null) {
			// Check the correctness of the the arguments
			if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name)) {
				throw new InvalidArgumentException("\$name argument must be a valid module name!");
			}
			if (!is_null($this->app) and $app != $name) {
				throw new ModuleAlreadyRegisteredException("App module has been already registered!");
			}

			// Use module method to retrive or create the module
			$module = $this->module($name, $dependencies);

			if (!is_null($dependencies)) {
				$this->app = $name;
			}

			// Return the Module instance
			return $module;
		}

		//--- CREATING AND GETTING MODULES ---
		// Method to create and get a module
		public function module(string $name, array $dependencies = null) {
			// Check the correctness of the the arguments
			if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name)) {
				throw new InvalidArgumentException("\$name argument must be a valid module name!");
			}
			if (!is_null($dependencies)) {
				foreach ($dependencies as $dependency) {
					if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $dependency)) {
						throw new InvalidArgumentException("\$dependencies argument must be a valid array of module names!");
					}
				}
			}
			// Check if the module requested exists
			if (!array_key_exists($name, $this->modules) and is_null($dependencies)) {
				throw new ModuleNotFoundException("Module '$name' has not been registered!");
			}

			// If the module doesn't exists, create a new one
			if (!array_key_exists($name, $this->modules) and !is_null($dependencies)) {
				// Create the new module
				$this->modules[$name] = [
					'dependencies' => $dependencies
				];
			}

			// Return the Module instance
			return new Module($this->modules[$name]);
		}

		//--- EXECUTING THE FRAMEWORK ---
		// Boostrap the framework
		public function boostrap() {
			if (is_null($this->app)) {
				throw new AppModuleNotRegisteredException("App module has not been defined!");
			}

			// Resolve the dependencies of the app module
			$this->injector->resolveApplicationDependencies($this->app);
			
			echo "<br>resolved!<br>";
		}

		//--- VERSION INFO ---
		// Return the version of the framework
		public function version() {
			return __AF_VERSION__;
		}

		//--- REGISTER COMPONENTS OF MODULE af ---
		public function registerAFModuleComponent() {
			// Create the module
			$af = $this->module("af", []);

			// Prepare the injector to pass to services
			$injector = $this->injector;

			// $events services
			$af->service("events", "\AzzurroFramework\Core\AF\Events\EventsService");

			// $filters services
			$af->factory("filters", function () use ($injector) {
				return new FiltersService($injector);
			});

			// $injector services
			$af->factory("injector", function () use ($injector) {
				return new InjectorService($injector);
			});

		}

	}
