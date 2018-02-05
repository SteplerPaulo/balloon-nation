<?php
class DeliveriesController extends AppController {

	var $name = 'Deliveries';
	var $helpers = array('Access');
	var $uses = array('Delivery','Customer','Product','DeliveryDetail');

	function index() {
		$this->Delivery->recursive = 0;
		$this->set('deliveries', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid delivery', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('delivery', $this->Delivery->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Delivery->create();
			if ($this->Delivery->save($this->data)) {
				$this->Session->setFlash(__('The delivery has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The delivery could not be saved. Please, try again.', true));
			}
		}
		$customers = $this->Delivery->Customer->find('list');
		$this->set(compact('customers'));
	}

	function edit($id = null) {
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

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for delivery', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Delivery->delete($id)) {
			$this->Session->setFlash(__('Delivery deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Delivery was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
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

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for delivery', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Delivery->delete($id)) {
			$this->Session->setFlash(__('Delivery deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Delivery was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function all(){
		$data = array();
		$data = $this->Delivery->find('all',array('order'=>'date DESC'));
		
		foreach ($data as $key => $value) {
		   $data[$key]['Delivery']['formated_date'] = date('F d, Y h:i:s A',strtotime($value['Delivery']['date']));
		}
		
		echo json_encode($data);
		exit;
	}

	function admin_create(){
		$this->layout ="admin_default";	
	}
	
	function customer_product($customer = null){
		
		$data =  array();
		$this->Product->unbindModel( array('hasMany' => array('ProductImage')));
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
	
	function admin_report($id = null){
		
		$data = $this->Delivery->find('first',array(
									'recursive'=>2,
									'conditions'=>array(
										'Delivery.id'=>$id
								)));
		
		$this->set(compact('data'));
		$this->layout='pdf';
		$this->render();
	
	}

	function check_duplicate(){
		$result = $this->Delivery->find('all',array('conditions'=>array('delivery_receipt_no'=>$this->data)));
		echo json_encode($result);
		exit;
	}
}
