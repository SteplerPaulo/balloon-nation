<?php
class ApiController extends AppController {

	var $name = 'Api';
	var $helpers = array('Access');
	var $uses = array('Api','Product','Category','Delivery','Inquiry','Sale');

	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('data'));	
    } 
	
	/**API for ReactJs**/
	function data(){
		if(isset($_GET['model']) && !in_array($_GET['model'], $this->uses)){
			die('Bad Request: Check Correct Params');
		}
		
		if($this->RequestHandler->ext == 'json'){
			$this->layout = false;
			header("Access-Control-Allow-Origin: *");
			$model= isset($_GET['model'])?$_GET['model']:'Product';
			$fields = array();
			$conditions=array();
			$page = 1-1;
			$limit = 50;
			$offset =  $page*$limit;
			
			if(isset($_GET['fields'])){
				$fields = explode(',',$_GET['fields']);
			}
			if(isset($_GET['filter'])){
				$conditions['OR']= array();
				foreach($fields as $d){
					$conditions['OR'][$model.'.'.$d.' LIKE']='%'.$_GET['filter'].'%';
				}
			}
			
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
		}
		
	}
	
	
	/**DASHBOARD API**/
	function projected_revenue($year=2021){
		$year = $_GET['year'];
		$data = $this->Api->projected_revenue($year);
		pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
	}
	
	function customers_graph(){
		$data = $this->Api->customers_graph();
		pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
	}
	
	function most_sold_products(){
		$data = $this->Api->most_sold_products();
		pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
	}
	
	function most_profitable_products(){
		$data = $this->Api->most_profitable_products();
		pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
	}
	
	function most_sold_products_by_customer(){
		$data = $this->Api->most_sold_products_by_customer();
		pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
	}
	
	function most_profitable_products_by_customer(){
		$data = $this->Api->most_profitable_products_by_customer();
		pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
	}
	
	
}


