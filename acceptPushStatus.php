<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 


$FirstUserId= $jsondata->{'FirstUserId'};
$SecondUserId= $jsondata->{'SecondUserId'};
$PushDate = $jsondata->{'PushDate'};
$PushTime= $jsondata->{'PushTime'};
$ScheduleId= $jsondata->{'ScheduleId'};
$status= 'ACCEPT';
/*
$FirstUserId='33';
$SecondUserId='1';
$PushDate='10-12-2016';
$PushTime='10.12';
$ScheduleId='1';
*/


  
if(isset($FirstUserId) &&  isset($SecondUserId) && isset($PushDate) && isset($PushTime) && isset($ScheduleId))
 {

$sql = "UPDATE `SchedulePushMessage` SET `Status`='$status' WHERE `FirstUserId`= '$FirstUserId' AND `SecondUserId`='$SecondUserId' AND `PushDate`='$PushDate' AND `PushTime`='$PushTime' AND `ScheduleId`='$ScheduleId'";

$sqlresult=mysql_query($sql);



  if($sqlresult)
  {

   $query = "UPDATE `ScheduleRound` SET `Status`='$status' WHERE  `UserId`= '$FirstUserId' AND `OpponentId`='$SecondUserId' AND `Date`='$PushDate' AND `Time`='$PushTime'";
   

    $sqlresult1=mysql_query($query);

    if($sqlresult1)
    {
        $json=array("status" =>1,"message"=>"Success");

    }
    else
    {
       $json=array("status" =>0,"message"=>"Failure To Set Round");

    }
  }
   else
   {
   $json=array("status" =>0,"message"=>"Failure");

   }

 } 
  else
  {
   $json=array("status" =>0,"message"=>"Parameters are empty");

  }
}
   else 
  {
      $json = array("status" => 0, "message" => "Request method not accepted");
  }

 
@mysql_close($conn);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 
?>