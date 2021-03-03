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
			if ($this->_validator->validName($userFirst)) {
				$_SESSION['fname'] = $userFirst;
			} else {
				$this->_f3->set('errors["fname"]', 'Not a valid first name');
			}

			// validate last name
			if ($this->_validator->validName($userLast)) {
				$_SESSION['lname'] = $userLast;
			} else {
				$this->_f3->set('errors["lname"]', 'Not a valid last name');
			}

			// validate age
			if ($this->_validator->validAge($userAge)) {
				$_SESSION['age'] = $userAge;
			} else {
				$this->_f3->set('errors["age"]', 'Not a valid age');
			}

			// validate gender
			if (isset($userGen)) {
				if ($this->_validator->validGender($userGen)) {
					$_SESSION['gender'] = $userGen;
				} else {
					$this->_f3->set('errors["gender"]', 'Not a valid gender');
				}
			}

			// validate phone
			if ($this->_validator->validPhone($userPhone)) {
				$_SESSION['phone'] = $userPhone;
			} else {
				$this->_f3->set('errors["phone"]', 'Not a valid phone number');
			}

			// check whether or not we have a premium member
			if(isset($_POST["premium"])) {
				$member = new PremiumMember($userFirst, $userLast, $userAge, $userGen, $userPhone);
				$_SESSION['member'] = $member;
			} else {
				$member = new Member($userFirst, $userLast, $userAge, $userGen, $userPhone);
				$_SESSION['member'] = $member;
			}

			// if there are no errors, redirect to sign-up-2
			if (empty($this->_f3->get('errors'))) {
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


}