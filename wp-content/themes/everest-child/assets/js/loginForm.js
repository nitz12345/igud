(function ($) {
    $(document).ready(function () {
        $('.login_form').submit(function (e) {
            e.preventDefault();
            var data = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'matat_login',
                    data: data
                },
							  dataType: 'json',
                success: function (response) {
									console.log(response.message);
                   if(response.success){
										 window.location.href = response.message;
                   } else{
                       $('.error').html(response.message).removeClass('hidden');
                   }
                }
            });
            return false;
        });
    });
})(jQuery);
