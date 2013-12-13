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
		
// Declare custom time intervals for email reminders
add_filter( 'cron_schedules', 'cron_add_intervals' );
function cron_add_intervals($schedules) {
    $schedules['twodays'] = array(
 		'interval' => 172800,
 		'display' => __('Once Every Two Days')
 	);
 	$schedules['threedays'] = array(
 		'interval' => 259200,
 		'display' => __('Once Every Three Days')
 	);
    $schedules['weekly'] = array(
 		'interval' => 604800,
 		'display' => __('Once Weekly')
 	);
 	$schedules['biweekly'] = array(
 	    'interval' => 1209600,
 	    'display' => __('Once Biweekly')
 	);
 	$schedules['monthly'] = array(
 	    'interval' => 2419200,
 	    'display' => __('Once Monthly')
 	);
    return $schedules;
}

// Schedule daily check upon plugin activation
register_activation_hook( __FILE__, 'amg_event_reminder_install' );
add_action('aer_hook', 'check_days');
function aer_activation() {
    $set_time = 1304431200; // 9:00AM EST
    $file = ABSPATH . "/wp-content/plugins/amg_event_reminder/eventreminder.data";
	if (file_exists($file)) {
	    $ed = read_data();
	    wp_schedule_event($set_time, $ed['schedule'], 'aer_hook');
	} else {
	    wp_schedule_event($set_time, 'daily', 'aer_hook');
	}
}

// Remove scheduled daily checks upon plugin deactivation
register_deactivation_hook(__FILE__, 'amg_event_reminder_uninstall');
function bur_deactivation() {
	wp_clear_scheduled_hook('aer_hook');
}
		
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
						  'form_status' varchar(255) NOT NULL,
						  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
    		$wpdb->query($structure);
	?>
<?php

//tells gravity forms where to send user data
if($_POST['vip_reservation_form'] == 'yes'){
			
			
			add_action("gform_after_submission", "input_fields", 10, 2);
			function input_fields($entry, $form){
    		global $wpdb;


                    $entry["1"] = '$first_name';
					  $entry["2"] = '$last_name'; 
                    $entry["3"] = '$phone';
                    $entry["4"] = '$email';
                    $entry["5"] = '$guest_number';
					  $entry["6"] = '$event_name';
					  $entry["7"] = '$event_date';
					  $entry["8"] = '$form_status';
					  $entry["9"] = '$form_type';
					  
   $SQL = "INSERT INTO vip_registration_event_reminder ( 1, 2, 3, 4, 5, 6, 7, 8, 9) VALUES ( '$first_name', '$last_name' ,'$phone', '$email', '$guest_number', '$event_name','$event_date','form_status','form_type')";
   $wpdb->query($SQL);
   }
}
   ?>
 <?php
   
//Runs event reminder script.


// Check if event is approaching in two days
function check_days() {
	global $wpdb;
	
	$amgreminders = $pd->get_amgreminders();
	$eventdata = $amgreminders = $wpdb->get_results( $wpdb->prepare("
			SELECT *
			FROM {$wpdb->vip_registration_event_reminder}
			WHERE event_date < '{$date}'
				AND form_type = 'guestlist'
				AND post_status = '{$status}'
			ORDER BY event_date ASC
		") );
	return $amgreminders;
	
	foreach( $amgreminders as $amgreminder ){ {
		if( $form_status == 'registered' ){
			$eventdate = strtotime($buser->post_date);
			$timeinterval = ($blogdata[$buser->ID])*86400;
			$timesincelast = time() - $lastpost;
			if ($timesincelast >= $timeinterval) {
				send_ereminders;	}
			}
		}
	}
}

	function send_ereminders(){
		
		//get ereminders
		$pd = new PDER;
		$ereminders = $pd->get_ereminders();
		
		foreach( $amgreminders as $amgreminder ){
		
			$subject = '[Reminder] ' . $amgreminder->$event_name;
			$to = $ereminder->$email;
			$headers = 	"From: AngelMG <{$email}>\r\n" .
						"Content-Type: text/html;\r\n";
			
			$creation_date = date( 'l, F j, Y', strtotime( $amgreminder->event_date ) );
			$message = "<p>This message is a reminder that you are scheduled to attent {$event_name} on {$event_date} </p>\n";
						
			$email_result = wp_mail( $to, $subject, $message, $headers );
			//$email_result = wp_mail( 'ryannmicua@gmail.com', 'Test Reminder', 'message', 'From: Email Reminder <ryannmicua@gmail.com>' );
			
			
			if( $email_result ){//wp_mail() processed the request successfully
				//set post to 'publish' or delete the post
				
			}
			
		}
	}