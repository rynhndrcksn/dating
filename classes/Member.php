<?php

/**
 * Member class takes the user info that's submitted, and turn it into an object for easier storage/retrieval.
 * Standard users don't get access to the interests sections
 * PHP version: 7.3
 * @author Ryan Hendrickson
 * @version https://github.com/rynhndrcksn/dating
 */
class Member
{
	// fields
	private $_fname;
	private $_lname;
	private $_age;
	private $_gender;
	private $_phone;
	private $_email;
	private $_state;
	private $_seeking;
	private $_bio;

	/**
	 * Member constructor that creates a Member object
	 * @param string $fname - user's first name
	 * @param string $lname - user's last name
	 * @param int $age - user's age
	 * @param string $gender - user's gender
	 * @param string $phone - user's phone number
	 */
	public function __construct(string $fname, string $lname, int $age, string $gender, string $phone)
	{
		$this->_fname = $fname;
		$this->_lname = $lname;
		$this->_age = $age;
		$this->_gender = $gender;
		$this->_phone = $phone;
	}

	/**
	 * @return string - user's first name
	 */
	public function getFname(): string
	{
		return $this->_fname;
	}

	/**
	 * @param string $fname - user's first name
	 */
	public function setFname(string $fname)
	{
		$this->_fname = $fname;
	}

	/**
	 * @return string - user's last name
	 */
	public function getLname(): string
	{
		return $this->_lname;
	}

	/**
	 * @param string $lname - user's last name
	 */
	public function setLname(string $lname)
	{
		$this->_lname = $lname;
	}

	/**
	 * @return int - user's age
	 */
	public function getAge(): int
	{
		return $this->_age;
	}

	/**
	 * @param int $age - user's age
	 */
	public function setAge(int $age)
	{
		$this->_age = $age;
	}

	/**
	 * @return string - user's gender
	 */
	public function getGender(): string
	{
		return $this->_gender;
	}

	/**
	 * @param string $gender - user's gender
	 */
	public function setGender(string $gender)
	{
		$this->_gender = $gender;
	}

	/**
	 * @return string - user's phone number
	 */
	public function getPhone(): string
	{
		return $this->_phone;
	}

	/**
	 * @param string $phone - user's phone number
	 */
	public function setPhone(string $phone)
	{
		$this->_phone = $phone;
	}

	/**
	 * @return string - user's email
	 */
	public function getEmail(): string
	{
		return $this->_email;
	}

	/**
	 * @param string $email - user's email
	 */
	public function setEmail(string $email)
	{
		$this->_email = $email;
	}

	/**
	 * @return string - user's state
	 */
	public function getState(): string
	{
		return $this->_state;
	}

	/**
	 * @param string $state - user's state
	 */
	public function setState(string $state)
	{
		$this->_state = $state;
	}

	/**
	 * @return string - user's seeking
	 */
	public function getSeeking(): string
	{
		return $this->_seeking;
	}

	/**
	 * @param string $seeking - user's seeking
	 */
	public function setSeeking(string $seeking)
	{
		$this->_seeking = $seeking;
	}

	/**
	 * @return string - user's biography
	 */
	public function getBio(): string
	{
		return $this->_bio;
	}

	/**
	 * @param string $bio - user's biography
	 */
	public function setBio(string $bio)
	{
		$this->_bio = $bio;
	}



}