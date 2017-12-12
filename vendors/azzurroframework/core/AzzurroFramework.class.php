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
	use \AzzurroFramework\Core\Exceptions\App\AppModuleNotRegisteredException;
	use \AzzurroFramework\Core\Exceptions\Module\ModuleAlreadyRegisteredException;
	use \AzzurroFramework\Core\Exceptions\Module\ModuleNotFoundException;

	use \AzzurroFramework\Core\Injector\Injector;
	use \AzzurroFramework\Core\Module\Module;

	use \AzzurroFramework\Core\Modules\Auto\Injector\InjectorService;
	use \AzzurroFramework\Core\Modules\Auto\Filter\FilterService;
	use \AzzurroFramework\Core\Modules\Auto\Controller\ControllerService;


	//--- AzzurroFramework class ----
	final class AzzurroFramework {

		// Event AF:started
		const EVENT_STARTED = "AF:started";
		// Event AF:ended
		const EVENT_ENDED = "AF:ended";

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
			$this->registerAutoModuleComponent();
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

			// Check if the module is the app one
			if ($this->app == $name) {
				return $this->app($name, $dependencies);
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

			// Getting $event service
			$event = $this->injector->getService("event");
			$azzurro = $this->injector->getService("azzurro");

			// Generate event AF:started
			$event->emit(self::EVENT_STARTED);

			// Generate event to start the routing process
			$event->emit($azzurro->getRouteEvent());

			// Generate event to start all the callback
			$event->emit($azzurro->getCallbackEvent());

			// generate event AF:endend
			$event->emit(self::EVENT_ENDED);

		}

		//--- VERSION INFO ---
		// Return the version of the framework
		public function version() {
			return __AF_VERSION__;
		}

		//--- REGISTER COMPONENTS OF MODULE af ---
		public function registerAutoModuleComponent() {
			// Create the module
			$auto = $this->module("auto", []);

			// Prepare the injector to pass to services
			$injector = $this->injector;

			// $azzurro service
			$auto->provider("azzurro", "\AzzurroFramework\Core\Modules\Auto\Azzurro\AzzurroServiceProvider");

			// $controller service
			$auto->factory("controller", function () use ($injector) {
				return new ControllerService($injector);
			});

			// $events service
			$auto->service("event", "\AzzurroFramework\Core\Modules\Auto\Event\EventService");

			// $filters service
			$auto->factory("filter", function () use ($injector) {
				return new FilterService($injector);
			});

			// $injector service
			$auto->factory("injector", function () use ($injector) {
				return new InjectorService($injector);
			});

		}

	}
