<?php
/*
 * @author: Ryan H.
 * @version: https://github.com/rynhndrcksn/dating/blob/main/index.php
 * index.php is the controller for our F3 MVC
 */

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// require autoload file
require_once ('vendor/autoload.php');

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// define a default route (home page)
$f3->route('GET /', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/home.html');
});

// start our signup routes (1/3)
$f3->route('GET /sign-up-1', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-1.html');
});

// continue signup routes (2/3)
$f3->route('POST /sign-up-2', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-2.html');
});

// end of our signup routes (3/3)
$f3->route('POST /sign-up-3', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-3.html');
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
