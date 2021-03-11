<?php
class ApiController extends AppController {

	var $name = 'Api';
	var $helpers = array('Access');
	var $uses = array('Product','Category','Delivery','Inquiry','Sale');

	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('data'));	
    } 
	
	
	/**API for ReactJs**/
	function data(){
		
		if($this->RequestHandler->ext == 'json' && isset($_GET['model'])?in_array($_GET['model'], $this->uses):''){
			$this->layout = false;
			header("Access-Control-Allow-Origin: *");
			$model= isset($_GET['model'])?$_GET['model']:'Product';
			$fields = array();
			$conditions=array();

			
			if(isset($_GET['fields'])){
				$fields = explode(',',$_GET['fields']);
			}
			if(isset($_GET['filter'])){
				$conditions['OR']= array();
				foreach($fields as $d){
					$conditions['OR'][$model.'.'.$d.' LIKE']='%'.$_GET['filter'].'%';
				}
			}
			
			
			$page = 1-1;
			$limit = 50;
			$offset =  $page*$limit;
			$this->Product->unbindModel(array('hasMany' => array('ProductImage','DeliveryDetail')));
			$this->Product->unbindModel(array('belongsTo' => array('Customer','Category')));
			
			
			$data = $this->$model->find('all', array(
				'conditions'=>$conditions,
				'order'=>'name ASC',
				'fields' => $fields,
				'offset' => $offset,
				'limit' => $limit
			));
		
			$this->set(compact('data'));
		}else{
			die('Bad Request: Check Correct Params');
		}
		
	}
	
}


