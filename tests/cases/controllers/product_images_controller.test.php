<?php
/* ProductImages Test cases generated on: 2016-07-22 15:29:54 : 1469194194*/
App::import('Controller', 'ProductImages');

class TestProductImagesController extends ProductImagesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProductImagesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.product_image', 'app.product', 'app.category', 'app.manufacturer');

	function startTest() {
		$this->ProductImages =& new TestProductImagesController();
		$this->ProductImages->constructClasses();
	}

	function endTest() {
		unset($this->ProductImages);
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
