<?php
/*
	CallbackService (callback) service

	- service that permits to register a callback to be executed


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

	namespace AzzurroFramework\Core\Modules\AF\Callback;

	use \IllgealArgumentException;


	//--- CallbackService service ----
	final class CallbackService {

		// Event to which register the callbacks
		const CALLBACK_EVENT = "AF:callback";

		// Event service
		private $event;


		// Constructor of the injector service
		public function __construct($event) {
			$this->event = $event;
		}

		// Register a callback
		public function attach($callback) {
			// Checking arguments correctness
			if (!is_callable($callback) and !(is_array($callback) and (is_object($callback[0]) or class_exists($allback[0])) and method_exists($callback[0], $callback[1]))) {
				throw new IllgealArgumentException("\$callback must be a valid callable!");
			}
			
			$this->event->on(self::CALLBACK_EVENT, $callback);
		}

	}