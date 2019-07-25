<?php

/**
* init.php
*
* This is a simple initiation file loaded by most of the public-facing page files  in order
* to reduce repetition across the application.
*/


/**
 * Initialize Autoload Functionality
 */

// Require Composer's autoloader
require dirname(__FILE__) . "/vendor/autoload.php";

/**
 * Create Database Connection
 */

$database = new \DatabaseExample\Database();
