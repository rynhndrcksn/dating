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
$controller = new Controller();

// create an instance of the base class (fat-free framework)
$f3 = Base::instance();

// define a default route (home page)
$f3->route('GET /', function() use ($controller) {
	$controller->home();
});

// start our signup routes (1/3)
$f3->route('GET|POST /sign-up-1', function() use ($controller) {
	$controller->signUp1();
});

// continue signup routes (2/3)
$f3->route('GET|POST /sign-up-2', function() use ($f3, $controller) {
	// set the gender radio buttons and states
	$f3->set('gens', $dataLayer->getGens());
	$f3->set('states', $dataLayer->getStates());

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userEmail = $_POST['email'];
		$userState = $_POST['state'];
		$userSeeking = $_POST['seeking'];
		$userBio = $validator->prep_input($_POST['biography']);

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
				$_SESSION['seeking'] = $userSeeking;
			} else {
				$f3->set('errors["seeking"]', 'Not a valid gender');
			}
		}

		// validate biography
		if (isset($userBio)) {
			// since we sanitized the input earlier with prep_input, we don't need to worry about it here
			$_SESSION['biography'] = $userBio;
		}

		// if there are no errors, redirect to sign-up-3
		if (empty($f3->get('errors'))) {
			$f3->reroute('/sign-up-3');
		}
	}

	$f3->set('userEmail', isset($userEmail) ? $userEmail : "");
	$f3->set('userState', isset($userState) ? $userState : "");
	$f3->set('userSeeking', isset($userSeeking) ? $userSeeking : "");
	$f3->set('userBio', isset($userBio) ? $userBio : "");

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-2.html');
});

// end of our signup routes (3/3)
$f3->route('GET|POST /sign-up-3', function($f3) use ($validator, $dataLayer) {
	// set indoor and outdoor interests
	$f3->set('indoors', $dataLayer->getIndoor());
	$f3->set('outdoors', $dataLayer->getOutdoor());

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$userIndoors = $_POST['indoorInterests'];
		$userOutdoors = $_POST['outdoorInterests'];

		// validate indoor activities
		if (isset($userIndoors)) {
			if ($validator->validIndoor($userIndoors)) {
				$_SESSION['indoorInterests'] = $userIndoors;
			} else {
				$f3->set('errors["indoor"]', 'Not a valid indoor activity...');
			}
		}

		// validate outdoor activities
		if (isset($userOutdoors)) {
			if ($validator->validOutdoor($userOutdoors)) {
				$_SESSION['outdoorInterests'] = $userOutdoors;
			} else {
				$f3->set('errors["outdoor"]', 'Not a valid outdoor activity...');
			}
		}

		// if there are no errors, redirect to sign-up-3
		if (empty($f3->get('errors'))) {
			$f3->reroute('/summary');
		}
	}

	$f3->set('userIndoors', isset($userIndoors) ? $userIndoors : []);
	$f3->set('userOutdoors', isset($userOutdoors) ? $userOutdoors : []);

	// create a new view, then sends it to the client
	$view = new Template();
	echo $view->render('views/sign-up-3.html');
});

// sign up summary route
$f3->route('GET|POST /summary', function() {
	$view = new Template();
	echo $view->render('views/summary.html');

	// clear our $_SESSION
	//session_destroy();
});

// run fat free HAS TO BE THE LAST THING IN FILE
$f3->run();
