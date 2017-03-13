$(document).ready(function() {
	
	
	$('#summernote').summernote({
		height: 300,                 // set editor height
		minHeight: null,             // set minimum height of editor
		maxHeight: null,             // set maximum height of editor
		focus: false,               // set focus to editable area after initializing summernote
		placeholder:"Type and format your content here...",
		callbacks: {
			onBlur: function() {
				var markupStr = $('#summernote').summernote('code');
				$('#ContentContent').val(markupStr);
			},  
			onInit: function() {
				 var markupStr = $('#ContentContent').val();
				$('#summernote').summernote('code', markupStr);
			}
		}
	});
	

console.log('wew');
});