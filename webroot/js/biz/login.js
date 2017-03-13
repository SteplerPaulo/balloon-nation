$(document).ready(function(){

	//POPOVER INITIALIZATION
	$('#UserPassword').popover({content:'Caps Lock is on',placement:'bottom',trigger:'manual'});
		
});
//PASSWORD CAPSLOCK EVENT HANDLER
function PasswordCapsLock(e){
	$('#UserPassword').popover('hide');
	kc = e.keyCode?e.keyCode:e.which;
	sk = e.shiftKey?e.shiftKey:((kc == 16)?true:false);
	
	if(((kc >= 65 && kc <= 90) && !sk)||((kc >= 97 && kc <= 122) && sk)){
		$('#UserPassword').popover('show');
	}
}
