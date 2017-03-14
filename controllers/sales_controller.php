<?php
class SalesController extends AppController {

	var $name = 'Sales';
	var $helpers = array('Access');
	var $uses = array('Sale','Product','Costumer','InclusiveDate');

	function index() {
		$this->Sale->recursive = 0;
		$this->set('sales', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sale', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sale', $this->Sale->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Sale->create();
			if ($this->Sale->save($this->data)) {
				$this->Session->setFlash(__('The sale has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid sale', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Sale->save($this->data)) {
				$this->Session->setFlash(__('The sale has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Sale->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sale', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Sale->delete($id)) {
			$this->Session->setFlash(__('Sale deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Sale was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->layout = 'admin_default';
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid sale', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('sale', $this->Sale->read(null, $id));
	}

	function admin_add() {
		
		//pr($this->data);exit;
		if (!empty($this->data)) {
			$this->Sale->create();
			if ($this->Sale->saveAll($this->data)) {
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
			$this->Session->setFlash(__('Invalid sale', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Sale->save($this->data)) {
				$this->Session->setFlash(__('The sale has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sale could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Sale->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for sale', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Sale->delete($id)) {
			$this->Session->setFlash(__('Sale deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Sale was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	
	function admin_create() {
		$this->layout = 'admin_default';
	}

	function all(){
		$data = $this->Sale->find('all');
		echo json_encode($data);
		exit;
	}
	
	function sales_report(){
		pr($this->data['from']);
		pr($this->data['to']);
		//exit;
		
		$data = array();
		$this->Product->unbindModel( array('hasMany' => array('ProductImage')));
		
	
		$products = $this->Product->find('all', array(
			'conditions' => array('Costumer.name' => $this->data['costumer']
			
						),
			'contain' => array(
				'Category',
				'Costumer',
				'DeliveryDetail'=> array(
					'conditions' => array(
									'DeliveryDetail.date' => $this->data['from'],
									//'DeliveryDetail.date <=' => $this->data['to'],
								
					)),
				'ProductPricing' => array(
					'conditions' => array('ProductPricing.quantity !=' => '0'),
					'order' => array('ProductPricing.created'=>'DESC'),
					'limit' => 1,
			)
		)));
		pr($products);exit;

		foreach ($products as $key => $product) {
			$products[$key]['Product']['delivered'] = 0;
			$products[$key]['Product']['returned'] = 0;
			foreach($product['DeliveryDetail'] as $dlvry){
				$products[$key]['Product']['delivered'] += $dlvry['deliver'];
				$products[$key]['Product']['returned'] += $dlvry['bad_item'];
				
				
			}
			if(!empty($product['DeliveryDetail'])){
				$products[$key]['Product']['sales'] = $products[$key]['Product']['delivered']-($products[$key]['Product']['returned']+$products[$key]['Product']['current_quantity']);
			}else{
				$products[$key]['Product']['sales'] = 0;
			}
			
				
		
			//unset($products[$key]['ProductTransaction']);
		}
		//pr($products);
		//exit;
		
		$data['Products'] = $products;
		$this->Costumer->unbindModel( array('hasMany' => array('Product')));
		$data['Costumers'] = $this->Costumer->find('all');
		echo json_encode($data);
		exit;
	}
	
	function admin_report(){
		
		$this->layout='pdf';
		$this->render();
	}
	
	function initial_data(){
		$data = array();
		$this->Costumer->unbindModel( array('hasMany' => array('Product')));
		$data['Costumers'] = $this->Costumer->find('all',array('order' =>array('Costumer.modified DESC')));
		$data['InclusiveDates'] = $this->InclusiveDate->find('all',array('conditions'=>array('InclusiveDate.group'=>'semi-monthly')));
		echo json_encode($data);
		exit;
	}
	
	function get_data(){
		$costumer_id = $this->data['costumer_id'];
		$data = $this->Sale->get_data($costumer_id,'2017-03-01','2017-03-15');
		echo json_encode($data);
		exit;
	}
	
	
}
