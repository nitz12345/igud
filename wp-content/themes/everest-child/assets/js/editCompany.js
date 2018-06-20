(function ($) {
	$(document).ready(function () {
		$('.edit .pull-left .company-type a').click(function(e){
			e.preventDefault();
			var scrollTop = $($(this).attr('href')).offset().top - 92;
			$('body, html').animate({
				scrollTop: scrollTop
			}, 1000);
		});

		$('.update-company').click(function(){
			$(this).props('disabled', true);
		});
		$(document).on('click', '#company-logo > span', function (e) {
			$('[name="logo_file"]').click();
		});
		$('input[name="logo_file"]').change(function (e) {
			if (this.files && this.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#company-logo')
						.html("<a href='#' class='remove-logo'><i class='fa fa-times'" +
							" aria-hidden='true'></i></a><img src='" + e.target.result + "'/>");
				};

				reader.readAsDataURL(this.files[0]);
			}
		});
		$(document).on('click', '.remove-logo', function (e) {
			e.preventDefault();
			$('#logo-file-input').val('');
			$('#company-logo').html('<span>לחץ כאן להוספת לוגו</span>');
		});

		// Staff images
		$('.staff-placeholders input[type="file"]').change(function (e) {
			var el_parent = $(this).closest('.staff-placeholders');
			if (this.files && this.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					if ($(' .staff-image-wrapper', el_parent).find('img')) {
						$(' .staff-image-wrapper', el_parent).find('img').remove();
						$(' .staff-image-wrapper', el_parent).find('a.remove-staff-image').remove();
					}
					$(' .staff-image-wrapper', el_parent).prepend("<img src='" + e.target.result + "'/>");
					$(' .staff-image-wrapper', el_parent).prepend("<a href='#' class='remove-staff-image'>X</a>");
					$(el_parent).find('.staff_image_change').val('1');
				}

				reader.readAsDataURL(this.files[0]);
			}
		});

		$(document).on('click', '.remove-staff-image', function (e) {
			e.preventDefault();
			$(this).closest('.staff-placeholders').find('.staff_image_change').val('1');
			$(this).parent().find('img').remove();
			$(this).remove();
		});

		$(document).on('click', '.gallery-placeholder.no-img', function(e){
			var itemNum = $(this).attr('data-number');
			$('input[name="gallery-item-'+itemNum+'"]').click();
		});

		$('.gallery-images').on('change', '.gallery-items-input', function (event) {
			var el = $(this);
			var placeHolder = $(el).prev('.gallery-placeholder');
			console.log(placeHolder);
			if (this.files && this.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$(placeHolder).removeClass('no-img').html("<img src='"+e.target.result+"' />");
					$(el).parent().append("<a href='#' class='remove-gallery-image'><i class='fa fa-times'></i></a>");
				};
				reader.readAsDataURL(this.files[0]);
			}
		});

		$('.gallery-images').on('click', '.remove-gallery-image', function (e) {
			e.preventDefault();
			var el = $(this).parent().find('.gallery-placeholder');
			var itemNum = $(el).attr('data-number');
			$(el).addClass('no-img').text('בחר תמונה').find('img').remove();
			$(el).parent().append("<input type='file' class='gallery-items-input' name='gallery-item-"+itemNum+"' />");
			$(this).remove();
		});

		$(document).on('click', '.remove-video', function (e) {
			e.preventDefault();
			$(this).closest('.company-video-text-wrapper').remove();
		});

		$(document).on('click', '#add-video', function (e) {
			e.preventDefault();
			$('.company-videos > .col-md-12').append("<div class=\"company-video-text-wrapper\">\n" +
				"\t\t\t\t\t\t\t<a href=\"#\" class=\"remove-video\" role=\"link\"><i class=\"fa fa-times\"></i></a>\n" +
				"\t\t\t\t\t\t\t<input type=\"text\" class=\"company-video\" name=\"company-video[]\" placeholder=\"הכנס סרטון מיוטיוב\">\n" +
				"\t\t\t\t\t\t</div>");
		});

		// Company sub category
		$('#category-select').change(function () {
			$.post(ajax_object.ajax_url, {action: 'getSubCategories', chosen_cat: $(this).val(), select: true}, function (res) {
				$('.company-sub-cat').html(res);
			});
			$.post(ajax_object.ajax_url, {action: 'getBackgroundOptions', chosen_cat: $(this).val()}, function (res) {
				if(res) {
					var images = "";
					$.each(res, (function () {
						console.log(this);
						images += "<div class='col-md-3'><img data-img_id='"+this.ID+"'" +
							"src='" + this.sizes.medium + "'" +
							"data-full_size='"+this.url+"' alt=''/></div>";
					}));
					$('.choose-background-image .row').html('<div class="row">'+images+'</div>');
				} else{
					$('.choose-background-image .row').html("<div class='col-md-12'>אנא בחר קטגוריה</div>");
				}
			}, "json");
		});

		$('.choose-background-image').on('click', '.col-md-3 img', function(e){
			var fullSize = $(this).attr('data-full_size');
			$('.company-top-image-wrapper img').replaceWith("<img src='"+fullSize+"' alt='' />");
			$('[name="background_image"]').val($(this).attr('data-img_id'));
			$('.choose-background-image').slideToggle();
		});

		$('.company-choose-image-overlay').click(function(){
			$('.choose-background-image').slideToggle();
		});

		$('.edit-company').submit(function(e){
			$('.border-red').removeClass('border-red');
			$(' .required', this).each(function(){
				if(!$(this).val()){
					e.preventDefault();
					$(this).addClass('border-red');
					var scrollTop = $(this).offset().top - 90;
					$('html, body').animate({
						scrollTop: scrollTop
					});
					return false;
				}
			});
		});
	});
})(jQuery);