<?php
if($_POST['vip_reservation_form'] == 'yes'){
			
			
			add_action("gform_after_submission", "input_fields", 10, 2);
			function input_fields($entry, $form){
    		global $wpdb;


                    $entry["first_name"] = '$first_name';
					  $entry["last_name"] = '$last_name'; 
                    $entry["phone"] = '$phone';
                    $entry["email"] = '$email';
                    $entry["guest_number"] = '$guest_number';
					  $entry["event_name"] = '$event_name';
					  $entry["event_date"] = '$event_date';
					  
   $SQL = "INSERT INTO vip_registration_event_reminder ( first_name, last_name, phone, email, guest_number, event_name, event_date) VALUES ( '$first_name', '$last_name' ,'$phone', '$email', '$guest_number', '$event_name','$event_date')";
   $wpdb->query($SQL);
   }
}
   ?>