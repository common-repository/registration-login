<?php
require( '../../../wp-load.php' );
require_once( ABSPATH . WPINC . '/registration.php');
function registrationContent() {
	// Send back the contact form HTML
	echo "<div style='display:none'>
		<div class='contact-top'></div>
		<div class='contact-content'>
			<h1 class='contact-title'>".__("Register For This Site")."</h1>
			<div class='contact-loading' style='display:none'></div>
			<div class='contact-message' style='display:none'></div>
			<form action=". site_url('wp-login.php?action=register', 'login_post') ." 
						method='post' 
						style='display:none'>";
				// Registration content START
		?>
				<p>
					<label><?php _e('Login Name') ?>:</label><br />
					<input type="text" name="username" id="username" class="input" value="<?php echo $username; ?>" size="20" tabindex="10" />
				</p>
				<p>
					<label><?php _e('E-mail') ?>:</label><br />
					<input type="text" name="user_email" id="user_email" class="input" value="<?php echo $user_email; ?>" size="25" tabindex="20" />
				</p>		
				<br />
				<?php do_action('register_form'); ?>	
		
		<?php
		// Registration content END
		
		echo "<p>
				<button type='submit' class='contact-send contact-button' tabindex='1006'>Send</button>
				<button type='submit' class='contact-cancel contact-button simplemodal-close' tabindex='1007'>Cancel</button>
				</p>
			</form>
		</div>

	</div>";
}
$action = isset($_POST["action"]) ? $_POST["action"] : "";
if (empty($action)) {
	registrationContent();
}
else if ($action == "send") {
	
	$username   = isset($_POST["username"]) ? $_POST["username"] : "";	
	$user_email = isset($_POST["user_email"]) ? $_POST["user_email"] : "";

	if ($username) {
			// check duplicate user
			if (username_exists($username)) {
					echo "username";
					exit;
			}
	}
	if ($user_email) {
			// check duplicate e-mail
			if (email_exists($user_email)) {
					echo "email";
					exit;
			}
	}	
	
	$user_pass = wp_generate_password();
	$user_id = wp_create_user( smcf_filter($username), $user_pass, smcf_filter($user_email) );
	
	// make sure the token matches
	if ($user_id) {
		wp_new_user_notification($user_id, $user_pass);
	_e("Registration complete. Please check your e-mail");
	}
	else {
		_e("Registration is not complete. Please contact site admin");
	}

}

// Remove any un-safe values to prevent email injection
function smcf_filter($value) {
	$pattern = array("/\n/","/\r/","/content-type:/i","/to:/i", "/from:/i", "/cc:/i");
	$value = preg_replace($pattern, "", $value);
	return $value;
}

exit;

?>