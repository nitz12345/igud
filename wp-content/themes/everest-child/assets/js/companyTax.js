(function($){
	$(document).ready(function(){
		$('.company-field-tax a, .company-area-tax a').click(function(e){
			e.preventDefault();
			// Field
			$(this).toggleClass('active');
			var taxId = [];
			$('.company-field-tax a.active').each(function(){
				taxId.push(parseInt($(this).attr('href').replace('#', '')));
			});
			var link = '?field='+taxId.join(',');

			// Area
			taxId = [];
			$('.company-area-tax a.active').each(function(){
				taxId.push(parseInt($(this).attr('href').replace('#', '')));
			});
			link += '&area='+taxId.join(',');
			console.log(taxId);
			window.location.href = link;
		});
	});
})(jQuery);