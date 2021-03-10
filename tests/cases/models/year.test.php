<?php
/* Year Test cases generated on: 2021-03-10 13:25:48 : 1615353948*/
App::import('Model', 'Year');

class YearTestCase extends CakeTestCase {
	var $fixtures = array('app.year');

	function startTest() {
		$this->Year =& ClassRegistry::init('Year');
	}

	function endTest() {
		unset($this->Year);
		ClassRegistry::flush();
	}

}
