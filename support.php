<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 

$Issue = $jsondata->{'Issue'};
$Comment = $jsondata->{'Comment'};
$Attachments = $jsondata->{'Attachments'};

/*

$Issue = 'ashish';
$Comment = 'india';
$Attachments = 'Ash1';
*/



       $insertQuery = "INSERT INTO `Support`(`Issue`,`Comment`,`Attachments`) VALUES ('$Issue','$Comment','$Attachments')";			   

      $insertQueryResult = mysql_query($insertQuery);

       if($insertQueryResult)
       {
       $json = array("status" => 1, "msg" => "Success");
       }
       
         else
       {
	  $json = array("status" => 0, "msg" => "Failure");
       }
     
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