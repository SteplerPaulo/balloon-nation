<?php
/* ProductTransaction Test cases generated on: 2017-01-22 19:17:28 : 1485083848*/
App::import('Model', 'ProductTransaction');

class ProductTransactionTestCase extends CakeTestCase {
	var $fixtures = array('app.product_transaction');

	function startTest() {
		$this->ProductTransaction =& ClassRegistry::init('ProductTransaction');
	}

	function endTest() {
		unset($this->ProductTransaction);
		ClassRegistry::flush();
	}

}
