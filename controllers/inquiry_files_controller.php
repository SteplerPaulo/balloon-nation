<?php
class InquiryFilesController extends AppController {

	var $name = 'InquiryFiles';
	var $helpers = array('Access');

	function index() {
		$this->InquiryFile->recursive = 0;
		$this->set('inquiryFiles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid inquiry file', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('inquiryFile', $this->InquiryFile->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->InquiryFile->create();
			if ($this->InquiryFile->save($this->data)) {
				$this->Session->setFlash(__('The inquiry file has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry file could not be saved. Please, try again.', true));
			}
		}
		$inquiries = $this->InquiryFile->Inquiry->find('list');
		$this->set(compact('inquiries'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid inquiry file', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->InquiryFile->save($this->data)) {
				$this->Session->setFlash(__('The inquiry file has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry file could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InquiryFile->read(null, $id);
		}
		$inquiries = $this->InquiryFile->Inquiry->find('list');
		$this->set(compact('inquiries'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for inquiry file', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InquiryFile->delete($id)) {
			$this->Session->setFlash(__('Inquiry file deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Inquiry file was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_index() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->InquiryFile->recursive = 0;
		$this->set('inquiryFiles', $this->paginate());
	}

	function admin_view($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id) {
			$this->Session->setFlash(__('Invalid inquiry file', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('inquiryFile', $this->InquiryFile->read(null, $id));
	}

	function admin_add() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!empty($this->data)) {
			$this->InquiryFile->create();
			if ($this->InquiryFile->save($this->data)) {
				$this->Session->setFlash(__('The inquiry file has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry file could not be saved. Please, try again.', true));
			}
		}
		$inquiries = $this->InquiryFile->Inquiry->find('list');
		$this->set(compact('inquiries'));
	}

	function admin_edit($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid inquiry file', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->InquiryFile->save($this->data)) {
				$this->Session->setFlash(__('The inquiry file has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry file could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InquiryFile->read(null, $id);
		}
		$inquiries = $this->InquiryFile->Inquiry->find('list');
		$this->set(compact('inquiries'));
	}

	function admin_delete($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for inquiry file', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->InquiryFile->delete($id)) {
			$this->Session->setFlash(__('Inquiry file deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Inquiry file was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function upload(){
		if (!empty($this->data)) {
			$data = $this->data;
			$this->data['InquiryFile']['file_name'] = $this->data['InquiryFile']['file_name']['name'];
		
			$this->InquiryFile->create();
			if ($this->InquiryFile->save($this->data)) {
				
				move_uploaded_file($data['InquiryFile']['file_name']['tmp_name'],WWW_ROOT.'/img/inquiry files/'.$data['InquiryFile']['file_name']['name']);
				$this->Session->setFlash(__('The inquiry file has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry file could not be saved. Please, try again.', true));
			}
		}
	}
}
