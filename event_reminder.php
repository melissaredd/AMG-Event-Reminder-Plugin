<?php
/*
		Plugin Name: AMG Event Reminder
		Plugin URI: http://www.angelmg.com
		Description: Plugin to remind vip guestlist registrants of event date.
		Author: Melissa Redd
		Version: 1.0
		Release Date: December 12th, 2013
		Author URI: http://www.angelmg.com
		*/
//add the hooks for install/uninstall and menu.
		register_activation_hook( __FILE__, 'pppt_install' );
		register_deactivation_hook(__FILE__, 'pppt_uninstall');
		
global $wpdb;

//let's create user registration table.
   			$table = $wpdb->prefix."vip_registration_event_reminder";
    		$structure = "CREATE TABLE IF NOT EXISTS `$table` (
						  `first_name` varchar(255) default NULL,
						  `fast_name` varchar(255) default NULL,
						  `phone` int(20) NOT NULL default '0',
						  `email` varchar(255) default NULL,
						  `guest_number` int(20) NOT NULL default '0',
						  'event_name' varchar(255) NOT NULL,
						  'event_date' DATE,
						  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    		$wpdb->query($structure);
	

//Runs event reminder script.


   ?>