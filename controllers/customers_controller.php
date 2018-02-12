<?php
class CustomersController extends AppController {

	var $name = 'Customers';
	var $helpers = array('Access');
	var $uses = array('Customer','Product');

	function index() {
		$this->Customer->recursive = 0;
		$this->set('customers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->delete($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Customer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->layout ="admin_default";	
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('customer', $this->Customer->read(null, $id));
	}

	function admin_add() {
		$this->layout ="admin_default";	
		if (!empty($this->data)) {
			$string = str_replace(' ', '-', strtolower(trim($this->data['Customer']['name']))); 
			$this->data['Customer']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
		
		
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($slug = null) {
		$this->layout ="admin_default";	
		if (!$slug && empty($this->data)) {
			$this->Session->setFlash(__('Invalid customer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$string = str_replace(' ', '-', strtolower(trim($this->data['Customer']['name']))); 
			$this->data['Customer']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
			
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Customer->findBySlug($slug);
		}
			
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for customer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Customer->delete($id)) {
			$this->Session->setFlash(__('Customer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Customer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function all(){
		$customers = $this->Customer->find('all',array('order' =>array('Customer.id'=>'DESC')));
		//pr($customers);exit;
		echo json_encode($customers);
		exit;
	}
	
	function admin_clone(){
		$this->layout ="admin_default";	
	}
	
	function clone_data($slug = null){
		$data =  array();
		
		$data['New'] = $this->Customer->findBySlug($slug);
		if(empty($data['New']['Product'])){
			$this->Product->unbindModel( array('hasMany' => array('ProductImage','DeliveryDetail')));
			$this->Product->unbindModel( array('belongsTo' => array('Customer','Category')));
			$data['BalloonationProducts'] = $this->Product->find('all',array(
															'conditions'=>array('Product.customer_id'=>1),
															'order'=>array('Product.name'),
															'fields'=>array('name','item_code','purchase_price',
																			'selling_price','min','beginning_inventory',
																			'category_id','description','initial_inventory'
																			)
														));
														
			//SET PRODUCTS' CUSTOMER ID	AND SLUGS										
			foreach($data['BalloonationProducts'] as $k => $d){
				//CUSTOMER ID
				$data['BalloonationProducts'][$k]['Product']['customer_id'] = $data['New']['Customer']['id'];
				//SLUG
				$string = str_replace(' ', '-', strtolower(trim($d['Product']['name']))).'-'.$data['New']['Customer']['id']; 
				$data['BalloonationProducts'][$k]['Product']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
			}
											
			echo json_encode($data);
			exit;
		}else{
			die('Error: Customer Product was already initialized');
		}
	}
	
	function save_clone_data(){
		$this->Product->create();
		if ($this->Product->saveAll($this->data)) {
			$response['status'] = 1;
			$response['msg'] = 'Saving successful.';
			echo json_encode($response);
			exit();
		} else {
			$response['status'] = 0;
			$response['msg'] = 'Error saving.Pls try again';
			echo json_encode($response);
			exit();
		}
	}


}
