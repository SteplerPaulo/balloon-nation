<?php
class DeliveriesController extends AppController {

	var $name = 'Deliveries';
	var $helpers = array('Access');
	var $uses = array('Delivery','Costumer','Product','ProductPricing','DeliveryDetail');

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
		$costumers = $this->Delivery->Costumer->find('list');
		$this->set(compact('costumers'));
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
		$costumers = $this->Delivery->Costumer->find('list');
		$this->set(compact('costumers'));
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
			
				$this->Product->saveAll($this->data['AssociatedProduct']);
				$this->ProductPricing->saveAll($this->data['AssociatedProductPrice']);
				
				$response['status'] = 1;
				$response['msg'] = 'Saving successful.';
				$response['data'] = $this->data;
				echo json_encode($response);
				exit();
			} else {
				$response['status'] = 1;
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
		$costumers = $this->Delivery->Costumer->find('list');
		$this->set(compact('costumers'));
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
		$data = $this->Delivery->find('all');
		
		
		foreach ($data as $key => $value) {
		   $data[$key]['Delivery']['formated_date'] = date('F d, Y h:i:s A',strtotime($value['Delivery']['date']));
		}
		
		echo json_encode($data);
		exit;
	}

	function admin_create(){
		$this->layout ="admin_default";	
	}
	
	function costumer_product($costumer = null){
		
		$data =  array();
		$products = $this->Product->find('all', array(
			'conditions' => array('Costumer.name' => $costumer),
			'contain' => array(
				'Category',
				'Costumer',
				'ProductImage',
				'ProductPricing' => array(
					//'conditions' => array('ProductPricing.quantity !=' => '0'),
					'order' => array('ProductPricing.created'=>'DESC'),
					'limit' => 1,
					)
			),
		));
		
		foreach ($products as $key => $value) {
			//$products[$key]['counted'] = 0;
			//$products[$key]['bad_item'] = 0;
			//$products[$key]['deliver'] = 0;
			$products[$key]['is_disabled'] = true;
			$products[$key]['checkbox'] = false;
			$products[$key]['cache_current_quantity'] = $value['Product']['current_quantity'];

			$products[$key]['TotalReturned'] = 0;
			$products[$key]['TotalDelivered'] = 0;
			foreach ($products[$key]['DeliveryDetail'] as $i => $dlvr) {
				$products[$key]['UpdatedTotalReturned'] = $products[$key]['TotalReturned'] +=$dlvr['bad_item'] ;
				$products[$key]['UpdatedTotalDelivered'] = $products[$key]['TotalDelivered'] +=$dlvr['deliver'] ;
			}

		}
		
		$data['Products'] = $products;
		$this->Costumer->unbindModel( array('hasMany' => array('Product')));
		$costumer = $this->Costumer->find('first',array('conditions'=>array('Costumer.name'=>$costumer)));
		$data['Costumer'] = $costumer['Costumer'];
		
		echo json_encode($data);
		exit;
	}
	
	
	function admin_report($dr_no = '004572'){
		
		$data = $this->Delivery->find('first',array(
									'recursive'=>2,
									'conditions'=>array(
										'Delivery.delivery_receipt_no'=>$dr_no
								)));
		
		$this->set(compact('data'));
		$this->layout='pdf';
		$this->render();
	
	}
}
