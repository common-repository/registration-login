<?php
/*
Plugin Name: registration-login
Plugin URI: http://wordpress.org/extend/plugins/registration-login/
Description: wp-login adds a Top Panel to let users login. To use the plugin add the following line just after the &lt;body&gt; tag in <strong>header.php</strong> file of your current theme <strong>&lt;?php if(function_exists(print_form)) print_form(); ?&gt;</strong>
Author: Md. Jamal Hossain Khan
Version: 1.4
Author URI: http://www.krishe.com/en

Copyright 2010 Md. Jamal Hossain Khan (email : jamal_khanbd@yahoo.com)
 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


// Begin registration-login plugin

$jk_rl = new Registration_login();

class Registration_login{
	
	public function __construct()
	{
		require( dirname(__FILE__) . '/print_form.php' );
		add_filter('plugin_row_meta', array(&$this,'jk_filter_plugin_links'), 10, 2);
		wp_enqueue_script('jquery');
		wp_enqueue_script('login-js', "/".PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/js/login.js');
		wp_enqueue_script('simplemodal-js', "/".PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/js/jquery.simplemodal.js');
		add_action('wp_footer',array(&$this,'print_plugin_script'));
	}
	// Add donate and support information
	function jk_filter_plugin_links($links, $file)
	{
		if ( $file == plugin_basename(__FILE__) )
		{
		$links[] = '<a href="http://www.krishe.com/en/registration-login/">' . __('Support') . '</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=NR7SVN2HFJXX4&lc=GB&item_name=Donation%20for%20Plugin%20Development&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">' . __('Donate') . '</a>';
		}
		return $links;
	}

	function print_plugin_script()
	{?>
	<link rel="stylesheet" href="<?php echo (bloginfo("wpurl").'/'.PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/css/login.css" type="text/css" media="screen" />'."\n"); ?>
	<link rel="stylesheet" href="<?php echo (bloginfo("wpurl").'/'.PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/css/registration.css" type="text/css" media="screen" />'."\n"); ?>
	<script type="text/javascript" language="javascript" src="<?php echo get_settings('siteurl').'/'.PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/js/registration.js.php'?>"></script>
	<?php 
	}

}

?>