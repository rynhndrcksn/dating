<?php
/**
 *  * @author Ryan H.
 * @version https://github.com/rynhndrcksn/dating
 * Class Validation that holds a bunch of validation methods for the web app
 */
class Validation
{
	// fields
	private $_dataLayer;

	function __construct()
	{
		$this->_dataLayer = new DataLayer();
	}

	function validName($name): bool
	{
		return !empty($this->prep_input($name)) && ctype_alpha($this->prep_input($name));
	}

	function validAge($age): bool
	{
		return $age > 17 && $age < 119;
	}

	function validGender($gender): bool
	{
		return in_array($gender, $this->_dataLayer->getGens());
	}

	function validPhone($phone): bool
	{
		return preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $phone) || preg_match('/^[0-9]{10}+$/', $phone);
	}

	function validEmail($email): bool
	{
		return filter_var($email, FILTER_SANITIZE_EMAIL);
	}

	function validState($state): bool
	{
		return in_array($state, $this->_dataLayer->getStates());
	}

	function validOutdoor($outdoor): bool
	{
		$valid = false;
		foreach ($outdoor as $item) {
			if (in_array($item, $this->_dataLayer->getOutDoor())) {
				$valid = true;
			} else {
				$valid = false;
			}
		}
		return $valid;
	}

	function validIndoor($indoor): bool
	{
		$valid = false;
		foreach ($indoor as $item) {
			if (in_array($item, $this->_dataLayer->getInDoor())) {
				$valid = true;
			} else {
				$valid = false;
			}
		}
		return $valid;
	}

	/**
	 * takes a parameter, strips any white spaces, strips \\'s and //'s, and converts any HTML to it's ASCII code.
	 * is used on its own, but also acts as a helper method
	 * @param $data
	 * @return string
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