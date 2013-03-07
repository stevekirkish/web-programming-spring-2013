<?php
//
// PHP Handler: Send Reservation Form Data to E-Mail Address
//

// Receive data from FORM via JS file
  $clientname = ($_POST['clientname']); //Visible in Network-Contact tab on Chrome Inspect Tool
  $email = ($_POST['email']);
  $phone = ($_POST['phone']);
  $arrival = ($_POST['arrival']);
  $departure = ($_POST['departure']);
  $requests = ($_POST['requests']);
  
// Email set up
  $to = "sdkirkish@yahoo.com";	// Recipient for Contact Email
  $subject = "Reservation Form";
  
  $docHead = '<!DOCTYPE HTML>/r/n<html>/r/n<head>/r/n<meta charset="utf-8">/r/n</head>';
  $docBody = "<body>/r/n";
  $docEnd = "</body>/r/n</html>/r/n";
  
  $head = '<p style="font-size:larger"><b>Dew Drop Inn Reservation Request</b></p><br /><br />';
  $intro = '<p>'.$clientname.' would like to make a reservation.</p><br />';
  $contentName = '<p><b>Client Name: </b>' . $clientname . '</p><br />';
  $contentEmail = '<p><b>Client E-mail: </b>' . $email . '</p><br />';
  $contentPhone = '<p><b>Client Phone: </b>' . $phone . '</p><br />';
  $contentArrive = '<p><b>Arrival Date: </b>' . $arrival . '</p><br />';
  $contentDepart = '<p><b>Departure Date: </b>' . $departure . '</p><br />';
  $contentRequests = '<p><b>Requests: </b>';
  foreach ($requests as $value) {
	  $contentRequests .= $value . ", ";
  }
  $contentRequests = rtrim($contentRequests, ", ");
  
  
//  $message = $docHead . $head . $docBody . $intro . $contentName . $contentEmail . $docEnd;
  $message = $head . $intro . $contentName . $contentEmail . $contentPhone . $contentArrive . $contentDepart . $contentRequests;
  
  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= 'From: skirkish@student.santarosa.edu' . "\r\n" .
    'Reply-To: sdkirkish@yahoo.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
  mail($to, $subject, $message, $headers);


?>