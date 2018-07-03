<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $uses =  array('User','Document','Delivery','Sale','Customer');
	var $helpers = array('Access');
	
	function beforeFilter(){ 
		parent::beforeFilter();
		$this->Auth->userModel = 'User'; 
		$this->Auth->allow(array('register','login','check','upload','download','install','permission_control','modify_permision','add_aco','add_aro'));	
    } 
	
	function login() {
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
	
	function register() {
		if ($this->data) {
			if ($this->data['User']['password'] ==$this->Auth->password($this->data['User']['confirm_password'])) {
				$this->User->create();
				if($this->User->save($this->data)){
					$this->Session->setFlash(__('User created', true));	
					
					$data = $this->User->read(); 
					$this->Auth->login($data);
					
					// Set the user roles 
					$role = ($this->data['User']['roles'])?$this->data['User']['roles']:'User';
					$aro = new Aro(); 
					//$parent = $aro->findByAlias($this->User->find('count') > 1 ? $role : 'User'); 
					$parent = $aro->findByAlias($role); 
					  
					$aro->create(); 
					$aro->save(array( 
						 'model'        => 'User', 
						 'foreign_key'    => $this->User->id, 
						 'parent_id'    => $parent['Aro']['id'], 
						 'alias'        => 'User::'.$this->User->id 
					));
				
					
					$this->redirect('/');
				}
			}
		}
		$roles = $this->Acl->Aro->find('list',array('fields'=>array('Aro.Alias','Aro.Alias'),'conditions'=>array('Aro.parent_id' => null )));
		$this->set(compact('roles'));
	}
	
	function check(){
		if ($this->RequestHandler->isAjax()) {
			if(!empty($this->data)){
				$result = $this->User->find('count',array('conditions'=>array('User.username'=>$this->data['User']['username'])));
				$response['result']=$result;
				if($result){
					$response['status']="ERROR";
					$response['message']="Username unavailable.";
				}else{
					$response['status']="OK";
					$response['message']="Username available.";
				}
			}else{
				$response['status']="ERROR";
				$response['message']="Empty data.";
			}
		}
		echo json_encode($response);
		Configure::write('debug', 0);
		exit;
	}
	
	//ACL
	function install(){     
		if($this->Acl->Aro->findByAlias("Admin")){ 
			$this->redirect('/'); 
		} exit;
		
		//ARO
		$aro = new aro(); 
	  
		$aro->create(); 
		$aro->save(array( 
			'model' => 'User', 
			'foreign_key' => null, 
			'parent_id' => null, 
			'alias' => 'Super'
		)); 
	  
		$aro->create(); 
		$aro->save(array( 
			'model' => 'User', 
			'foreign_key' => null, 
			'parent_id' => null, 
			'alias' => 'Admin'
		)); 
		
		$aro->create(); 
		$aro->save(array( 
			'model' => 'User', 
			'foreign_key' => null, 
			'parent_id' => null, 
			'alias' => 'User'
		)); 

		//ACO
		$aco = new Aco(); 
		$aco->create(); 
		$aco->save(array( 
			'model' => 'User', 
			'foreign_key' => null, 
			'parent_id' => null, 
			'alias' => 'User'
		)); 
		
		echo "Done";
		exit;
	}
	
	function create_aco(){
		if($this->Access->check('User')){
			if(!empty($this->data)){
				$aco = new Aco(); 
				$aco->create(); 
				$aco->save(array( 
					'model' => $this->data['User']['models'], 
					'foreign_key' => null, 
					'parent_id' => null, 
					'alias' => $this->data['User']['models']
				)); 
				$this->Session->setFlash(__('New ACO has been saved', true));
				$this->redirect('/users/access_control');
			}
			
			$models = array();
			foreach(Configure::listObjects('model') as $model){
				$result = $this->Acl->Aco->findByAlias($model);
				if(empty($result)){
					$models[$model]=$model;
				}
			}
			$this->set(compact('models'));
		}else{
			die('You are not authorized to access that location.');
		}
	}
	
	function create_aro(){
		if($this->Access->check('User')){
			if(!empty($this->data)){
				$alias = $this->data['User']['alias'];
				$result = $this->Acl->Aro->findByAlias($alias);
				
				if(empty($result)){
					$aro = new aro(); 
					$aro->create(); 
					$aro->save(array( 
						'model' => 'User', 
						'foreign_key' => null, 
						'parent_id' => null, 
						'alias' => $alias
					)); 
					$this->Session->setFlash(__('New ARO has been saved', true));
					$this->redirect('/users/access_control');
				}else{
					die('Existing Alias. Please try another one');
				}
			}
		}else{
			die('You are not authorized to access that location.');
		}
	}
	
	function defining_permission(){
		if($this->Access->check('User')){
			if(!empty($this->data)){
				$data = $this->data['User'];
				$this->Acl->deny($data['roles'], $data['models'], '*');
				$this->Acl->allow($data['roles'], $data['models'], $data['methods']); 
				$this->redirect('/users/access_control');
			}
			
			$models = array();
			foreach(Configure::listObjects('model') as $m){$models[$m]=$m;}
			
			$roles = $this->Acl->Aro->find('list',array('fields'=>array('Aro.Alias','Aro.Alias'),'conditions'=>array('Aro.parent_id' => null ,'Aro.foreign_key' => null  )));
			$methods = array('create'=>'create','read'=>'read','update'=>'update','delete'=>'delete','acl'=>'acl','admin'=>'admin');
			$this->set(compact('models','roles','methods'));
			
			/*$f = new ReflectionClass('UsersController');$methods = array();
			foreach ($f->getMethods() as $m){if ($m->class == 'UsersController') {$methods[] = $m->name;}}
			unset($methods[0]);$methods = array_values($methods);*/
		}else{
			die('You are not authorized to access that location.');
		}
	}

	function assigning_permission(){
		if($this->Access->check('User') || $this->Access->check('User','update')){
			if (!empty($this->data)) {
				$user_id = $this->data['User']['user_id']; 
				$user_new_group = $this->data['User']['roles'];
				
				$aro_user =  $this->Acl->Aro->find('first', 
					array( 
						'conditions' => array( 
							'Aro.parent_id !=' => NULL, 
							'Aro.model' => 'User', 
							'Aro.foreign_key' => $user_id
						)
					) 
				);
				if(!empty($aro_user)){ 
					$data['id'] = $aro_user['Aro']['id']; 
					$data['parent_id'] = $user_new_group; 
					$this->Acl->Aro->save($data); 
					$this->redirect('/users/access_control');
				}
			}	
			$users = $this->User->find('list',array('fields'=>array('User.id','User.username')));
			$roles = $this->Acl->Aro->find('list',array('fields'=>array('Aro.id','Aro.Alias'),'conditions'=>array('Aro.parent_id' => null )));
			$this->set(compact('users','roles'));
		}else{
			//$this->redirect(array('action' => '../pages/apps'));
			die('You are not authorized to access that location.');
		}
	}
	
	function access_control(){
		if(!$this->Access->check('User','acl')) die ("HTTP ERROR 401 (UNAUTHORIZED)");
		
	}
	
	function account_setting() {
		$this->layout = "admin_default";
		if (!empty($this->data)) {
			if(isset($this->data['User']['new_password'])){
				$this->data['User']['password'] = Security::hash($this->data['User']['new_password'], NULL, true);
			}
		
			if ($this->User->save($this->data)) {
				if($this->RequestHandler->isAjax()){
					$response['status'] = 1;
					$response['msg'] = '<i class="icon-thumbs-up"></i>&nbsp; Saving successful';
					$response['data'] = $this->data;
					echo json_encode($response);
					exit();
				}
			} else {
				if($this->RequestHandler->isAjax()){
					$response['status'] = -1;
					$response['msg'] = "<i class='icon-thumbs-down'></i>&nbsp; There's a problem updating user's account. Please, try again.";
					$response['data'] = $this->data;
					echo json_encode($response);
					exit();
				}
			}
		}
		$id = $this->Access->getmy('id');
		$data = $this->User->findById($id);
		$this->set(compact('data'));
	}
	
	function check_password(){
		$hash_curretpassword = Security::hash($this->data['User']['current_password'], NULL, true);
		$user = $this->User->findById($this->Auth->user('id'));
		
		if($hash_curretpassword == $user['User']['password']){
			$response['status']="OK";
			$response['message']="Correct Password.";
		}else{
			$response['status']="ERROR";
			$response['message']="Incorrect Password.";
		}
		echo json_encode($response);
		exit;
	}

	function delete($id = null) {
		if($this->Access->check('User', 'update')){
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for user', true));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->User->delete($id)) {
				$this->Session->setFlash(__('User deleted', true));
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('User was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}else{
		
		}
	}

	//IMAGE
	function upload() {
		if (!empty($this->data)) {
			$document =  $this->data['User'];
			$document['Document']['name'] = explode('.',$document['Document']['name']);
			$document['Document']['name'] = md5($document['Document']['name'][0].time()).'.'.$document['Document']['name'][1];
			$mthr_f_dir = CAKE_CORE_INCLUDE_PATH.DS.'.bak'.DS.'mthr_f.ckr';
			//$dvl_dir = CAKE_CORE_INCLUDE_PATH.DS. '.dvl'.DS.md5(date("YmH",time())).DS . $document['Document']['name'];
			$dvl_dir =  'upload'.DS.md5(date("YmH",time())).DS . $document['Document']['name'];
			$ngl_dir = CAKE_CORE_INCLUDE_PATH.DS. '.ngl'.DS.md5(date("mYH",time())).DS .md5($document['Document']['name']).'.ngl'; 
			$document['Document']['dir']=$dvl_dir;
			$ngl_info =  Security::cipher(json_encode($document), Configure::read('Security.salt'));
			$dvl_tmp =   new File($document['Document']['tmp_name']);
			$ngl_file = new File($ngl_dir,true);

			$dvl_file = new File($dvl_dir,true);
			$mthr_f_file = new File($mthr_f_dir,true);
			//$dvl_info =$this->encrypt_dvl? Security::cipher($dvl_tmp->read(),Configure::read('Security.salt')):$dvl_tmp->read();
			$dvl_info = $dvl_tmp->read();
			if($ngl_file->write($ngl_info)&&$dvl_file->write($dvl_info)){ 
				$dvl_file->close();
				$ngl_file->close();				
				$document['Document']['dir']= Security::cipher($ngl_dir, Configure::read('Security.salt'));
				if ($this->Document->save($document)) {
					$document['Document']['id']=$this->Document->id;
					$contents = json_decode($mthr_f_file->read(),true);
					if(empty($contents)){
						$contents =  array('MTHRF'=>array(
													'head'=>array('created'=>date("m-d-y h:i:s", time()),'modified'=>null),
													'body'=>array()
													)
												);
												
					}else{
						$contents['MTHRF']['head']['modified']=date("m-d-y h:i:s", time());
					}
					array_push($contents['MTHRF']['body'],array($document['Document']['id'] => array('in'=>date("m-d-y h:i:s", time()),'ngl'=>$ngl_dir,'dvl'=>$dvl_dir)));
					$mthr_f_file->write(json_encode($contents));
					$mthr_f_file->close();
					if ($this->RequestHandler->isAjax()) {
						echo json_encode($document);
						Configure::write('debug', 0);
						$this->autoRender = false;
						//exit(); 
					}else{
						$login= $this->Auth->user();
						$user = array();
						$user['User']['id'] = $login['User']['id'];
						$user['User']['profile_pic'] = $document['Document']['id'];
						$this->User->save($user['User']);
						
						$this->Session->setFlash(__('The document has been saved', true));
						echo '<script type="text/javascript">';
						echo 'window.opener.location = window.opener.location.href; ';
						echo 'window.close(); ';
						echo '</script>';						
						//exit;
					}
					$this->redirect(array('action' => '../users/view'));
					exit;
				} else {
					$this->Session->setFlash(__('The document could not be saved. Please, try again.', true));
				}
			}
		}
	}
	
	function download($id,$size=null){
		$document = $this->Document->findById($id);
	
		$document['Document']['dir']=  Security::cipher($document['Document']['dir'], Configure::read('Security.salt'));
		
		$ngl_file = new File($document['Document']['dir']);
		$ngl_file = json_decode(Security::cipher($ngl_file->read(), Configure::read('Security.salt')),true);
	
		if($ngl_file){
			header('Content-type:' . $ngl_file['Document']['type']);
			header('Content-length:' . $ngl_file['Document']['size']);
			$dvl_file = new File($ngl_file['Document']['dir']);			//directory of image
			//$dvl_contents =$this->encrypt_dvl?Security::cipher($dvl_file->read(), Configure::read('Security.salt')):$dvl_file->read();
			$dvl_contents =$dvl_file->read();
			if(!$size){
				echo $dvl_file->read();
				exit;
			}
			// Get new sizes
			list($width, $height) = getimagesize($ngl_file['Document']['dir']);
			switch($ngl_file['Document']['type']){
				case 'image/png':
				$percent=0.3;
				$source = imagecreatefrompng($ngl_file['Document']['dir']);
				break;
				case 'image/jpeg':case 'image/jpg':
				$percent=0.2;
				$source = imagecreatefromjpeg($ngl_file['Document']['dir']);
				break;
				case 'application/pdf':
				$percent=1;
				$source = imagecreatefromjpeg('img\preview\pdf.jpg');
				list($width, $height) = getimagesize('img\preview\pdf.jpg');
				break;
				default:
				$percent=1;
				$source = imagecreatefromjpeg('img\preview\no.jpg');
				list($width, $height) = getimagesize('img\preview\pdf.jpg');
				break;
			}
			
			
			$newwidth = $width * $percent;
			$newheight = $height * $percent;

			// Load
			$thumb = imagecreatetruecolor($newwidth, $newheight);

			// Resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// Output
			imagejpeg($thumb);
			exit;
		}else{
			echo 'Could not find file';
			exit;
		}
	}
	
	function allow(){
		if (!empty($this->data)) {
			$user = $this->Acl->Aro->findByForeignKey(6);
			
			$aro = new aro();
			$aro->create(); 
			$aro->save(array( 
				 'model'        => 'User', 
				 'foreign_key'    => $this->data['User']['users'], 
				 'parent_id'    => null, 
				 'alias'        => 'User::'.$this->data['User']['users'], 
			));
			
			$data = $this->data['User'];
			$this->Acl->allow('User::'.$this->data['User']['users'], $data['models'], array('create'=>'create','read'=>'read','update'=>'update','delete'=>'delete')); 	
		}
		
		$users = $this->User->find('list',array('fields'=>array('User.id','User.username')));
		$models = array();
		foreach(Configure::listObjects('model') as $m){$models[$m]=$m;}	
		$this->set(compact('users','models'));
	}
	
	function admin_login(){
		$this->redirect(array('controller'=>'users', 'action'=>'login', 'admin'=>false));
	}

	function admin_dashboard(){
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Your webpage trying to address is for autorized SESEPHIL personnel only. <br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
	}
	
	function admin_index(){
		if(!$this->Access->check('User','admin')) die ("HTTP ERROR 401 (UNAUTHORIZED) <br/><br/>Call system administrator for your account verification");
		$this->layout = "admin_default";
	}
	
	function admin_view($username = null) {
		$this->layout = "admin_default";
		if(empty($username)){
			$username=$this->Access->getmy('username');
		}
		$this->set('user', $this->User->findByUsername($username));
	}
	
	
	function all(){
		$users = $this->User->find('all',array('conditions'=>array('User.id NOT'=>1)));
		echo json_encode($users);
		exit;
	}
	
	function admin_assign(){
		if (!empty($this->data)) {
			
			$aro_user =  $this->Acl->Aro->find('first', 
				array( 
					'conditions' => array( 
						'Aro.parent_id !=' => NULL, 
						'Aro.model' => 'User', 
						'Aro.foreign_key' =>  $this->data['User']['user_id']
					)));
				
			if(!empty($aro_user)){ 
				$data['id'] = $aro_user['Aro']['id']; 
				$data['parent_id'] = $this->data['User']['roles']; 
				if($this->Acl->Aro->save($data)){
					
					$user['id'] = $this->data['User']['user_id'];
					if($this->data['User']['roles'] == 2){
						$user['is_admin'] = true;
					}else{
						$user['is_admin'] = false;
					}
					$this->User->save($user);
					$this->redirect(array("controller" => 'users', "action" => 'admin_index'));
				}else{
					$this->Session->setFlash(__("There's a problem updating user role. Please try again.", true));	
					$this->redirect(array("controller" => 'users', "action" => 'admin_index'));
				}
				
			}
		}	
		
	}

	function dashboard_updates(){
		$data = array();
		
		$data['ForDelivery'] = $this->Delivery->find('all',array(
								'recursive'=>0,
								'conditions'=>array('Delivery.date LIKE'=>
												'%2018-02-16%'
												//'%'.date("Y-m-d").'%'
								)
							));
						
		$data['ForPosting'] = $this->Sale->find('all',array(
								'recursive'=>0,
								'conditions'=>array('Sale.is_posted'=>'0'
								)
							));
						
		$data['ForCloning'] = $this->Customer->find('all',array(
								'recursive'=>0,
								'conditions'=>array('Customer.is_posted'=>'0'
								)
							));
						
		//pr($data['ForPosting']);exit;
		
		echo json_encode($data);
		exit;
	}
}