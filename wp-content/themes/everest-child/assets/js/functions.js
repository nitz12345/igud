(function($){
	$(document).ready(function(){
		if($('.open-sharing-options').length){
			$('.open-sharing-options').click(function (e) {
				e.preventDefault();
				$(this).closest('.pull-right').toggleClass('active');
				$(this).next('.sharing-options').toggle();
			});
		}

		if($('.load-more-companies').length){
			$('.load-more-companies').click(function(e){
				e.preventDefault();
				var el = this;
				var offset = $('.companies-archive-wrapper .company-container').length;
				var archive = $(this).attr('data-archive');
				$.post({
					url: ajax_object.ajax_url,
					data: {action: 'loadMoreCompanies', archive: archive, offset: offset, taxId: $(el).attr('data-tax_id')},
					success: function(result){
						console.log(result);
						if(result.error === 'done')
							$(el).remove();
						$('.companies-archive-wrapper .row').append(result.result);
					},
					dataType: 'json'
				});
			});
		}

		if($('.company-container-full').length){
			$('.company-container-full').click(function(e){
				if($(e.target).hasClass('company-container-full')){
					location.href = $(this).data('href');
				}
			});
		}
	});
})(jQuery);