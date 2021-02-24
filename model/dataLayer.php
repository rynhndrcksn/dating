<?php
/**
 * @author Ryan H.
 * @version https://github.com/rynhndrcksn/dating
 * Class: DataLayer - provides data to our web app, either by directly returning data, or returning data received
 * from a database.
 */
class DataLayer
{
	/**
	 * simple function that returns our genders for the user to select their gender
	 * @return string[] - array of genders
	 */
	function getGens(): array {
		return array('male', 'female', 'non-binary');
	}

	/**
	 * function that returns all the states supported by our dating service
	 * @return string[] - array of states
	 */
	function getStates(): array {
		$array = array('washington', 'oregon');
		sort($array);
		return $array;
	}

	/**
	 * function that returns an array of indoor activities for the user to select
	 * @return string[] - array of indoor interests
	 */
	function getIndoor(): array {
		$array = array('television', 'movies', 'cooking', 'coding', 'puzzles', 'reading', 'cards', 'gaming');
		sort($array);
		return $array;
	}

	/**
	 * function that returns an array of outdoor activities for the user to select
	 * @return string[] - array of outdoor interests
	 */
	function getOutdoor(): array {
		$array = array('hiking', 'biking', 'swimming', 'collecting', 'walking', 'climbing', 'running', 'yoga');
		sort($array);
		return $array;
	}
}
