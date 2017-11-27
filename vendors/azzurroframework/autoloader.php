<?php
/*
	Azzurro Framework loader

	- load core files
	- load af module files

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

	//--- LOADING FRAMEWORK FILES ---

	//--- EXCEPTIONS ---
	require_once(__DIR__ . "/core/exceptions/app/AppModuleNotRegisteredException.exception.php");

	require_once(__DIR__ . "/core/exceptions/constant/ConstantAlreadyRegisteredException.exception.php");
	require_once(__DIR__ . "/core/exceptions/constant/ConstantNotFoundException.exception.php");

	require_once(__DIR__ . "/core/exceptions/controller/ControllerAlreadyRegisteredException.exception.php");
	require_once(__DIR__ . "/core/exceptions/controller/ControllerNotFoundException.exception.php");

	require_once(__DIR__ . "/core/exceptions/filter/FilterAlreadyRegisteredException.exception.php");
	require_once(__DIR__ . "/core/exceptions/filter/FilterNotFoundException.exception.php");

	require_once(__DIR__ . "/core/exceptions/module/ModuleAlreadyRegisteredException.exception.php");
	require_once(__DIR__ . "/core/exceptions/module/ModuleConfigAlreadyRegisteredException.exception.php");
	require_once(__DIR__ . "/core/exceptions/module/ModuleNotFoundException.exception.php");
	require_once(__DIR__ . "/core/exceptions/module/ModuleRunAlreadyRegisteredException.exception.php");

	require_once(__DIR__ . "/core/exceptions/service/ServiceAlreadyRegisteredException.exception.php");
	require_once(__DIR__ . "/core/exceptions/service/ServiceNotFoundException.exception.php");
	require_once(__DIR__ . "/core/exceptions/service/ServiceProviderNotFoundException.exception.php");
	require_once(__DIR__ . "/core/exceptions/service/ServiceProviderResultException.exception.php");

	require_once(__DIR__ . "/core/exceptions/ComponentNotFoundException.exception.php");
	require_once(__DIR__ . "/core/exceptions/FactoryFunctionResultException.exception.php");
	require_once(__DIR__ . "/core/exceptions/NotACallableException.exception.php");


	//--- INTERFACES ---
	require_once(__DIR__ . "/core/interfaces/service/ServiceProviderInterface.interface.php");
	require_once(__DIR__ . "/core/interfaces/router/RouterInterface.interface.php");
	require_once(__DIR__ . "/core/interfaces/processor/ProcessorInterface.interface.php");


	//--- af MODULE ---
	require_once(__DIR__ . "/core/af/injector/InjectorService.service.php");
	

	//--- CLASSES ---
	require_once(__DIR__ . "/core/scope/Scope.class.php");
	require_once(__DIR__ . "/core/module/Module.class.php");
	require_once(__DIR__ . "/core/injector/Injector.class.php");
	require_once(__DIR__ . "/core/AzzurroFramework.class.php");