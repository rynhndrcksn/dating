<?php
/*
 * @author: Ryan H.
 * @version: https://github.com/rynhndrcksn/dating/blob/main/index.php
 * index.php is the controller for our F3 MVC
 */

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();
$f3->set('DEBUG', 3);

// require autoload file
require_once ('vendor/autoload.php');
$controller = new Controller($f3);

// create a session
session_start();

// define a default route (home page)
$f3->route('GET /', function() use ($controller) {
	$controller->home();
});

// start our signup routes (1/3)
$f3->route('GET|POST /sign-up-1', function() use ($controller) {
	$controller->signUp1();
});

// continue signup routes (2/3)
$f3->route('GET|POST /sign-up-2', function() use ($controller) {
	$controller->signUp2();
});

// end of our signup routes (3/3)
$f3->route('GET|POST /sign-up-3', function() use ($controller) {
	$controller->signUp3();
});

// sign up summary route
$f3->route('GET|POST /summary', function() use ($controller) {
	$controller->summary();
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
