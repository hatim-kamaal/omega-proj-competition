<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST")
{
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 
$name = $jsondata->{'name'};
$number = $jsondata->{'number'};
$email = $jsondata->{'email'};
$postalCode = $jsondata->{'postalCode'};
/*
$to = "amitkumar.ghodke@omega-solutions.in";
$subject = "Test mail";
$message = "Hello! This is a test email message.";
$from = "ashish.garud@omega-solutions.in";
$headers = "From:" . $from;

$mail=mail($to,$subject,$message,$headers);

 */

 

     $json = array("status" => 1, "msg" => "Success");

}

   else 
  {
      $json = array("status" => 0, "msg" => "Request method not accepted");
  }
 
@mysql_close($conn);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 
?>