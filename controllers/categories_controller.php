<?php
class CategoriesController extends AppController {

	var $name = 'Categories';
	var $helpers = array('Access');
	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('main_children'));	
    } 

	function admin_index() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
	}

	function admin_view($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	function admin_add() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
		if (!empty($this->data)) {
			
			
			$string = str_replace(' ', '-', strtolower(trim($this->data['Category']['name']))); 
			$this->data['Category']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
			
			
			
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Category->find('list', array('recursive' => -1,'conditions' =>array('Category.id' => 1)));
		$this->set(compact('categories'));
	}

	function admin_edit($slug = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
		if (!$slug && empty($this->data)) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$string = str_replace(' ', '-', strtolower(trim($this->data['Category']['name']))); 
			$this->data['Category']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
			
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('Category has been updated', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Category->findBySlug($slug);
		}
		$categories = $this->Category->find('list', array('recursive' => -1,'conditions' =>array('Category.id' => 1)));
		$this->set(compact('categories'));
	}

	function admin_delete($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function main_children(){
		//$this->data = $this->Category->generatetreelist(null, null, null, '&nbsp;&nbsp;&nbsp;');
		//debug ($this->data); die;
		
		$categories = $this->Category->find('threaded', array('conditions' => array('Category.parent_id' => 1),'order'=>'Category.name'));
		echo json_encode($categories);
		exit;
	}
	
	function admin_slug(){
		$categories = $this->Category->find('all');
		
		foreach($categories as $k=>$d){
			
			$data['Category'][$k]['id'] = $d['Category']['id'];
			
			$string = str_replace(' ', '-', strtolower(trim($d['Category']['name']))); 
			$data['Category'][$k]['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);
		}
	
		if ($this->Category->saveAll($data['Category'])) {
			echo 'The category slug has been updated';
			exit;
		} else {
			echo 'The category slug could not be saved. Please, try again.';
			exit;
		}
	}
}
