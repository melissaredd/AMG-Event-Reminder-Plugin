<?php
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
					  
   $SQL = "INSERT INTO vip_registration_event_reminder ( 1, 2, 3, 4, 5, 6, 7) VALUES ( '$first_name', '$last_name' ,'$phone', '$email', '$guest_number', '$event_name','$event_date')";
   $wpdb->query($SQL);
   }
}
   ?>