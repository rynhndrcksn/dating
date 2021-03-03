<?php

/**
 * controller is our controller for the dating web app. This file contains methods that are called in our index.php
 * PHP version: 7.3
 * @author Ryan Hendrickson
 * @version https://github.com/rynhndrcksn/dating
 */
class Controller
{
	// fields
	private $_f3;
	private $_validator;
	private $_dataLayer;

	public function __construct($f3)
	{
		$this->_f3 = $f3;
		$this->_validator = new Validation();
		$this->_dataLayer = new DataLayer();
	}

	/**
	 * displays the home.html page
	 */
	function home()
	{
		// create a new view and send the user to home.html
		$view = new Template();
		echo $view->render('views/home.html');
	}

	/**
	 * displays the first sign up page, handles validating, then information is saved to Member object
	 */
	function signUp1()
	{
		// set the gender radio buttons
		$this->_f3->set('gens', $this->_dataLayer->getGens());

		// gather user supplied information
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$userFirst = $_POST['fname'];
			$userLast = $_POST['lname'];
			$userAge = $_POST['age'];
			$userGen = $_POST['gender'];
			$userPhone = $_POST['phone'];

			// validate first name
			if (!$this->_validator->validName($userFirst)) {
				$this->_f3->set('errors["fname"]', 'Not a valid first name');
			}

			// validate last name
			if (!$this->_validator->validName($userLast)) {
				$this->_f3->set('errors["lname"]', 'Not a valid last name');
			}

			// validate age
			if (!$this->_validator->validAge($userAge)) {
				$this->_f3->set('errors["age"]', 'Not a valid age');
			}

			// validate gender
			if (isset($userGen)) {
				if (!$this->_validator->validGender($userGen)) {
					$this->_f3->set('errors["gender"]', 'Not a valid gender');
				}
			}

			// validate phone
			if (!$this->_validator->validPhone($userPhone)) {
				$this->_f3->set('errors["phone"]', 'Not a valid phone number');
			}

			// if there are no errors, create + store our member object then redirect to sign-up-2
			if (empty($this->_f3->get('errors'))) {

				// check whether or not we have a premium member
				if(isset($_POST["premium"])) {
					$_SESSION['member'] = new PremiumMember($userFirst, $userLast, $userAge, $userGen, $userPhone);
				} else {
					$_SESSION['member'] = new Member($userFirst, $userLast, $userAge, $userGen, $userPhone);
				}

				$this->_f3->reroute('/sign-up-2');
			}
		}

		$this->_f3->set('userFirst', isset($userFirst) ? $userFirst : "");
		$this->_f3->set('userLast', isset($userLast) ? $userLast : "");
		$this->_f3->set('userAge', isset($userAge) ? $userAge : "");
		$this->_f3->set('userGen', isset($userGen) ? $userGen : "");
		$this->_f3->set('userPhone', isset($userPhone) ? $userPhone : "");

		// create a new view, then sends it to the client
		$view = new Template();
		echo $view->render('views/sign-up-1.html');
	}

	/**
	 * displays the 2nd sign up page, validates user inputs, and reroutes to either the interest (if premium member) or
	 * summary if not
	 */
	function signUp2()
	{
		// set the gender radio buttons and states
		$this->_f3->set('gens', $this->_dataLayer->getGens());
		$this->_f3->set('states', $this->_dataLayer->getStates());

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$userEmail = $_POST['email'];
			$userState = $_POST['state'];
			$userSeeking = $_POST['seeking'];
			$userBio = $this->_validator->prep_input($_POST['biography']);

			// validate email
			if (!$this->_validator->validEmail($userEmail)) {
				$this->_f3->set('errors["email"]', 'Not a valid email');
			}

			// validate state
			if ($this->_validator->validState($userState)) {
				$this->_f3->set('errors["state"]', 'Not a valid state...');
			}

			// validate seeking
			if (isset($userSeeking)) {
				if ($this->_validator->validGender($userSeeking)) {
					$this->_f3->set('errors["seeking"]', 'Not a valid gender');
				}
			}

			// if there are no errors, assign the user's email, state, seeking, and bio then redirect to sign-up-3 OR summary
			if (empty($this->_f3->get('errors'))) {
				// use the setters on
				$_SESSION['member']->setEmail($userEmail);
				$_SESSION['member']->setState($userState);
				$_SESSION['member']->setSeeking($userSeeking);
				$_SESSION['member']->setBio($userBio);

				if ($_SESSION['member'] instanceof PremiumMember) {
					$this->_f3->reroute('/sign-up-3');
				} else {
					$this->_f3->reroute('/summary');
				}
			}
		}

		$this->_f3->set('userEmail', isset($userEmail) ? $userEmail : "");
		$this->_f3->set('userState', isset($userState) ? $userState : "");
		$this->_f3->set('userSeeking', isset($userSeeking) ? $userSeeking : "");
		$this->_f3->set('userBio', isset($userBio) ? $userBio : "");

		// create a new view, then sends it to the client
		$view = new Template();
		echo $view->render('views/sign-up-2.html');
	}

	/**
	 * displays the 3rd sign up page, validates it, then user is rerouted to summary
	 */
	function signUp3()
	{
		// set indoor and outdoor interests
		$this->_f3->set('indoors', $this->_dataLayer->getIndoor());
		$this->_f3->set('outdoors', $this->_dataLayer->getOutdoor());

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$userIndoors = $_POST['indoorInterests'];
			$userOutdoors = $_POST['outdoorInterests'];

			// validate indoor activities
			if (isset($userIndoors)) {
				if (!$this->_validator->validIndoor($userIndoors)) {
					$this->_f3->set('errors["indoor"]', 'Not a valid indoor activity...');
				}
			}

			// validate outdoor activities
			if (isset($userOutdoors)) {
				if ($this->_validator->validOutdoor($userOutdoors)) {
					$this->_f3->set('errors["outdoor"]', 'Not a valid outdoor activity...');
				}
			}

			// if there are no errors, assign the interests to our object then redirect to summary
			if (empty($this->_f3->get('errors'))) {
				$_SESSION['member']->setIndoorInterests($userIndoors);
				$_SESSION['member']->setOutdoorInterests($userOutdoors);
				
				$this->_f3->reroute('/summary');
			}
		}

		$this->_f3->set('userIndoors', isset($userIndoors) ? $userIndoors : []);
		$this->_f3->set('userOutdoors', isset($userOutdoors) ? $userOutdoors : []);

		// create a new view, then sends it to the client
		$view = new Template();
		echo $view->render('views/sign-up-3.html');
	}

	function summary()
	{
		$view = new Template();
		echo $view->render('views/summary.html');

		// clear our $_SESSION
		session_destroy();
	}
}