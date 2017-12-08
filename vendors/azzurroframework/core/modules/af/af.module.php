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
		$azzurroProvider->setRouteEvent("RouterService::route");

		// Configuring the event to start the callbacks
		$azzurroProvider->setCallbackEvent("CallbackService::callback");
	})

	//--- RUN ---
	->run(function ($event, $router) {
		// Register the callback to start the event
		$event->on("RouterService::route", function ($server) use ($router) {
			$router->route(preg_replace('/\&/', "?", $server->get("QUERY_STRING"), 1));
		});
	})

	//--- SERVICES ----
	
	// $callback service
	->service("callback", "\AzzurroFramework\Core\Modules\AF\Callback\CallbackService")
	// $log service
	->provider("log", "\AzzurroFramework\Core\Modules\AF\Log\LogServiceProvider")

	// Processor services
	// $messageProcessor service
	->provider("messageProcessor", "\AzzurroFramework\Core\Modules\AF\Processor\Message\MessageProcessorServiceProvider")
	// $templateProcessor service
	->provider("templateProcessor", "\AzzurroFramework\Core\Modules\AF\Processor\Template\TemplateProcessorServiceProvider")


	// $router service
	->provider("router", "\AzzurroFramework\Core\Modules\AF\Router\RouterServiceProvider")

	
	// Supervariable access services
	// // $cookie service
	// ->service("cookie", "\AzzurroFramework\Core\Modules\AF\Superglobal\Cookie\CookieService")
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
	->service("server", "\AzzurroFramework\Core\Modules\AF\Superglobal\Server\ServerService");
	// // $session service
	// ->service("session", "\AzzurroFramework\Core\Modules\AF\Superglobal\Session\SessionService");


