<?php
/* Years Test cases generated on: 2021-03-10 13:26:25 : 1615353985*/
App::import('Controller', 'Years');

class TestYearsController extends YearsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class YearsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.year');

	function startTest() {
		$this->Years =& new TestYearsController();
		$this->Years->constructClasses();
	}

	function endTest() {
		unset($this->Years);
		ClassRegistry::flush();
	}

}
