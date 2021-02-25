<?php
/**
 * @author Ryan H.
 * @version https://github.com/rynhndrcksn/dating
 * Class: Validation - holds validation methods for the web app
 */
class Validation
{
	// fields
	private $_dataLayer;

	/**
	 * Validation constructor - makes a new DataLayer() for us to use to help assist with validation
	 */
	function __construct()
	{
		$this->_dataLayer = new DataLayer();
	}

	/**
	 * validName takes a name and returns if it's a valid name
	 * @param $name - string
	 * @return bool - true if the name isn't empty and is alphanumeric
	 */
	function validName($name): bool
	{
		return !empty($this->prep_input($name)) && ctype_alpha($this->prep_input($name));
	}

	/**
	 * validAge takes an age and returns if it's a valid age
	 * @param $age - int
	 * @return bool - true if the age is between 18 and 118
	 */
	function validAge($age): bool
	{
		return $age > 17 && $age < 119;
	}

	/**
	 * validGender takes a string and returns if it's a valid gender
	 * @param $gender - string
	 * @return bool - true if the gender provided is not spoofed
	 */
	function validGender($gender): bool
	{
		return in_array($gender, $this->_dataLayer->getGens());
	}

	/**
	 * validPhone takes a string and returns if it's a valid phone number
	 * @param $phone - string
	 * @return bool - true if the phone number is in either format: 123-456-7890 or 1234567890
	 */
	function validPhone($phone): bool
	{
		return preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $phone) || preg_match('/^[0-9]{10}+$/', $phone);
	}

	/**
	 * validEmail takes a string and returns if it's a valid email
	 * @param $email - string
	 * @return bool - true if the email is a proper email
	 */
	function validEmail($email): bool
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	/**
	 * validStates takes a string and returns it it's a valid state
	 * @param $state - string
	 * @return bool - true if the state provided is not spoofed
	 */
	function validState($state): bool
	{
		return in_array($state, $this->_dataLayer->getStates());
	}

	/**
	 * validIndoor takes an array and returns if it contains valid choices
	 * @param $indoor - array
	 * @return bool - true if every element in the array is valid and not spoofed
	 */
	function validIndoor($indoor): bool
	{
		$valid = false;
		foreach ($indoor as $item) {
			if (in_array($item, $this->_dataLayer->getIndoor())) {
				$valid = true;
			} else {
				$valid = false;
			}
		}
		return $valid;
	}

	/**
	 * validOutdoor takes an array and returns if it contains valid choices
	 * @param $outdoor - array
	 * @return bool - true if every element in the array is valid and not spoofed
	 */
	function validOutdoor($outdoor): bool
	{
		$valid = false;
		foreach ($outdoor as $item) {
			if (in_array($item, $this->_dataLayer->getOutdoor())) {
				$valid = true;
			} else {
				$valid = false;
			}
		}
		return $valid;
	}

	/**
	 * takes a string, strips any white spaces, strips \\'s and //'s, and converts any HTML to it's ASCII code.
	 * is used on its own, but also acts as a helper method
	 * @param $data - string
	 * @return string - sanitized string
	 */
	function prep_input($data): string
	{
		$data = strtolower($data);
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}