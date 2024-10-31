=== registration-login ===
Contributors: jamalk
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=NR7SVN2HFJXX4&lc=GB&item_name=Donation%20for%20Plugin%20Development&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: Ajax, Top Panel, Toppanel, plugin, admin, registration,login 
Requires at least: 2.7
Tested up to: 3.05
Stable tag: 1.4

Add a JavaScript loaded widget to your Wordpress theme so user can login, registers without leaving the current page.

== Description ==

Add a JavaScript loaded widget to your Wordpress theme so user can login, registers without leaving the current page.
For more information about the plugin please see: http://www.krishe.com/en/registration-login

== Installation ==

1. Upload `registration-login` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the following line just after the <body> tag in header.php file of your current theme 
`<?php if(function_exists(print_form)) print_form(); ?>`

== Frequently Asked Questions ==

== Screenshots ==
1. Registration login link
2. Registration form
3. Login form

== Changelog ==
= 1.4 =
* After login user stay in current page instead of redirect to the homepage. 

= 1.3 =
* Show only logged in form when admin disabled anyone can register option. 

= 1.2 =
* Update php code open function to class function 
* Update suppor and donation link

= 1.1 =
* Fixed broken layout for Internet Explorer.

= 1.0 =
* Initial versiono