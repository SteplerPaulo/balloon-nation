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

	
	function admin_journal_entry() {
		$this->layout = 'admin_default';
	}

	function all(){
		$this->Sale->unbindModel( array('hasMany' => array('SaleDetail')));
		
		$data = $this->Sale->find('all',array(
									'order'=>array('Sale.from_date'=>'DESC'),
									//'conditions'=>array('Sale.from_date LIKE'=>'%2017%')
									));
		echo json_encode($data);
		exit;
	}
	
	function customer_sales($customer_id = null){
		$this->Sale->unbindModel( array('hasMany' => array('SaleDetail')));
		
		$data = $this->Sale->find('all',array(
									'order'=>array('Sale.from_date'=>'DESC'),
									'conditions'=>array('Sale.customer_id'=>$customer_id)
									//'conditions'=>array('Sale.from_date LIKE'=>'%2017%')
									));
		echo json_encode($data);
		exit;
	}
	
	function admin_customer(){
		$this->layout = 'admin_default';
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
		$data['Customers'] = $this->Customer->find('all',array('order' =>array('Customer.name')));
		echo json_encode($data);
		exit;
	}
	
	function get_data(){
		$customer_id = $this->data['customer_id'];
		$from_date = $this->data['from_date'];
		$to_date = $this->data['to_date'];
		
		$data = array();
		$data['selected_items'] = 0;
		
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
					$products[$k]['ending_inventory'] = $prdct['Product']['beginning_inventory'];
					$products[$k]['sold'] = 0.00;
					$products[$k]['over_sold'] = 0.00;
					$products[$k]['purchase_price'] = 0.00;	
					$products[$k]['total_inventory'] = (float)$prdct['Product']['beginning_inventory'];
					$products[$k]['is_readonly'] = true;
					$products[$k]['checkbox'] = false;
					$products[$k]['doc_init'] = false;
					foreach($saleDetails as $sale_dtls){
						if($prdct['Product']['id'] == $sale_dtls['products']['id']){
							$products[$k]['Product'] = $prdct['Product'];
							$products[$k]['returned'] = $sale_dtls[0]['total_returned'];
							$products[$k]['delivered'] = ($sale_dtls[0]['total_delivered'] != null)?$sale_dtls[0]['total_delivered']:0;
							$products[$k]['purchase_price'] = $sale_dtls['delivery_details']['purchase_price'];
							$products[$k]['total_inventory'] = (float)($prdct['Product']['beginning_inventory']+$sale_dtls[0]['total_delivered'])-$sale_dtls[0]['total_returned'];
							$products[$k]['ending_inventory'] = ($prdct['Product']['beginning_inventory']+$sale_dtls[0]['total_delivered'])-$sale_dtls[0]['total_returned'];
						}
					}	
					//Insert Doc Data
					if(isset($this->data['doc_data'])){
						foreach($this->data['doc_data'] as $dd){
							
							//FIXED THE BUGS FROM DOC DATA (Bugs happen when data has got one line item only)
							if(!isset($dd['SoldItems'][0])){
								$dummy = $dd['SoldItems'];
								unset($dd['SoldItems']);
								$dd['SoldItems'][0] = $dummy;
							}
							
							foreach($dd['SoldItems'] as $lineItem){
								if((int)$prdct['Product']['item_code'] == (int)$lineItem['tradeItemId']['gtin']){
									//pr((int)$lineItem['tradeItemId']['gtin'].' = '.(int)$products[$k]['Product']['item_code']);
									
									$products[$k]['sold'] +=(float)$lineItem['quantitySold'];
									$products[$k]['ending_inventory'] -= (float)$lineItem['quantitySold'];
									$products[$k]['is_readonly'] = false;
									$products[$k]['checkbox'] = true;
									if($products[$k]['doc_init'] == false){
										$data['selected_items']++;
										$data['SelectedItemValidation'] = $data['selected_items'];
									}
									$products[$k]['doc_init'] = true;
								}
							}
						}
						
						if($products[$k]['ending_inventory'] < 0){
							$products[$k]['over_sold'] = abs($products[$k]['ending_inventory']);
							$products[$k]['ending_inventory'] = 0;
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
	
	//POSTING
	function admin_posting($id = null){
		$this->layout = 'admin_default';
		$this->set(compact('id'));
	}
	
	function posting_data($id = null){
		
		$this->Sale->Behaviors->attach('Containable');					
		$data = $this->Sale->find('first', array(
			'conditions'=> array('Sale.id' => $id),
			'fields'=> array('id','from_date', 'to_date','is_posted'),
			'contain'=>array(
				'Customer' => array(
					'fields' => array('id', 'name'),
				),
				'SaleDetail' => array(
					'Product' => array(
						'fields' => array('id', 'name','beginning_inventory','missing_qty')
					),
				)
			)
		));		
		
		foreach ($data['SaleDetail'] as $key => $value) {
			
			$out = $value['sold']+$value['returned'];
			$in = $value['Product']['beginning_inventory']+$value['delivered'];
			
			
			if($out > $in){
				$data['SaleDetail'][$key]['over_sold'] = $out - $in;
				$data['SaleDetail'][$key]['in_stock'] = 0;
		
			}else if($out < $in){
				$data['SaleDetail'][$key]['over_sold'] = 0;
				$data['SaleDetail'][$key]['in_stock'] = $in - $out;
			}else{
				$data['SaleDetail'][$key]['over_sold'] = 0;
				$data['SaleDetail'][$key]['in_stock'] = 0;
			}
			
			$data['SaleDetail'][$key]['ending_inventory'] = $data['SaleDetail'][$key]['in_stock'];//RESET ENDING INVENTORY IF SALE HAS BEEN UNPOSTED
			$data['SaleDetail'][$key]['beginning_inventory'] = $value['Product']['beginning_inventory'];//RESET BEGINNING INVENTORY IF SALE HAS BEEN UNPOSTED
			$data['SaleDetail'][$key]['missing_qty'] = 0;
		}	
		echo json_encode($data);
		exit;
	}
	
	function posting_saving(){
		
		if (!empty($this->data)) {
			
		
		//	pr($this->data);exit;
			
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
	//END
	
	function update_product_inventory(){
		pr($this->data['Product']);
		exit;
	}
	
	function select(){
		$this->layout = 'admin_default';
		
	}
	
	function upload(){
		$this->layout = 'admin_default';
		
		$target_dir = WWW_ROOT ."/xml/sales report/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	
	
		pr($target_file);exit;
		
		$uploadOk = 1;
		$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
		pr(pathinfo($target_file,PATHINFO_EXTENSION));
		
		
		/* Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		*/

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($fileType !="xml" ) {
			echo "Sorry, only XML files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			pr($_FILES["fileToUpload"]["tmp_name"]);exit;

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}

		$str =  file_get_contents($target_file);
		$xml = new SimpleXMLElement($str);

		$items = $xml->concesLineItem;
		$data =  array();
		foreach($items as $item){
			$id =  $item->tradeItemId->gtin;
			$desc =  $item->description;
			$qtySold =  $item->quantitySold;
			$unitPrice =  $item->unitPrice;
			$amountPayable =  $item->amountPayable;
			$obj =  array('id'=>$id,'desc'=>$desc,'qtySold'=>$qtySold,'unitPrice'=>$unitPrice,'amountPayable'=>$amountPayable);
			array_push($data,$obj);
		}
		
		$this->set(compact('data'));
		//echo json_encode($data);
		//exit;
		//var_dump($xml);

	}

	function correct_last_date_of_the_month(){
		
		$data = $this->Sale->find('all',array(
									'recursive'=>-1,
									'conditions'=>array('Sale.to_date'=>'0000-00-00'),
									'fields'=>array('id','from_date','to_date')
								));
								
		foreach($data as $k=>$d){
			$fromDate = $d['Sale']['from_date'];
			
			$data[$k]['Sale']['to_date'] = date("Y-m-t", strtotime($fromDate));
			//pr($fromDate .' to '. $toDate);
			
			
			
		}	

		if ($this->Sale->saveAll($data)) {
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
								
		pr($data);exit;
		
		
		
	}

	function customers(){
		$this->Customer->unbindModel( array('hasMany' => array('Product')));
		$customers = $this->Customer->find('all',array('order' =>array('Customer.id'=>'ASC')));
		echo json_encode($customers);
		exit;
	}
	
	//UNPOSTING
	function admin_unposting(){
		$this->layout = 'admin_default';
	}
	
	function unpost_customer_sales(){
		//pr();exit;
		if(!empty($this->data)){
			
			$result =  $this->Sale->unpost($this->data['Customer']['id']);
			echo json_encode($result);
		}
		
		
	}
}
