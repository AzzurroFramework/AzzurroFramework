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

	// --- LOADING THE EXTERNAL MODULES ---
	// Scan the core modules directory
	foreach (scandir(__DIR__) as $module) {
		// Create the path to the current module autoloader file
		$autoloader = __DIR__ . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . "autoloader.php";
		// If the file exists
		if (file_exists($autoloader) and is_file($autoloader)) {
			// Require the autoloader file
			require_once($autoloader);
		}
	}