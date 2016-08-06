<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 

$ScheduleId = $jsondata->{'ScheduleId'};

$FirstUserId = $jsondata->{'FirstUserId'};

$SecondUserId = $jsondata->{'SecondUserId'};

$PushDate = $jsondata->{'PushDate'};

$PushTime = $jsondata->{'PushTime'};

$Message = $jsondata->{'Message'};

$Status = $jsondata->{'Status'};




/*
$ScheduleId ='3';
$FirstUserId = '2';

$SecondUserId='33';

$PushDate='10/12/2016';

$PushTime='20.00PM';

$Message='Hi';
$Status='Waitiong';
*/
    


 if(isset($ScheduleId) &&  isset($FirstUserId) && isset($SecondUserId) && isset($PushDate) &&  isset($PushTime) && isset($Message) && isset($Status))
{
$insertQuery= "INSERT INTO `SchedulePushMessage`(`ScheduleId`, `FirstUserId`, `SecondUserId`, `PushDate`, `PushTime`, `Message`, `Status`) VALUES ('$ScheduleId','$FirstUserId','$SecondUserId','$PushDate','$PushTime','$Message','$Status')";

		   
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
	  $json = array("status" => 0, "msg" => "Invalid Parameter");

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