<?php
/*
 * @author: Ryan H.
 * @version: https://github.com/rynhndrcksn/dating/blob/main/index.php
 * index.php is the controller for our F3 MVC
 */

// turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// create a session
session_start();

// require autoload file
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// define a default route (home page)
$f3->route('GET /', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/home.html');
});

// start our signup routes (1/3)
$f3->route('GET|POST /sign-up-1', function($f3) {
	// set the gender radio buttons
	$f3->set('gens', getGens());

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-1.html');
});

// continue signup routes (2/3)
$f3->route('POST /sign-up-2', function($f3) {
	// set the gender radio buttons and states
	$f3->set('gens', getGens());
	$f3->set('states', getStates());

	// gather user supplied information
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['fname'])) {
			$_SESSION['fname'] = $_POST['fname'];
		}
		if (isset($_POST['lname'])) {
			$_SESSION['lname'] = $_POST['lname'];
		}
		if (isset($_POST['age'])) {
			$_SESSION['age'] = $_POST['age'];
		}
		if (isset($_POST['gender'])) {
			$_SESSION['gender'] = $_POST['gender'];
		}
		if (isset($_POST['phone'])) {
			$_SESSION['phone'] = $_POST['phone'];
		}
	}
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-2.html');
});

// end of our signup routes (3/3)
$f3->route('POST /sign-up-3', function($f3) {
	// set indoor and outdoor interests
	$f3->set('indoors', getInDoor());
	$f3->set('outdoors', getOutDoor());

	// gather user supplied information
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['email'])) {
			$_SESSION['email'] = $_POST['email'];
		}
		if (isset($_POST['state'])) {
			$_SESSION['state'] = $_POST['state'];
		}
		if (isset($_POST['seeking'])) {
			$_SESSION['seeking'] = $_POST['seeking'];
		}
		if (isset($_POST['biography'])) {
			$_SESSION['biography'] = $_POST['biography'];
		}
	}

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-3.html');
});

// sign up summary route
$f3->route('POST /summary', function() {
	// gather user supplied information
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['indoorInterests'])) {
			$_SESSION['indoorInterests'] = $_POST['indoorInterests'];
		}
		if (isset($_POST['outdoorInterests'])) {
			$_SESSION['outdoorInterests'] = $_POST['outdoorInterests'];
		}
	}

	$view = new Template();
	echo $view->render('views/summary.html');
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
