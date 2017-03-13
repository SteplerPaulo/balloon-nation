<?php 
class AccessComponent extends Object{ 
    var $components = array('Acl', 'Auth'); 
    var $user; 
  
    function startup(){ 
        $this->user = $this->Auth->user(); 
    } 
	function check($aco, $action='*'){ 
		if(!empty($this->user) && $this->Acl->check('User::'.$this->user['User']['id'], $aco, $action)){ 
			return true; 
		} else { 
			return false; 
		} 
	}
	
	function checkHelper($aro, $aco, $action = "*"){ 
		App::import('Component', 'Acl'); 
		$acl = new AclComponent(); 
		return $acl->check($aro, $aco, $action); 
	}
	
	function getmy($what){ 
		return !empty($this->user) && isset($this->user['User'][$what]) ? $this->user['User'][$what] : false; 
	}
} 
?>