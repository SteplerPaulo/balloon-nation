$(document).ready(function() {
 	$(document).on('click','#SendButton',function(e){
		var empty = false;
        $('form input,form textarea').each(function() {
            if ($(this).val() == '') empty = true;
        });
        if (empty) $("#SendingModal").modal();
	});
});