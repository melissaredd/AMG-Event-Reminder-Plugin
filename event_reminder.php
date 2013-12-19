<?php

/***********

		Plugin Name: AMG Event Reminder

		Plugin URI: http://www.angelmg.com

		Description: Reminds users of their event registration.

		Author: Melissa Redd

		Version: 2.0

		Release Date: December 18th, 2013

		Author URI: http://www.angelmg.com

		***********/

	

function event_reminder_table()

{

      	global $wpdb;

 

	

	if($wpdb->get_var("show tables like event_reminder_table") != 'event_reminder_table') 

	{

		$sql = "CREATE TABLE event_reminder_table (

		id mediumint(9) NOT NULL AUTO_INCREMENT,

		first_name tinytext NOT NULL,

		last_name tinytext NOT NULL,

		phone tinytext NOT NULL,

		email tinytext NOT NULL,

		guest_number tinytext NOT NULL,

		event_name tinytext NOT NULL,

		event_date tinytext NOT NULL,

		form_status tinytext NOT NULL,

		form_type tinytext NOT NULL,

		UNIQUE KEY id (id)

		);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);

	}

}

// this hook will cause our creation function to run when the plugin is activated

register_activation_hook( __FILE__, 'event_reminder_table' );



add_action("gform_after_submission", "push_fields", "test", 10, 2);



function push_fields($entry, $form){



if($_POST["input_7"] == 'submitted'){	

global $wpdb;



$firstName = $entry["1"];

$lastName = $entry["2"];

$phone = $entry["3"];

$email = $entry["4"];

$guestNumber = $entry["5"];

$eventName = $entry["6"];

$eventDate = $entry["9"];

$form_status = $entry["7"];

$form_type = $entry["8"];





$insertdata = "INSERT INTO event_reminder_table (first_name, last_name, phone, email, guest_number,event_name,event_date,form_status, form_type) VALUES ('$firstName','$lastName', '$phone', '$email', '$guestNumber', '$eventName', '$eventDate', '$form_status', '$form_type')";



$wpdb->query($insertdata);

}

}

function test () {
	global $wpdb;
		$active_rows = $wpdb->get_results(
		"SELECT * FROM event_reminder_table WHERE event_date >= NOW() - INTERVAL 2 Day"
	);

	foreach ($active_rows as $active_row){
	
	$subject = '[Reminder] ' . $active_row->event_name;
			$to = $active_row->email;
			$message = "<p>This message is a reminder that you are scheduled to attend";
			wp_mail( $to, $subject, $message);
		
	}
}

