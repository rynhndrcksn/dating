<?php

/**
 * PremiumMember class takes ALL of the user's information that's submitted and stores it as an object
 * PHP version: 7.3
 * @author Ryan Hendrickson
 * @version https://github.com/rynhndrcksn/dating
 */
class PremiumMember extends Member
{
	private $_indoorInterests;
	private $_outdoorInterests;

	/**
	 * @return array - user's indoor interests
	 */
	public function getIndoorInterests(): array
	{
		return $this->_indoorInterests;
	}

	/**
	 * @param array $indoorInterests - user's indoor interests
	 */
	public function setIndoorInterests(array $indoorInterests)
	{
		$this->_indoorInterests = $indoorInterests;
	}

	/**
	 * @return array - user's outdoor interests
	 */
	public function getOutdoorInterests(): array
	{
		return $this->_outdoorInterests;
	}

	/**
	 * @param array $outdoorInterests - user's outdoor interests
	 */
	public function setOutdoorInterests(array $outdoorInterests)
	{
		$this->_outdoorInterests = $outdoorInterests;
	}


}