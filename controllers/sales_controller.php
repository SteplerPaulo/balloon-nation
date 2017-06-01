<?php
class SalesController extends AppController {

	var $name = 'Sales';
	var $helpers = array('Access');
	var $uses = array('Sale','Product','Customer','InclusiveDate');

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
		if (!empty($this->data)) {
			//pr($this->data);exit;
			
			$this->Sale->deleteAll(array(
				'Sale.customer_id' => $this->data['Sale']['customer_id'], 
				'Sale.from_date' => $this->data['Sale']['from_date'],
				'Sale.to_date' => $this->data['Sale']['to_date']
			));
			
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

	
	function admin_balancing() {
		$this->layout = 'admin_default';
	}

	function all(){
		$data = $this->Sale->find('all');
		echo json_encode($data);
		exit;
	}

	function admin_report($id = null){
		
		$data = $this->Sale->find('first',array(
								'recursive'=>2,
								'conditions'=> array(
									'Sale.id' => $id,
							)
					));
		
		//pr($data);exit;
		$this->set(compact('data'));
		$this->layout='pdf';
		$this->render();
	}
	
	function initial_data(){
		$data = array();
		$this->Customer->unbindModel( array('hasMany' => array('Product')));
		$data['Customers'] = $this->Customer->find('all',array('order' =>array('Customer.modified')));
		$data['InclusiveDates'] = $this->InclusiveDate->find('all',array('conditions'=>array('InclusiveDate.group'=>'semi-monthly')));
		echo json_encode($data);
		exit;
	}
	
	function get_data(){
		//pr($this->data);exit;
		$customer_id = $this->data['customer_id'];
		$from_date = $this->data['from'];
		$to_date = $this->data['to'];
		$data =array();
		
		//GET SALE (USE FOR CHECKING SALE STATUS)
		$sale = $this->Sale->find('first',array(
								'recursive'=>2,
								'conditions'=> array(
									'Sale.customer_id' => $customer_id,
									'Sale.from_date >=' => $from_date,
									'Sale.to_date <=' => $to_date,
							)));
		//CHECK IF POSTED
		if(empty($sale) || $sale['Sale']['is_posted'] !=  1){
			
				$data['is_posted'] =  false;
				//GET SALE DETAILS 
				$saleDetails = $this->Sale->get_data($customer_id,$from_date,$to_date);
				
				//GET PRODUCTS
				$this->Product->unbindModel( array('hasMany' => array('ProductImage','Deliviries','DeliveryDetail'),'belongsTo'=>array('Customer','Category')));
				$products = $this->Product->find('all',array('conditions'=>array('Product.customer_id'=>$customer_id),'order'=>'Product.name ASC'));
										
				//INJECT SALE DETAILS ON PRODUCTS ARRAY				
				foreach($products as $k => $prdct){
					//$products[$k]['sold'] = 0;
					$products[$k]['returned'] = 0;
					$products[$k]['delivered'] = 0;
					$products[$k]['purchase_price'] = 0.00;	
					$products[$k]['total_inventory'] = $prdct['Product']['beginning_inventory'];	
					foreach($saleDetails as $sale_dtls){
						if($prdct['Product']['id'] == $sale_dtls['products']['id']){
							$products[$k]['Product'] = $prdct['Product'];
							$products[$k]['returned'] = $sale_dtls[0]['total_returned'];
							$products[$k]['delivered'] = $sale_dtls[0]['total_delivered'];
							$products[$k]['purchase_price'] = $sale_dtls['delivery_details']['purchase_price'];
							$products[$k]['total_inventory'] = ($prdct['Product']['beginning_inventory']+$sale_dtls[0]['total_delivered'])-$sale_dtls[0]['total_returned'];
						}
					}				
				}
				$data['Result'] = $products;
		}else{
			$data['is_posted'] = true;
		}
		
	
		
		echo json_encode($data);
		exit;
	}
	
	
	function admin_posting($id = null){
		$this->layout = 'admin_default';
		$this->set(compact('id'));
	}
	
	function posting_data($id = null){
		$data = $this->Sale->find('first',array(
								'recursive'=>2,
								'conditions'=> array(
									'Sale.id' => $id,
							)
					));
					
		foreach ($data['SaleDetail'] as $key => $value) {
			if($value['sold'] > ($value['Product']['beginning_inventory']+$value['delivered'])){
				$data['SaleDetail'][$key]['over_sold'] = $value['sold'] - ($value['Product']['beginning_inventory']+$value['delivered']);
				$data['SaleDetail'][$key]['in_stock'] = 0;
		
			}else if($value['sold'] < ($value['Product']['beginning_inventory']+$value['delivered'])){
				$data['SaleDetail'][$key]['over_sold'] = 0;
				$data['SaleDetail'][$key]['in_stock'] = ($value['Product']['beginning_inventory']+$value['delivered'])-$value['sold'];
		
			}else{
				$data['SaleDetail'][$key]['over_sold'] = 0;
				$data['SaleDetail'][$key]['in_stock'] = 0;
			}
		
		}	
				
		echo json_encode($data);
		exit;
	}
	
	function posting_saving(){
		if (!empty($this->data)) {
			//pr($this->data);exit;
		
			$this->Sale->create();
			if ($this->Sale->saveAll($this->data['Sale'])) {
				$this->Product->saveAll($this->data['Product']);
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
	
}
