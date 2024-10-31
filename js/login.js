// using "(function($) { /**/ })(jQuery)" to stoped conflicting with other libraries
(function($) {
		// content
		$(document).ready(function() {
				$('#login_inner').hide();
				$('#login_inner').css('min-height', '0');
				$('#login_bar_control2').show();
				
				$('#login_bar_control').click(function() {
						$('#login_inner').slideToggle('normal');
						if ($('#login_bar_control2').css('display') != 'none'){
							$('#login_bar_control2').css('display', 'none');
						} else {
							$('#login_bar_control2').css('display', '');
						}
				});
		});
})(jQuery)