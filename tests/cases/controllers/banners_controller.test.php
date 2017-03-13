<?php
/* Banners Test cases generated on: 2016-08-05 12:13:31 : 1470392011*/
App::import('Controller', 'Banners');

class TestBannersController extends BannersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BannersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.banner');

	function startTest() {
		$this->Banners =& new TestBannersController();
		$this->Banners->constructClasses();
	}

	function endTest() {
		unset($this->Banners);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
