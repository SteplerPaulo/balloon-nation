<?php
class CostumersController extends AppController {

	var $name = 'Costumers';
	var $helpers = array('Access');

	function index() {
		$this->Costumer->recursive = 0;
		$this->set('costumers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid costumer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('costumer', $this->Costumer->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Costumer->create();
			if ($this->Costumer->save($this->data)) {
				$this->Session->setFlash(__('The costumer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The costumer could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid costumer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Costumer->save($this->data)) {
				$this->Session->setFlash(__('The costumer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The costumer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Costumer->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for costumer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Costumer->delete($id)) {
			$this->Session->setFlash(__('Costumer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Costumer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->layout ="admin_default";	
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid costumer', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('costumer', $this->Costumer->read(null, $id));
	}

	function admin_add() {
		$this->layout ="admin_default";	
		if (!empty($this->data)) {
			$string = str_replace(' ', '-', strtolower(trim($this->data['Costumer']['name']))); 
			$this->data['Costumer']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
		
		
			$this->Costumer->create();
			if ($this->Costumer->save($this->data)) {
				$this->Session->setFlash(__('The costumer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The costumer could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($slug = null) {
		$this->layout ="admin_default";	
		if (!$slug && empty($this->data)) {
			$this->Session->setFlash(__('Invalid costumer', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Costumer->save($this->data)) {
				$this->Session->setFlash(__('The costumer has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The costumer could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Costumer->findBySlug($slug);
		}
			
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for costumer', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Costumer->delete($id)) {
			$this->Session->setFlash(__('Costumer deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Costumer was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function all(){
		$products = $this->Costumer->find('all',array('order' =>array('Costumer.modified DESC')));
		echo json_encode($products);
		exit;
	}


}
