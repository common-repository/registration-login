<?php
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-load.php');
header("Cache-Control: must-revalidate");
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 3600 * 24 * 30) . ' GMT');
header('Content-Type: text/javascript');
?>(function($){
	$(document).ready(function () {
	<?php 
		if ( get_option('users_can_register') )
		{
		?>
		$('.user_registration').click(function (e) {
			e.preventDefault();
			// load the contact form using ajax
			$.get('<?php echo( plugins_url('registration-login/registration.php'))?>', function(data){
				// create a modal dialog with the data
				$(data).modal({
					closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
					position: ["15%",],
					overlayId: 'contact-overlay',
					containerId: 'contact-container',
					onOpen: contact.open,
					onShow: contact.show,
					onClose: contact.close
				});
			});
		});
	<?php 
	}
	?>
	});
	
	var contact = {
		message: null,
		open: function (dialog) {
			// add padding to the buttons in firefox/mozilla
			if ($.browser.mozilla) {
				$('#contact-container .contact-button').css({
					'padding-bottom': '2px'
				});
			}
			// input field font size
			if ($.browser.safari) {
				$('#contact-container .contact-input').css({
					'font-size': '.9em'
				});
			}
	
			// dynamically determine height
			var h = 280;
			if ($('#contact-subject').length) {
				h += 26;
			}
			if ($('#contact-cc').length) {
				h += 22;
			}
	
			var title = $('#contact-container .contact-title').html();
			$('#contact-container .contact-title').html('<?php _e("loading");?>...');
			dialog.overlay.fadeIn(200, function () {
				dialog.container.fadeIn(200, function () {
					dialog.data.fadeIn(200, function () {
						$('#contact-container .contact-content').animate({
							height: h
						}, function () {
							$('#contact-container .contact-title').html(title);
							$('#contact-container form').fadeIn(200, function () {
								$('#contact-container #contact-name').focus();
	
								$('#contact-container .contact-cc').click(function () {
									var cc = $('#contact-container #contact-cc');
									cc.is(':checked') ? cc.attr('checked', '') : cc.attr('checked', 'checked');
								});
	
								// fix png's for IE 6
								if ($.browser.msie && $.browser.version < 7) {
									$('#contact-container .contact-button').each(function () {
										if ($(this).css('backgroundImage').match(/^url[("']+(.*\.png)[)"']+$/i)) {
											var src = RegExp.$1;
											$(this).css({
												backgroundImage: 'none',
												filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' +  src + '", sizingMethod="crop")'
											});
										}
									});
								}
							});
						});
					});
				});
			});
		},
		show: function (dialog) {
			$('#contact-container .contact-send').click(function (e) {
				e.preventDefault();
				// validate form
				if (contact.validate()) {
					var msg = $('#contact-container .contact-message');
					msg.fadeOut(function () {
						msg.removeClass('contact-error').empty();
					});
					$('#contact-container .contact-title').html('Sending..');
					//$('#contact-container form').fadeOut(200);
					$('#contact-container .contact-content').animate({
						height: '280px'
					}, function () {
						$('#contact-container .contact-loading').fadeIn(200, function () {
							$.ajax({
								url: '<?php echo( plugins_url('registration-login/registration.php'))?>',
								data: $('#contact-container form').serialize() + '&action=send',
								type: 'post',
								cache: false,
								dataType: 'html',
								success: function (data) {
									/*
									$('#contact-container .contact-loading').fadeOut(200, function () {
										$('#contact-container .contact-title').html('Thank you!');
										msg.html(data).fadeIn(200);
									});
									*/	$('#contact-container .contact-loading').fadeOut(200);
											if (data=='username') {
															$('#contact-container .contact-content').animate({ height: '280px' }, function () {
															$('#contact-container .contact-message').html($('<div class="contact-error"></div>')
															.append('Login Name already exist.')).fadeIn(200);
															$('#contact-container .contact-title').html('Registration');
													});													
													
											} else if (data=='email') {
															$('#contact-container .contact-content').animate({ height: '280px' }, function () {
															$('#contact-container .contact-message').html($('<div class="contact-error"></div>')
															.append('E-mail address already exist.')).fadeIn(200);
															$('#contact-container .contact-title').html('Registration');
													});														
											} else {
													var msg = $('#contact-container .contact-message');
													msg.fadeOut(function () {
															msg.removeClass('contact-error').empty();
															$('#contact-container form').fadeOut(200);
															$('#contact-container .contact-content').animate({ height: '80px' }, function () {
																	$('#contact-container .contact-title').html('Thank you');
																	msg.html(data).fadeIn(200); 
															});
													});
											}	
								},
								error: contact.error
							});
						});
					});
				}
				else {
					if ($('#contact-container .contact-message:visible').length > 0) {
						var msg = $('#contact-container .contact-message div');
						msg.fadeOut(200, function () {
							msg.empty();
							contact.showError();
							msg.fadeIn(200);
						});
					}
					else {
						$('#contact-container .contact-message').animate({
							height: '30px'
						}, contact.showError);
					}
					
				}
			});
		},
		close: function (dialog) {
			$('#contact-container .contact-message').fadeOut();
			$('#contact-container .contact-title').html('Good bye...');
			$('#contact-container form').fadeOut(200);
			$('#contact-container .contact-content').animate({
				height: 40
			}, function () {
				dialog.data.fadeOut(200, function () {
					dialog.container.fadeOut(200, function () {
						dialog.overlay.fadeOut(200, function () {
							$.modal.close();
						});
					});
				});
			});
		},
		error: function (xhr) {
			alert(xhr.statusText);
		},
		validate: function () {
				contact.message = '';
				var username = $('#contact-container #username').val();
				if (!username) {
					contact.message += ' Need valid usernane.<br/> ';
				}
		
				var email = $('#contact-container #user_email').val();
				if (!email) {
					contact.message += ' Need valid email  ';
				}
				else {
					if (!contact.validateEmail(email)) {
						contact.message += 'Not a valid user name; ';
					}
				}
			

	
			if (contact.message.length > 0) {
				return false;
			}
			else {
				return true;
			}
		},
		validateEmail: function (email) {
			var at = email.lastIndexOf("@");
	
			// Make sure the at (@) sybmol exists and  
			// it is not the first or last character
			if (at < 1 || (at + 1) === email.length)
				return false;
	
			// Make sure there aren't multiple periods together
			if (/(\.{2,})/.test(email))
				return false;
	
			// Break up the local and domain portions
			var local = email.substring(0, at);
			var domain = email.substring(at + 1);
	
			// Check lengths
			if (local.length < 1 || local.length > 64 || domain.length < 4 || domain.length > 255)
				return false;
	
			// Make sure local and domain don't start with or end with a period
			if (/(^\.|\.$)/.test(local) || /(^\.|\.$)/.test(domain))
				return false;
	
			// Check for quoted-string addresses
			// Since almost anything is allowed in a quoted-string address,
			// we're just going to let them go through
			if (!/^"(.+)"$/.test(local)) {
				// It's a dot-string address...check for valid characters
				if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
					return false;
			}
	
			// Make sure domain contains only valid characters and at least one period
			if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(".") === -1)
				return false;	
	
			return true;
		},
		showError: function () {
			$('#contact-container .contact-message')
				.html($('<div class="contact-error"></div>').append(contact.message))
				.fadeIn(200);
		}
	};
})(jQuery);