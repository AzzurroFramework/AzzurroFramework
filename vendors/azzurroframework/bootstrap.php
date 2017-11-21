<?php
/*
	Boostrap

	- load the framework
	- load the plugins
	- load user application
	- run the framework


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
	

	//--- LOAD THE FRAMEWORK ---
	// Requiring the autolaoder files of the framework
	require_once(__AF_DIR__ . "/core/autoloader.php");

	//--- LOAD THE PLUGINS ---

	//--- LOAD THE USER APPLICATION ---
	require_once(__AF_APP_DIR__ . "/autoloader.php");

	//--- RUN THE FRAMEWORK ---
	// Run the framework (it will process the request)
	$af->run();
