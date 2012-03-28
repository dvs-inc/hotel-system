<?php
// This is the main code entry point.
// There should be very little code in this file, as it should just provide an entry point to the rest of the code.

// define something so we know we've entered the code in the right place.
define("HMS",1);

// include the configuration file, which should set up the entire environment as we need it.
require_once('config.php');

// create and run a new instance of the Hotel application in management mode.
$application = new Hotel();
$application->setManagementMode();
$application->run();