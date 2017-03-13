<?php
class InquiriesController extends AppController {

	var $name = 'Inquiries';
	var $uses = array('Inquiry','Product');
	var $components = array('Email');
	var $helpers = array('Access');
	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('send','send_mail_using_smtp','send_via_contactus'));	
    } 

	function admin_index() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = 'admin_default';
	}

	function admin_view($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id) {
			$this->Session->setFlash(__('Invalid inquiry', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('inquiry', $this->Inquiry->read(null, $id));
	}

	function admin_add() {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!empty($this->data)) {
			$this->Inquiry->create();
			if ($this->Inquiry->save($this->data)) {
				$this->Session->setFlash(__('The inquiry has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid inquiry', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Inquiry->save($this->data)) {
				$this->Session->setFlash(__('The inquiry has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Inquiry->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for inquiry', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Inquiry->delete($id)) {
			$this->Session->setFlash(__('Inquiry deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Inquiry was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function send($slug = null) {
		if (!empty($this->data)) {
			$attachement =  null;
			$this->Inquiry->create();
			if ($this->Inquiry->save($this->data)) {
				
				if(!$this->data['InquiryFile']['file_name']['error']){ //Check if inquiry has an attached file  
					
					//CREATE DATA IMAGE (FIX ISSUE ON SAVING FILE DATA ON DATABASE)
					$data['InquiryFile']['inquiry_id'] = $this->Inquiry->id;
					$data['InquiryFile']['file_name'] = $this->data['InquiryFile']['file_name']['name'];
					
					if($this->Inquiry->InquiryFile->save($data)){
						
						//create new folder
						$dir = new Folder(WWW_ROOT . 'img' . DS . 'inquiry files'. DS . 'Inquiry ID '.$this->Inquiry->id, true);
						$attachement = WWW_ROOT . 'img' . DS . 'inquiry files'. DS . 'Inquiry ID '.$this->Inquiry->id.'/'.$this->data['InquiryFile']['file_name']['name'];
						
						//move uploaded file to the new folder
						move_uploaded_file($this->data['InquiryFile']['file_name']['tmp_name'],$attachement);
						
					}else{
						$this->Session->setFlash(__('The inquiry could not be saved. Please, try again.', true));
					}
				}else{
					$attachement =  null;
				}
				
				//SEND VIA SMTP
				$this->send_mail_using_smtp($this->data['Inquiry']['from'],
											$this->data['Inquiry']['subject'],
											$this->data['Inquiry']['content'],
											$attachement);
										
										
				$this->Session->setFlash(__('The inquiry has been sent', true));
				$this->redirect(array('controller'=>'products','action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inquiry could not be saved. Please, try again.', true));
			}
		}
		$product = $this->Product->findBySlug($slug);
		$this->set('product', $product);
	}
	
	function send_mail_using_smtp($from,$subject,$body,$attachement = null){
		
		$this->Email->smtpOptions = array( 
			'port'=>'465',
			'timeout'=>'30',
			'host' => 'ssl://box967.bluehost.com',
			'username'=>'paulobiscocho@tssilive.com',
			'password'=>'P@ssw0rd123',
		);

		/* Set delivery method */
		$this->Email->delivery = 'smtp';
		$this->Email->to = 'paulobiscocho@tssilive.com';
		$this->Email->bcc = array('paulobiscocho@gmail.com');
		$this->Email->subject = $subject;
		$this->Email->replyTo = $from ;
		$this->Email->from = 'SESEPHIL <paulobiscocho@tssilive.com>';
		$this->Email->attachments = array($attachement);
		$this->Email->template = 'inquiry'; // note no '.ctp'
		$this->Email->sendAs = 'html'; //Send as 'html', 'text' or 'both' (default is 'text')
		
		$this->set(compact('body'));
		
		//Do not pass any args to send()
		//$this->Email->delivery = 'debug';
		$this->Email->send();
		
		/* Check for SMTP errors. */
		$smtp_errors = $this->Email->smtpError;
		$this->set(compact('smtp_errors'));
	}
	
	//CREATING NEW FOLDER SAMPLE
	function create_directory(){
		$dir = new Folder(WWW_ROOT . 'img' . DS . 'inquiry files'. DS . 'Inquiry ID 2', true);
		//pr(WWW_ROOT . 'img' . DS . 'inquiry files'. DS . 'Inquiry ID 2'.'/');exit;
	}
	//TEST SMTP
	function test_smtp(){
		$from = 'pkerroj@gmail.com';
		$subject = 'TEST SMTP';
		$body = 'This is a test for secured smtp';
		$attachement = null;
		$this->send_mail_using_smtp($from,$subject,$body,$attachement);
	}
	
	function send_via_contactus() {
		if (!empty($this->data)) {
			$this->Inquiry->create();
			if ($this->Inquiry->save($this->data)) {
				//SEND VIA SMTP
				$this->send_mail_using_smtp($this->data['Inquiry']['from'],
											$this->data['Inquiry']['subject'],
											$this->data['Inquiry']['content'],
											null);
										
										
				$this->Session->setFlash(__('Your message has been sent', true));
				$this->redirect(array('controller'=>'','action' => 'contacts'));
			} else {
				$this->Session->setFlash(__('Error sending message. Please, try again.', true));
			}
		}
	}
	
	function all(){
		$data = $this->Inquiry->find('all');
		echo json_encode($data);
		exit;
	}
}
