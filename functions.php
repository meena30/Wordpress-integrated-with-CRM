<?php
add_action( 'wpcf7_mail_sent', 'your_wpcf7_mail_sent_function' ); 

function your_wpcf7_mail_sent_function( $contact_form ) {
    $title = $contact_form->title;
    $submission = WPCF7_Submission::get_instance();
    if ( $submission ) {
      $posted_data = $submission->get_posted_data();
    }
      
if ( 'Contact us page' == $title ) {
     
       $firstName = $posted_data['firstname'];
       $lastName  = $posted_data['lastname'];
       $email     = $posted_data['email'];
       $country   = $posted_data['country'];
       $phone   = $posted_data['phone'];
       $description = $posted_data['description'];

    }

    date_default_timezone_set('Asia/Kolkata'); //set IST timezone
    $date=date('Y-m-d');                       // current date
    $time = date( 'H:i:s', current_time( 'timestamp', 1 ) );  // current IST time
   // define("formid","8ebec4ecc04509c38a8db4cca3ffeac4"); //public form id
    define("formid","8ebec4ecc04509c38a8db4cca3ffeac4"); //public form id
     
    $formid=constant("formid");
    define("url","http://democrm.com/modules/Webforms/capture.php"); //  vtiger crm posturl
    $posturl=constant("url");
    $details = array(
      'firstname'  => $firstName,
      'lastname'   => $lastName,
      'email'      => $email,
      'phone'      => $phone,
      'country'    =>$country,
      'description'=>$description,
      'label:Lead_Received_Date'=>$date,
      'label:Lead_Received_Time'=> $time,
      'publicid' => $formid
       
    );//end

  
   $curl_options = array(
    CURLOPT_URL => $posturl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($details),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => false
    );

   $curl = curl_init();  // initiate curl
   curl_setopt_array($curl, $curl_options );
   $result = curl_exec($curl);
   curl_close( $curl );
  
}
?>
