<?php
class YearsController extends AppController {

	var $name = 'Years';
	var $helpers = array('Access');
	
	function active(){
		$data = $this->Year->find('all',array('conditions'=>array('Year.active'=>1)));
		echo json_encode($data);
		exit;
	}	
	
	function all(){
		$data = $this->Year->find('all',array('order'=>'Year.name DESC'));
		echo json_encode($data);
		exit;
	}

}
