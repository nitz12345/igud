(function($){
	$(document).ready(function(){
		$('#import-companies').submit(function(e){
			e.preventDefault();
			$('.import-companies-spinner, .import-companies-text').show();
			var formData = new FormData(this);
			$.ajax({
				type: 'POST',
				url: ajaxurl,
				data: formData,
				dataType: 'json',
				success: function(res){
					$('.import-companies-spinner, .import-companies-text').hide();
					$('#csv_file').val('');
					$('#category-select').val(-1);
					console.log(res);
					alert('החברות יובאו בהצלחה!');
				},
				cache: false,
				contentType: false,
				processData: false
			});
			return false;
		})
	});
})(jQuery);