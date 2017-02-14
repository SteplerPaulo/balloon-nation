<?php
class ProductPricingsController extends AppController {

	var $name = 'ProductPricings';

	function index() {
		$this->ProductPricing->recursive = 0;
		$this->set('productPricings', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid product pricing', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('productPricing', $this->ProductPricing->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ProductPricing->create();
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The product pricing has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product pricing could not be saved. Please, try again.', true));
			}
		}
		$products = $this->ProductPricing->Product->find('list');
		$this->set(compact('products'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product pricing', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The product pricing has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product pricing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductPricing->read(null, $id);
		}
		$products = $this->ProductPricing->Product->find('list');
		$this->set(compact('products'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product pricing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductPricing->delete($id)) {
			$this->Session->setFlash(__('Product pricing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product pricing was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		$this->ProductPricing->recursive = 0;
		$this->set('productPricings', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid product pricing', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('productPricing', $this->ProductPricing->read(null, $id));
	}

	function admin_add() {
		$this->layout = 'admin_default';
		if (!empty($this->data)) {
			
			$this->ProductPricing->create();
			if ($this->ProductPricing->save($this->data)) {
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
			$this->Session->setFlash(__('Invalid product pricing', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductPricing->save($this->data)) {
				$this->Session->setFlash(__('The product pricing has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product pricing could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductPricing->read(null, $id);
		}
		$products = $this->ProductPricing->Product->find('list');
		$this->set(compact('products'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product pricing', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ProductPricing->delete($id)) {
			$this->Session->setFlash(__('Product pricing deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product pricing was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
