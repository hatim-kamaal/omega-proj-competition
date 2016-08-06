<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST")
{
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 
$name = $jsondata->{'name'};
$number = $jsondata->{'number'};
$useremail = $jsondata->{'email'};
$postalCode = $jsondata->{'postalCode'};
/*
$name = 'Amit ghodke';
$number = '9096197505';
$useremail = 'amitkumar.ghodke@gmail.com';
$postalCode = '123';
 */

//simple code for sending mail


 $to = "admin@doctorsoncallgta.com";
// $to = "ezzymufaddal@gmail.com";

 $fullname=$name;
$EmailFrom = "info@omega-solutions.in";
$EmailTo = $to;
$Subject1 = "Appointment Request";
//.$Name.
$Name = Trim(stripslashes($fullname)); 
//$Email = Trim(stripslashes($to)); 
$Subject = Trim(stripslashes($Subject1));
$message="
A new appointment has requested through Mobile app.

Name - ".$Name."
Email - ".$useremail."
Phone no. - ".$number."
Postal Code - ".$postalCode."

Thank you

Doctor's on Call Team 
";
// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= $message;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");


 

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