<?php
class ProductTransactionsController extends AppController {

	var $name = 'ProductTransactions';
	var $helpers = array('Access');

	function index() {
		$this->ProductTransaction->recursive = 0;
		$this->set('productTransactions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid product transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('productTransaction', $this->ProductTransaction->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ProductTransaction->create();
			if ($this->ProductTransaction->save($this->data)) {
				$this->Session->setFlash(__('The product transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product transaction could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductTransaction->save($this->data)) {
				$this->Session->setFlash(__('The product transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product transaction could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductTransaction->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product transaction', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductTransaction->delete($id)) {
			$this->Session->setFlash(__('Product transaction deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product transaction was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->layout = 'admin_default';
		
		$this->ProductTransaction->recursive = 0;
		$this->set('productTransactions', $this->paginate());
	}

	function admin_view($id = null) {
		$this->layout = 'admin_default';
		if (!$id) {
			$this->Session->setFlash(__('Invalid product transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('productTransaction', $this->ProductTransaction->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin_default';
		if (!empty($this->data)) {
			
			
			
			//pr($this->data);exit;
			
			$this->ProductTransaction->create();
			if ($this->ProductTransaction->saveAll($this->data)) {
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
		$this->layout = 'admin_default';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product transaction', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductTransaction->save($this->data)) {
				$this->Session->setFlash(__('The product transaction has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product transaction could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductTransaction->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product transaction', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductTransaction->delete($id)) {
			$this->Session->setFlash(__('Product transaction deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product transaction was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_get(){
		
		$result = $this->ProductTransaction->find('all',array(
										'conditions'=>array(
											'ProductTransaction.product_id'=>$this->data['product_id'],
											'ProductTransaction.date >= '=>$this->data['last_date_posted'],
											)
										));
		$data = array();
		$data['TotalAdded'] = 0;
		$data['TotalSubtracted'] = 0;
		foreach ($result as $key => $value) {
		   $result[$key]['ProductTransaction']['formated_date'] = date('m/d/Y h:i:s A',strtotime($value['ProductTransaction']['date']));
		  
			$data['TotalAdded'] +=$value['ProductTransaction']['added'] ;
			$data['TotalSubtracted']+=$value['ProductTransaction']['subtracted'];
		}
		
		
		$data['CurrentQuantity'] = $this->data['posted_quantity']+$data['TotalAdded']-$data['TotalSubtracted'];
		$data['Data'] = $result;
		
							
							
		//pr($data);exit;								
		echo json_encode($data);
		exit;
	}
}
