<?php 
function print_form(){
 if (!is_user_logged_in()): ?>
<!-- Login START -->	
	<div id="login" class="diy_bar">
		<div id="login_wrap">
			<div id="login_inner" style="display: none;">
				<div id="login_form_holder">
					<form name="loginform" id="loginform" action="<?php echo get_option( 'siteurl' ); ?>/wp-login.php" method="post">
						<?php
						//jamaladd 12/10/2009 3:02PM
						if ( isset( $_REQUEST['redirect_to'] ) ) {
							$redirect_to = $_REQUEST['redirect_to'];
							 
						} else {
							
							 	$redirect_to = selfURL();
							 
						}
						?>
						
						<p>
							<label><?php _e('Login name'); ?>:</label> 
							<input type="text" class="form_input" name="log" id="user_login" value="" />
						</p>
						<p>
							&nbsp;&nbsp;<label><?php _e('Password'); ?>:</label>
							<input type="password" class="form_input" name="pwd" id="user_pass" value="" />
						</p>
						<p class="remove_bottom_margin">
								<input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
								<input type="hidden" name="testcookie" value="1" />
							<input class="header_submit" value="Log In" type="submit">
						</p>
						<p>
								<a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login') ?>" title="<?php _e('Password Lost and Found') ?>"><?php _e('Lost your password?') ?></a>
								<br />
								<?php 
									if ( get_option('users_can_register') )
									{
									?>
									<?php _e('IF you are new then '); ?>					
									<a href="#" class="user_registration" alt="<?php _e('Registration'); ?>" title="<?php _e('Registration'); ?>" >
										<?php _e('register'); ?>
									</a> 
							 		<?php
							 		}
							 	?>
						</p>

					</form>
				</div>
			</div>
			<span id="login_bar_control"><?php _e('Log In'); ?></span>
			<?php 
			if ( get_option('users_can_register') )
			{
			?>
			<span id="login_bar_control2">
					<a class="user_registration"  href="#"><?php _e('Registration'); ?></a>
			</span>
			<?php
			}
			?>
		</div>
	</div>		
<!-- Login END -->
<?php else: ?>
<?php 
	$userObject = wp_get_current_user(); 
	$userName = $userObject->display_name;
	$admin_URI = get_option( 'siteurl' )."/wp-admin/post-new.php";
?>
	<div id="logout" class="diy_bar">
		<span id="login_bar_control" class="logout_bar_control"><?php _e('welcome'); ?> <?php echo $userName; ?>| 
		<a href="<?php echo $admin_URI; ?>">write new post</a> |
		<a href="<?php echo wp_logout_url('index.php'); ?>">LogOut</a>
		</span>
	</div>	
<?php endif; 

}
function selfURL(){ if(!isset($_SERVER['REQUEST_URI'])){ $serverrequri = $_SERVER['PHP_SELF']; }else{ $serverrequri = $_SERVER['REQUEST_URI']; } $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri; }

function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

?>