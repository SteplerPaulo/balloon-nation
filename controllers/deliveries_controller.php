<?php
class DeliveriesController extends AppController {

	var $name = 'Deliveries';
	var $helpers = array('Access');
	var $uses = array('Delivery','Customer','Product','DeliveryDetail','Year');

	function admin_index() {
		$this->layout = 'admin_default';
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid delivery', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('delivery', $this->Delivery->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin_default';
		//pr($this->data);exit;
		if (!empty($this->data)) {
			
			$this->Delivery->create();
			if ($this->Delivery->saveAll($this->data['Main'])) {
				$response['status'] = 1;
				$response['msg'] = 'Saving successful.';
				$response['data'] = $this->data;
				echo json_encode($response);
				exit();
			} else {
				$response['status'] = 0;
				$response['msg'] = 'Error saving.Pls try again';
				$response['data'] = $this->data;
				echo json_encode($response);
				exit();
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid delivery', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Delivery->save($this->data)) {
				$this->Session->setFlash(__('The delivery has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The delivery could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Delivery->read(null, $id);
		}
		$customers = $this->Delivery->Customer->find('list');
		$this->set(compact('customers'));
	}

	function all(){
		$data = array();
		$this->Delivery->unbindModel( array('hasMany' => array('DeliveryDetail')));
		$data = $this->Delivery->find('all',array('conditions'=>array('Delivery.date LIKE'=>'%2021%'),'order'=>'date DESC'));
		echo json_encode($data);
		exit;
	}

	function admin_create(){
		$this->layout ="admin_default";	
	}
	
	function customer_product($customer = null){
		
		$data =  array();
		$this->Product->unbindModel(array(
			'hasMany' => array('ProductImage','DeliveryDetail'),
			'belongsTo' => array('Category'),
			
		));
		$products = $this->Product->find('all', array(
			'conditions' => array(
					'Customer.name' => $customer
				),
				'contain' => array(
					'Category',
					'Customer',
				),
				'order'=>'Product.name ASC'
		));
		
		foreach ($products as $key => $value) {
			//$products[$key]['counted'] = 0;
			//$products[$key]['bad_item'] = 0;
			//$products[$key]['deliver'] = 0;
			$products[$key]['is_disabled'] = true;
			$products[$key]['checkbox'] = false;
		}
		
		$data['Products'] = $products;
		$this->Customer->unbindModel( array('hasMany' => array('Product')));
		$customer = $this->Customer->find('first',array('conditions'=>array('Customer.name'=>$customer)));
		$data['Customer'] = $customer['Customer'];
		
		echo json_encode($data);
		exit;
	}
	
	function admin_report($id = null, $new=false){
		$this->Customer->unbindModel(array('hasMany' => array('Product')));
		$data = $this->Delivery->find('first',array(
									'recursive'=>2,
									'conditions'=>array(
										'Delivery.id'=>$id
								)));
		
		$this->set(compact('data','new'));
		$this->layout='pdf';
		$this->render();
	}

	function check_duplicate(){
		$result = $this->Delivery->find('all',array('conditions'=>array('delivery_receipt_no'=>$this->data)));
		echo json_encode($result);
		exit;
	}
	
	function customers(){
		$this->Customer->unbindModel(array('hasMany' => array('Product')));
		$customers = $this->Customer->find('all',array('order' =>array('Customer.order'=>'ASC','Customer.name'=>'ASC')));
		echo json_encode($customers);
		exit;
	}
	
	//FIX BUGS FROM 2021-03-17 Migration
	//Corrected Product ID via Product Name & Customer ID
	
	function step_one(){
		DIE('DONE STEP ONE');
		
		//use old table on product model = products_copy_03182021
		
		$this->DeliveryDetail->unbindModel( array('belongsTo' => array('Delivery')));
		$data = $this->DeliveryDetail->find('all',array(
					'conditions'=>array('DeliveryDetail.date'=>'2021-03-17')
				));
				
		foreach($data as $k=>$d){
			$data[$k]['DeliveryDetail']['product_name']=$d['Product']['name'];
			$data[$k]['DeliveryDetail']['product_correct_id']=$d['Product']['id'];
			unset($data[$k]['Product']);
		}
		pr($data);
		exit;
		
		if ($this->DeliveryDetail->saveAll($data)) {
			pr($data);
			exit;
		}
		
	}
	
	function step_two(){ 
		DIE('DONE STEP TWO');
		//use current table on product model = products
		$this->DeliveryDetail->unbindModel( array('belongsTo' => array('Product')));
		

		$data = $this->DeliveryDetail->find('all',array(
					'conditions'=>array('DeliveryDetail.date'=>'2021-03-17')
				));
		foreach($data as $k=>$d){
			$correctProduct = $this->async($d);
			
			$data[$k]['DeliveryDetail']['product_wrong_id'] = $d['DeliveryDetail']['product_id'];
			$data[$k]['DeliveryDetail']['product_id'] = $correctProduct['Product']['id'];
			$data[$k]['DeliveryDetail']['customer_id'] = $correctProduct['Product']['customer_id'];
			unset($data[$k]['Delivery']);
		
		}
		
		
		if ($this->DeliveryDetail->saveAll($data)) {
			die('YEy');
			exit;
		}
		
	}
	
	function async($d){
		$this->Product->unbindModel( array('belongsTo' => array('Category','Customer')));
		$this->Product->unbindModel( array('hasMany' => array('DeliveryDetail','ProductImage')));
		$f = $this->Product->find('first',array(
					'fields'=>array('id','name','customer_id'),
					'conditions'=>array(
						'customer_id'=>$d['Delivery']['customer_id'],
						'Product.name'=>$d['DeliveryDetail']['product_name'],
					)
				));
		return $f;
	}

	//END
	
	
	function report(){
		$this->Customer->unbindModel(array('hasMany' => array('Product')));
		$data = $this->Delivery->find('all',array(
									'recursive'=>0,
									'conditions'=>array('Delivery.created LIKE'=>'%2021%')
								));
		pr($data);exit;
		//$this->set(compact('data','new'));
		//$this->layout='pdf';
		//$this->render();
	}
	
	function admin_dashboard($year=2021){
		$year = $_GET['year'];
		
		$data = $this->Delivery->dashboard($year);
		//pr($data);exit;
		$this->set(compact('data','year'));
		$this->layout='pdf';
		$this->render();
		
	}
}	
	
	
