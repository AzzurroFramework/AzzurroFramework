<?php
/*
	af module declaration

	This script will register the components of the af module into the framework.


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
	

	// --- DECLARATION ---
	$azzurro->module("af", ['auto'])

	// --- CONFIG ---
	->config(function ($azzurroProvider) {
		// Configuring the event to start the routing
		$azzurroProvider->setRouteEvent("RouterService::route");

		// Configuring the event to start the callbacks
		$azzurroProvider->setCallbackEvent("CallbackService::callback");
	})

	// --- RUN ---
	->run(function ($event) {
		// Register the callback to start the route
		$event->on("RouterService::route", function ($server, $router) {
			// Getting the path of the request
			$url = $server->get("PATH_INFO");
			// If the query string is not empty
			if (!empty($server->get("QUERY_STRING"))) {
				$url .= "?" . $server->get("QUERY_STRING");
			}
			// Removed "/index.php"
			if (strlen($url) >= 10 and substr_compare($url, "/index.php", 0, 10) === 0) {
				$url = substr($url, 10);
			}
			// Check if the url is empty
			if (empty($url)) {
				$url = "/";
			}

			// Route the request
			$router->route($url);
		});
	})

	// --- SERVICES ----
	
	// $log service
	->provider("log", "\AzzurroFramework\Core\Modules\AF\Log\LogServiceProvider")
	// $router service
	->provider("router", "\AzzurroFramework\Core\Modules\AF\Router\RouterServiceProvider")
	
	// Superglobal variable services
	// $cookie service
	->service("cookie", "\AzzurroFramework\Core\Modules\AF\Superglobal\Cookie\CookieService")
	// $env service
	->service("env", "\AzzurroFramework\Core\Modules\AF\Superglobal\Env\EnvService")
	// $files service
	->service("files", "\AzzurroFramework\Core\Modules\AF\Superglobal\Files\FilesService")
	// $get service
	->service("get", "\AzzurroFramework\Core\Modules\AF\Superglobal\Get\GetService")
	// $global service
	->service("global", "\AzzurroFramework\Core\Modules\AF\Superglobal\GlobalVar\GlobalVarService")
	// $post service
	->service("post", "\AzzurroFramework\Core\Modules\AF\Superglobal\Post\PostService")
	// $request service
	->service("request", "\AzzurroFramework\Core\Modules\AF\Superglobal\Request\RequestService")
	// $server service
	->service("server", "\AzzurroFramework\Core\Modules\AF\Superglobal\Server\ServerService")
	// $session service
	->service("session", "\AzzurroFramework\Core\Modules\AF\Superglobal\Session\SessionService")

	// $template service
	->service("template", "\AzzurroFramework\Core\Modules\AF\Template\TemplateService");


