<?php
class CustomersController extends AppController {

	var $name = 'Customers';
	var $helpers = array('Access');
	var $uses = array('Customer','Product','Delivery','Sale');
	
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
			
			//pr($this->data);exit;
			$string = str_replace(' ', '-', strtolower(trim($this->data['Customer']['name']))); 
			$this->data['Customer']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
		
		
			$this->Customer->create();
			if ($this->Customer->save($this->data)) {
				$this->Session->setFlash(__('The customer has been saved', true));
				$this->redirect(array('controller'=>'users','action' => 'dashboard'));
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
				$this->redirect(array('controller'=>'users','action' => 'dashboard'));
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
	
	function admin_clone(){
		$this->layout ="admin_default";	
	}
	
	//THIS METHOD IS OBSOLETE, this can only be use when the customer got no associated product yet 
	//(per mam tracy we need to create new method that can add new products on a customer even with an existing associated product on it)
 	function clone_data($slug = null){// GET ALL DATA FROM BALLOONATION MAIN INVENTORY
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
		//pr($this->data);exit;
		
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
	
	//THIS METHOD 
	function test($slug = null){// TEST - USE FOR CLONING ONLY THE NEW ADDITIONAL DATA FROM BALLOONATION MAIN INVENTORY
		$data =  array();
		
		$data['Customer'] = $this->Customer->findBySlug($slug);
		

		$this->Product->unbindModel( array('hasMany' => array('ProductImage','DeliveryDetail')));
		$this->Product->unbindModel( array('belongsTo' => array('Customer','Category')));
		$data['BalloonationProducts'] = $this->Product->find('all',array(
														'conditions'=>array(
																		'Product.customer_id' => 1),
														'order'=>array('Product.name'),
														'fields'=>array('name','item_code','purchase_price',
																		'selling_price','min','beginning_inventory',
																		'category_id','description','initial_inventory',
																		'customer_id'
																		)//never try to add id on the list of fields,
																		//it will have affect on product cloning
													));
		

													
		//SET PRODUCTS' CUSTOMER ID	AND SLUGS & REMOVE EXISTING CUSTOMER PRODUCT ON THE LIST									
		foreach($data['BalloonationProducts'] as $k => $d){
			$data['BalloonationProducts'][$k]['Product']['status'] = 'new';
			$data['BalloonationProducts'][$k]['Product']['is_disabled'] = true;
			$data['BalloonationProducts'][$k]['Product']['checkbox'] = false;
		
			if(!empty($data['Customer']['Product'])){
				foreach($data['Customer']['Product'] as $ck => $cp){
					if($d['Product']['name'] == $cp['name']){//filtered customer existing product & remove it on the list
						unset($data['BalloonationProducts'][$k]);
						break;
					}else{
						//set customer id
						$data['BalloonationProducts'][$k]['Product']['customer_id'] = $data['Customer']['Customer']['id'];
						//slug
						$string = str_replace(' ', '-', strtolower(trim($d['Product']['name']))).'-'.$data['Customer']['Customer']['id']; 
						$data['BalloonationProducts'][$k]['Product']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
					}
				}
			}else{
				//set customer id
				$data['BalloonationProducts'][$k]['Product']['customer_id'] = $data['Customer']['Customer']['id'];
				//slug
				$string = str_replace(' ', '-', strtolower(trim($d['Product']['name']))).'-'.$data['Customer']['Customer']['id']; 
				$data['BalloonationProducts'][$k]['Product']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
		

		
			}
			
		}
		
		$data['BalloonationProducts'] = array_values($data['BalloonationProducts']);
		echo json_encode($data);
		exit;
	}
	
	function complete_list_of_double_entry(){
		$data = $this->Customer->complete_list_of_double_entry();
		$this->set(compact('data'));
		$this->layout='pdf';
		$this->render();
	}
	
	function double_entry_list(){
		$data = $this->Customer->double_entry_list();
		
		$this->set(compact('data'));
		$this->layout='pdf';
		$this->render();
	}
	
	function deleted_deliveries(){
		$data = $this->Customer->deleted_deliveries();
		
		$this->set(compact('data'));
		$this->layout='pdf';
		$this->render();
	}
	
	function all(){
		$this->Customer->unbindModel(array('hasMany' => array('Product')));
		$customers = $this->Customer->find('all',array('order' =>array('Customer.order'=>'ASC','Customer.modified'=>'DESC')));
		echo json_encode($customers);
		exit;
	}
	
	function deliveries($customer_id = null){
		$this->Delivery->unbindModel( array('hasMany' => array('DeliveryDetail')));
		
		$data = $this->Delivery->find('all',array(
									'order'=>array('Delivery.modified'=>'DESC'),
									'conditions'=>array('Delivery.customer_id'=>$customer_id)
									));
		echo json_encode($data);
		exit;
	}
	
	function products($customer_id = null){
		$this->Product->unbindModel( array('hasMany' => array('DeliveryDetail','ProductImage')));
		
		$data = $this->Product->find('all',array(
									'order'=>array('Product.name'=>'ASC'),
									'conditions'=>array('Product.customer_id'=>$customer_id)
									));
		echo json_encode($data);
		exit;
	}
	
	function sales($customer_id = null){
		$this->Sale->unbindModel( array('hasMany' => array('SaleDetail')));
		
		$data = $this->Sale->find('all',array(
									'order'=>array('Sale.from_date'=>'DESC'),
									'conditions'=>array('Sale.customer_id'=>$customer_id)
									//'conditions'=>array('Sale.from_date LIKE'=>'%2017%')
									));
		echo json_encode($data);
		exit;
	}
	
}
