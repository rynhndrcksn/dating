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
$validator = new Validation();
$dataLayer = new DataLayer();

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// define a default route (home page)
$f3->route('GET /', function() {
	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/home.html');
});

// start our signup routes (1/3)
$f3->route('GET|POST /sign-up-1', function($f3) use ($validator, $dataLayer) {
	// set the gender radio buttons
	$f3->set('gens', $dataLayer->getGens());

	// gather user supplied information
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userFirst = $_POST['fname'];
		$userLast = $_POST['lname'];
		$userAge = $_POST['age'];
		$userGen = $_POST['gender'];
		$userPhone = $_POST['phone'];

		// validate first name
		if ($validator->validName($userFirst)) {
			$_SESSION['fname'] = $userFirst;
		} else {
			$f3->set('errors["fname"]', 'Not a valid first name');
		}

		// validate last name
		if ($validator->validName($userLast)) {
			$_SESSION['lname'] = $userLast;
		} else {
			$f3->set('errors["lname"]', 'Not a valid last name');
		}

		// validate age
		if ($validator->validAge($userAge)) {
			$_SESSION['age'] = $userAge;
		} else {
			$f3->set('errors["age"]', 'Not a valid age');
		}

		// validate gender
		if (isset($userGen)) {
			if ($validator->validGender($userGen)) {
				$_SESSION['gender'] = $userGen;
			} else {
				$f3->set('errors["gender"]', 'Not a valid gender');
			}
		}

		// validate phone
		if ($validator->validPhone($userPhone)) {
			$_SESSION['phone'] = $userPhone;
		} else {
			$f3->set('errors["phone"]', 'Not a valid phone number');
		}

		// if there are no errors, redirect to sign-up-2
		if (empty($f3->get('errors'))) {
			$f3->reroute('/sign-up-2');
		}
	}

	$f3->set('userFirst', isset($userFirst) ? $userFirst : "");
	$f3->set('userLast', isset($userLast) ? $userLast : "");
	$f3->set('userAge', isset($userAge) ? $userAge : "");
	$f3->set('userGen', isset($userGen) ? $userGen : "");
	$f3->set('userPhone', isset($userPhone) ? $userPhone : "");

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-1.html');
});

// continue signup routes (2/3)
$f3->route('GET|POST /sign-up-2', function($f3) use ($validator, $dataLayer) {
	// set the gender radio buttons and states
	$f3->set('gens', $dataLayer->getGens());
	$f3->set('states', $dataLayer->getStates());

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userEmail = $_POST['email'];
		$userState = $_POST['state'];
		$userSeeking = $_POST['seeking'];
		$userBio = $_POST['biography'];

		// validate email
		if ($validator->validEmail($userEmail)) {
			$_SESSION['email'] = $userEmail;
		} else {
			$f3->set('errors["email"]', 'Not a valid email');
		}

		// validate state
		if ($validator->validState($userState)) {
			$_SESSION['state'] = $userState;
		} else {
			$f3->set('errors["state"]', 'Not a valid state...');
		}

		// validate seeking
		if (isset($userSeeking)) {
			if ($validator->validGender($userSeeking)) {
				$_SESSION['gender'] = $userSeeking;
			} else {
				$f3->set('errors["gender"]', 'Not a valid gender');
			}
		}

		// validate biography
		if (isset($_POST['biography'])) {
			$_SESSION['biography'] = $_POST['biography'];
		}

		// if there are no errors, redirect to sign-up-3
		if (empty($f3->get('errors'))) {
			$f3->reroute('/sign-up-3');
		}
	}

	$f3->set('userEmail', isset($userEmail) ? $userEmail : "");
	$f3->set('userState', isset($userState) ? $userState : "");
	$f3->set('userSeeking', isset($userSeeking) ? $userSeeking : "");
	$f3->set('userbio', isset($userBio) ? $userBio : "");

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-2.html');
});

// end of our signup routes (3/3)
$f3->route('GET|POST /sign-up-3', function($f3) use ($validator, $dataLayer) {
	// set indoor and outdoor interests
	$f3->set('indoors', $dataLayer->getInDoor());
	$f3->set('outdoors', $dataLayer->getOutDoor());

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-3.html');
});

// sign up summary route
$f3->route('GET|POST /summary', function() {
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

	// clear our $_SESSION
	session_destroy();
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
