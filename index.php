<?php
/*
	Index file

	- define basic constants
	- require the vendros/azzurroframework/bootstrap.php file
	

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

	//--- PATH CONSTANTS ---
	// Server root
	define("__AF_ROOT__", __DIR__);
	// Vendors directory
	define("__AF_VENDOR_DIR__", __AF_ROOT__ . "/vendors");
	// Azzurro Framework core directory
	define("__AF_DIR__", __AF_VENDOR_DIR__ . "/azzurroframework");
	// Logs directory
	define("__AF_LOGS_DIR__", __AF_ROOT__ . "/logs");
	// User application directory
	define("__AF_APP_DIR__", __AF_ROOT__ . "/app");

	
	//--- STARTUP AZZURRO FRAMEWORK ---
	require_once(__AF_DIR__ . "/bootstrap.php");

	//--- SHUTDOWN AZZURRTO FRAMEWORK ---
	require_once(__AF_DIR__ . "/shutdown.php");
