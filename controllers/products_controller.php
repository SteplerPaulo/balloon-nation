<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $helpers = array('Access');
	var $uses = array('Product','Customer');
	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('index','all','view','by_filter','main_products'));	
    } 

	function index() {
		
	}

	function view($slug = null) {
		if (!$slug) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	function admin_index() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		$this->layout = 'admin_default';
	}

	function admin_view($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('product', $this->Product->read(null, $id));
	}

	function admin_add() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		$this->layout ="admin_default";	
		if (!empty($this->data)) {
			//pr($this->data);exit;
			
			$string = str_replace(' ', '-', strtolower(trim($this->data['Product']['name']))).'-'.$this->data['Product']['customer_id']; 
			$this->data['Product']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
		
			$this->Product->create();
			if ($this->Product->saveAll($this->data)) {
				$this->Session->setFlash(__('The product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
			}
		}
		
		$categories = $this->Product->Category->find('list',array('conditions' =>array('Category.parent_id' => 1),'order'=>'Category.name'));
		$customers = $this->Product->Customer->find('list');
		$this->set(compact('categories','customers'));
	}

	function admin_edit($slug = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		$this->layout ="admin_default";	
		if (!$slug && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			
			$string = str_replace(' ', '-', strtolower(trim($this->data['Product']['name']))).'-'.$this->data['Product']['customer_id']; 
			$this->data['Product']['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
			
			if ($this->Product->save($this->data)) {
				$this->Session->setFlash(__('The product has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->findBySlug($slug);
		}
		$categories = $this->Product->Category->find('list',array('recursive' => -1,'conditions' =>array('Category.parent_id' => 1)));
		$customers = $this->Product->Customer->find('list');
		$this->set(compact('categories','customers'));
	}

	function admin_delete($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for product', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Product was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function all(){
		$data = array();
		$this->Product->unbindModel( array('hasMany' => array('ProductImage')));
		$products = $this->Product->find('all', array('contain' => array(
			'Category',
			'Customer',
		)));
		
		
	

		foreach ($products as $key => $value) {
		   $products[$key]['Product']['formated_last_date_posted'] = date('m/d/Y h:i:s A',strtotime($value['Product']['last_date_posted']));
		   $products[$key]['counted'] = 0;
		   $products[$key]['returns'] = 0;
		   $products[$key]['deliver'] = 0;
		}
		
		$data['Products'] = $products;
		$this->Customer->unbindModel( array('hasMany' => array('Product')));
		$data['Customers'] = $this->Customer->find('all');
	
		 
		echo json_encode($data);
		exit;
	}
	
	function main_products(){
		$data = $this->Product->find('all',array(
			'conditions' => array(
				'Product.customer_id'=>1,
			),
			'contain' => array(
				'Category',
				'Customer',
				'ProductImage',
			)
		));
		echo json_encode($data);
		exit;
	}

	

	function admin_slug(){
		$products = $this->Product->find('all');
		
		foreach($products as $k=>$d){
			$data['Product'][$k]['id'] = $d['Product']['id'];//ID
			$string = str_replace(' ', '-', strtolower(trim($d['Product']['name']))); 
			$data['Product'][$k]['slug'] = preg_replace('/[^A-Za-z0-9\-]/', '-', $string);//SLUG
		}
	
		if ($this->Product->saveAll($data['Product'])) {
			echo 'The product slug has been updated';
			exit;
		} else {
			echo 'The product slug could not be saved. Please, try again.';
			exit;
		}
	}

	function by_filter($slug = null){
		$result = $this->Product->find('first',array('recursive'=>3,'conditions'=>array('Product.slug'=>$slug)));
		echo json_encode($result);
		exit;
	}
	
	function copy_items(){
		die('Contact System Administrator');
		
		$products = $this->Product->find('all',array('conditions'=>array('Product.customer_id'=>4)));
		$customers = $this->Customer->find('all',array('conditions'=>array('Customer.id !='=>4)));
		$data = array();
		$i = 0;
		foreach($customers as $c){
			$customer_id = $c['Customer']['id'];
			if($customer_id != 4){
				foreach($products as $p){
					$string = str_replace(' ', '-', strtolower(trim($p['Product']['name']))).'-'.$customer_id; 
					$data[$i]['Product']=array(
						'category_id'=>$p['Product']['category_id'],
						'customer_id'=>$customer_id,
						'name'=>$p['Product']['name'],
						'item_code'=>$p['Product']['item_code'],
						'last_date_posted'=>date("Y-m-d H:i:s"),
						'purchase_price'=>$p['Product']['purchase_price'],
						'selling_price'=>$p['Product']['selling_price'],
						'slug'=>preg_replace('/[^A-Za-z0-9\-]/', '-', $string),
					);
					$i++;
				}
			}
		}
		
		$this->Product->create();
		if ($this->Product->saveAll($data)) {
			die('SUCCESS');
		} else {
			die('ERROR');
		}
		
	}
	
}
