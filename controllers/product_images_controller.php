<?php
class ProductImagesController extends AppController {

	var $name = 'ProductImages';
	var $helpers = array('Access');

	function admin_index() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
	
	}


	function admin_add($slug =  null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
		if (!empty($this->data)) {
			
			$this->ProductImage->create();
			if ($this->ProductImage->save($this->data)) {
				$this->Session->setFlash(__('The product image has been saved', true));
				
				$this->redirect(array("controller" => 'product', 
					"action" => 'admin_'.$this->data['ProductImage']['product_slug'].'/images',
				));
				
			} else {
				$this->Session->setFlash(__('The product image could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product image', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ProductImage->save($this->data)) {
				$this->Session->setFlash(__('The product image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product image could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ProductImage->read(null, $id);
		}
		$products = $this->ProductImage->Product->find('list');
		$this->set(compact('products'));
	}

	function admin_delete($id =  null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		$id  = $this->params['named']['id'];
		$slug  = $this->params['named']['product_slug'];
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product image', true));
			$this->redirect(array("controller" => 'product', 
				"action" => 'admin_'.$slug.'/images',
			));
		}
		if ($this->ProductImage->delete($id)) {
			$this->Session->setFlash(__('Product image deleted', true));
			$this->redirect(array("controller" => 'product', 
				"action" => 'admin_'.$slug.'/images',
			));
		}
		$this->Session->setFlash(__('Product image was not deleted', true));
		$this->redirect(array("controller" => 'product', 
			"action" => 'admin_'.$slug.'/images',
		));
	}

	function by_filter($product_slug = null){
		$result = $this->ProductImage->Product->find('first',array('recursive'=>3,'conditions'=>array('Product.slug'=>$product_slug)));
		echo json_encode($result);
		exit;
		
	}
}
