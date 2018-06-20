(function ($) {
	$(document).ready(function () {
		$('.homepage-list-grid').slick({
			rtl: true,
			speed: 500,
			slidesToShow: 3,
			slideToScroll: 1,
			infinite: true,
			dots: true,
			autoplay: true,
			adaptiveHeight: true,
			responsive: [
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}
			]
		});
	});
})(jQuery);