<?php
class ProductsController extends AppController {

	var $name = 'Products';
	var $helpers = array('Access');
	var $uses = array('Product','Costumer','ProductTransaction');
	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('index','all','view','by_filter'));	
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
			$string = str_replace(' ', '-', strtolower(trim($this->data['Product']['name']))).'-'.$this->data['Product']['costumer_id']; 
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
		$costumers = $this->Product->Costumer->find('list');
		$this->set(compact('categories','costumers'));
	}

	function admin_edit($slug = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		$this->layout ="admin_default";	
		if (!$slug && empty($this->data)) {
			$this->Session->setFlash(__('Invalid product', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			$string = str_replace(' ', '-', strtolower(trim($this->data['Product']['name']))).'-'.$this->data['Product']['costumer_id']; 
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
		$costumers = $this->Product->Costumer->find('list');
		$this->set(compact('categories','costumers'));
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
		//$this->Product->unbindModel( array('hasMany' => array('ProductImage')));
		//$products = $this->Product->find('all',array('order' =>array('Product.modified DESC')));
		$products = $this->Product->find('all', array('contain' => array(
			'Category',
			'Costumer',
			'ProductImage',
			'ProductPricing' => array(
				//'conditions' => array('ProductPricing.quantity !=' => '0'),
				'order' => array('ProductPricing.created'=>'DESC'),
				'limit' => 1,
				
			)
		)));
		
		
	

		foreach ($products as $key => $value) {
		   $products[$key]['Product']['formated_last_date_posted'] = date('m/d/Y h:i:s A',strtotime($value['Product']['last_date_posted']));
		}
		
		$data['Products'] = $products;
		$this->Costumer->unbindModel( array('hasMany' => array('Product')));
		$data['Costumers'] = $this->Costumer->find('all');
	
		 
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
	
	function test() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		
		$this->layout = 'admin_default';
		
			
	
		
		
	}
	
	
	
	function admin_sales(){
		$this->layout ="admin_default";	
	}
	
	function sales_report(){
		
		$data = array();
		$this->Product->unbindModel( array('hasMany' => array('ProductImage')));
		
	
		$products = $this->Product->find('all', array('contain' => array(
			'Category',
			'Costumer',
			'ProductTransaction'=> array(
				'conditions' => array('ProductTransaction.date >=' => '2017-02-08 14:15:04'),	
			),
			'ProductPricing' => array(
				'conditions' => array('ProductPricing.quantity !=' => '0'),
				'order' => array('ProductPricing.created'=>'DESC'),
				'limit' => 1,
			)
		)));
		//pr($products);
		//exit;

		foreach ($products as $key => $product) {
			$products[$key]['Product']['delivered'] = 0;
			$products[$key]['Product']['returned'] = 0;
			foreach($product['ProductTransaction'] as $transaction){
				$products[$key]['Product']['delivered'] += $transaction['delivered_qty'];
				$products[$key]['Product']['returned'] += $transaction['returned_qty'];
				
				
			}
			$products[$key]['Product']['delivered'] = $products[$key]['Product']['delivered']+$products[$key]['Product']['posted_quantity'];
			$products[$key]['Product']['sales'] = $products[$key]['Product']['delivered']-($products[$key]['Product']['returned']+$products[$key]['Product']['current_quantity']);
				
		
				
		
			//unset($products[$key]['ProductTransaction']);
		}
		pr($products);
		exit;
		
		$data['Products'] = $products;
		$this->Costumer->unbindModel( array('hasMany' => array('Product')));
		$data['Costumers'] = $this->Costumer->find('all');
		echo json_encode($data);
		exit;
	}
	
	
	

}
