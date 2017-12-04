<?php
/*
	af module declaration and registration of all the components

	- declaration of 'af' module
	- registration components of the module


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

	use \AzzurroFramework\Core\AzzurroFramework;


	//--- GETTING INSTACE OF THE MAIN CLASS OF THE FRAMEWORK ---
	$azzurro = AzzurroFramework::getInstance();

	//--- DECLARATION ---
	$azzurro->module("af", ['auto'])

	//--- CONFIG ---
	->config(function ($azzurroProvider) {
		// Configuring the event to start the routing
		$azzurroProvider->setRouteEvent("AF:route");

		// Configuring the event to start the callbacks
		$azzurroProvider->setCallbackEvent("AF:callback");
	})

	//--- RUN ---
	->run(function ($event, $router) {
		// Register the callback to start the event
		$event->on("AF:route", function () use ($router) {
			$router->route();
		});
	})

	//--- SERVICES ----
	
	// $callback service
	->service("callback", "\AzzurroFramework\Core\Modules\AF\Callback\CallbackService")

	// $log service
	->provider("log", "\AzzurroFramework\Core\Modules\AF\Log\LogServiceProvider")

	// $router service
	->provider("router", "\AzzurroFramework\Core\Modules\AF\Router\RouterServiceProvider");


