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

	use \InvalidArgumentException;


	/*
		PROCESS REQUEST ORDER
			1. when conditions
			2. states
			3. otherwhise condition
	*/


	//--- RouterService service ----
	final class RouterService {

		// Event to which start the routing
		const EVENT_ROUTE = "RouterService::route";

		// Service config
		private $config;

		// Services
		private $injector; // $injector
		private $controller; // $controller

		private $current; // Current state

		// Indicates if the first route has been made
		private $firstRoute;


		// Contructor
		public function __construct(&$config, $injector, $controller) {
			$this->config = &$config;

			// Save the Services
			$this->injector = $injector;
			$this->controller = $controller;

			// Prepare the variable
			$this->current = array(
				"url" => "",
				"state" => null,
				"params" => null
			);
			$this->firstRoute = false;
		}

		// Method that route the request
		public function route(string $url) {
			//check the argument correctness
			if (!preg_match("/^(\/[a-zA-Z0-9_]+)*(\/|(\/?\?[a-zA-Z0-9_]+(\=?[^\&]+)?(\&[a-zA-Z0-9_]+(\=?[^\&]+)?)*))?$/", $url)) { // Url must be a valid url path
				throw new InvalidArgumentException("\$url must be a valid url path!");
			}

			// Check if the current url is different from the one just passed (no recursion) and the first rute has happened
			if ($this->firstRoute && ($this->current['url'] == $url or $this->current['url'] == substr($url, 1, -1))) {
				return;
			}
			// The first route has happened
			if (!$this->firstRoute) {
				$this->firstRoute = true;
			}

			// Reset current state and params
			$this->current['state'] = null;
			$this->current['params'] = null;

			// Search a when condition maching the URL
			$whenCondition = $this->searchWhenCondition($url);
			// If the when condition is found
			if (!is_null($whenCondition)) {
				// Updating current URL
				$this->current['url'] = $url;
				// Call the callback
				$this->injector->call($whenCondition['callback']);
				// Route finished
				return;
			}

			// If the when condition is not found search for a state
			$state = $this->searchStateByUrl($url);
			// If the state is found
			if (!is_null($state)) {
				// Updating current URL
				$this->current['url'] = $url;
				// Execute the state transition
				$this->transit($state);
				// Route finished
				return;
			}

			// If the state is not found call the otherwhise callback
			if (!is_null($this->config['otherwhise'])) {
				// Updating current URL
				$this->current['url'] = $url;
				// Call teh otherwise callback
				$this->injector->call($this->config['otherwhise']);
			}

			// Updating current URL
			$this->current['url'] = $url;

		}

		// Method to change the current state
		public function go(string $name, array $params = null) {
			// Check if the name is valid
			if (!preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $state['name'])) {
				InvalidArgumentException("'name' field must be a valid state name!");
			}
			if (!is_null($params)) {
				foreach ($params as $key => $value) {
					if (!is_string($key) or !is_string($value)) {
						throw new InvalidArgumentException("\$params must be a valid array of params!");
					}
				}
			}

			// If the when condition is not found search for a state
			$state = $this->searchStateByName($name);
			// If the state is found
			if (!is_null($state)) {
				// Save the parameters
				$this->current['params'] = $params;
				// Execute the state transition
				$this->transit($state);
			}
		}

		// Return the specific restful parameter without ':'
		public function getParameter(string $name) {
			// Check if there are params
			if (is_null($this->current['params'])) {
				return null;
			}
			// Check if the requested params exists
			if (!isset($this->current['params'][$name])) {
				return null;
			}

			// Return the requested param
			return $this->current['params'][$name];
		}

		// Return the current state
		public function current() {
			$current = array();

			// If the current state exists
			if (!is_null($this->current['state'])) {
				foreach ($this->current['state'] as $key => $value) {
					// Do not copy the processing data
					if ($key == "urlExploded") {
						continue;
					}

					// Copy the state field
					$current[$key] = $value;
				}
			}

			// Return the current state
			return $state;
		}
		

		// Transit method, it will execute the transitions
		private function transit($state) {
			// Save the current state
			$this->current['state'] = $state;

			// Getting the template processor
			$processor = $this->injector->get($this->config['templateProcessor']);
			// Reset the template processor
			$processor->reset();
			// Setting up the template
			if (isset($state['template'])) {
				$processor->setTemplate($state['template'], false);
			} else if (isset($state['templateUrl'])) {
				$processor->setTemplate($state['templateUrl'], true);
			}

			// Execute the controller
			$render = $this->controller->execute($state['controller']);

			// If the controller wants to render it's view
			if ($render) {
				$processor->render();
			}
		}

		// Search a when condition matching the url
		private function searchWhenCondition($url) {
			// Explode $url
			if (substr_compare($url, "/", strlen($url) -1, 1) === 0) {
				$urlExploded = explode("/", "" . substr($url, 1, -1));
			} else {
				$urlExploded = explode("/", "" . substr($url, 1));
			}

			// Check all the when condition url field
			foreach ($this->config['whenConditions'] as &$condition) {
				// If the url has not been exploded in a previus run
				if (!isset($condition['urlExploded'])) {
					// Explode the url
					if (substr_compare($condition['url'], "/", strlen($condition['url']) -1, 1) === 0) {
						$condition['urlExploded'] = explode("/", "" . substr($condition['url'], 1, -1));
					} else {
						$condition['urlExploded'] = explode("/", "" . substr($condition['url'], 1));
					}
				}

				// If the two urls are the same return the condition
				if ($this->compareUrl($urlExploded, $condition['urlExploded'])) {
					return $condition;
				}

			}

			// No condition has been found
			return null;
		}

		// Search a state matching the url
		private function searchStateByUrl($url) {
			// Explode $url
			if (substr_compare($url, "/", strlen($url) -1, 1) === 0) {
				$urlExploded = explode("/", "" . substr($url, 1, -1));
			} else {
				$urlExploded = explode("/", "" . substr($url, 1));
			}

			// Check all the state url field
			foreach ($this->config['states'] as &$state) {
				// Check if the state has the url field
				if (isset($state['url'])) {
					// If the url has not been exploded in a previus run
					if (!isset($state['urlExploded'])) {
						// Explode the url
						if (substr_compare($state['url'], "/", strlen($state['url']) -1, 1) === 0) {
							$state['urlExploded'] = explode("/", "" . substr($state['url'], 1, -1));
						} else {
							$state['urlExploded'] = explode("/", "" . substr($state['url'], 1));
						}
					}

					// If the two urls are the same return the state
					if ($this->compareUrl($urlExploded, $state['urlExploded'])) {
						return $state;
					}
				}
			}

			// No state has been found
			return null;
		}

		// Search a state matching the name
		private function searchStateByName($name) {
			// Check all the when state url property
			foreach ($this->config['states'] as $state) {
				// Check if the state has the url field
				if (isset($state['name'])) {
					if ($state['name'] == $name) {
						return $state;
					}
				}
			}

			// No state has been found
			return null;
		}

		// Method that will compare two exploded url 
		// url1 is the reference, url2 is the candidate
		private function compareUrl($url1, $url2) {
			// Array to contains all the rest parameters
			$params = array();

			// Check the length of the url exploded, if they are different the urls are different
			if (count($url1) != count($url2)) {
				return false;
			}

			// Check all the url parts, if one of these is different the urls are different
			for ($i = 0; $i < count($url1) -1; $i++) {
				// If url2 is a parameter, save it and continue
				if (substr_compare($url2[$i], ":", 1, 1) === 0) {
					$params[substr($url2[$i], 1)] = $url1[$i];
					continue;
				}

				// If the two part of the same index are different
				if ($url1[$i] != $url2[$i]) {
					return false;
				}
			}

			// Explode last part of the urls
			$url1LastExploded = explode("?", $url1[count($url1) -1]);
			$url2LastExploded = explode("?", $url2[count($url2) -1]);

			// If $url2LastExploded[0] is a parameter, save it and continue processing
			if (!empty($url2LastExploded[0]) and substr_compare($url2LastExploded[0], ":", 1, 1) === 0) {
				$params[substr($url2LastExploded[0], 1)] = $url1LastExploded[0];
			
			// If the $url1LastExploded[0] != $url2LastExploded[0], the urls are different
			} else if ($url1LastExploded[0] != $url2LastExploded[0]) {
				return false;
			}

			// If the query string is present in url2
			if (isset($url2LastExploded[1])) {

				// If query string is not present in url1, the urls are different
				if (!isset($url1LastExploded[1])) {
					return false;
				}

				// Explode the query string
				$url1QueryString = explode("&", $url1LastExploded[1]);
				$url2QueryString = explode("&", $url2LastExploded[1]);

				// If the query string has different length, the urls are different
				if (count($url1QueryString) != count($url2QueryString)) {
					return false;
				}

				// Clean url1QueryString (it's of the type token=value and it is needed only token)
				foreach ($url1QueryString as $key => &$value) {
					$pos = strpos($value, "=");
					if ($pos !== false) {
						$value = substr($value, 0, $pos);
					}
				}

				// Check the query string
				for ($i = 0; $i < count($url1QueryString); $i++) {
					// If the two part of the same index are different
					if ($url1QueryString[$i] != $url2QueryString[$i]) {
						return false;
					}
				}

			}

			// The url are equal
			// Save the params
			$this->current['params'] = $params;
			// Return that the url has been resolved
			return true;
		}


	}