$(document).ready(function() {
	
	$('#summernote').summernote({
		minHeight: 220,             // set minimum height of editor
		maxHeight: null,             // set maximum height of editor
		focus: false,               // set focus to editable area after initializing summernote
		placeholder:"Type and format your content here...",
		callbacks: {
			onBlur: function() {
				var markupStr = $('#summernote').summernote('code');
				$('#ProductDescription').val(markupStr);
			},  
			onInit: function() {
				 var markupStr = $('#ProductDescription').val();
				$('#summernote').summernote('code', markupStr);
			}
		}
	});
	


});