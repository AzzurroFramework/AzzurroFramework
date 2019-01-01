<?php
/*
	User application main file

	This file is the main file of your application.
	Inside this file you can develop your application or call an autoloader.

	DO NOT DELETE THIS FILE otherwise your application will not be loaded.
*/

	// Application main module
	$azzurro
		->app("app", [])

		->run(function () {
			echo "APP RUNNED!";
		});