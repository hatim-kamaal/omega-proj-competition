<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

//$userid=$jsondata->{'userid'};
//$ScheduleId=$jsondata->{'scheduleid'};

$userid='33';
$ScheduleId='1';

if(isset($userid) &&($ScheduleId) )
{

$query = "select distinct User.username, SchedulePushMessage.* from SchedulePushMessage, User where User.user_id=SchedulePushMessage.`SecondUserId` and SchedulePushMessage.ScheduleId = '$ScheduleId' and SchedulePushMessage.`FirstUserId` = '$userid' UNION select distinct User.username, SchedulePushMessage.* from SchedulePushMessage, User where User.user_id = SchedulePushMessage.`SecondUserId`and SchedulePushMessage.ScheduleId = '$ScheduleId' and SchedulePushMessage.`SecondUserId` = '$userid' ";






     $sqlresult = mysql_query($query);

      $count = mysql_num_rows($sqlresult);


       if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $result[] = $data;
       }
      

      $data=array("status"=> 1 ,"msg"=>"Success","requestDetails" =>$result);		
    }
     else
      {
			$data = array("status" => 0, "msg" => "No Messages found");	
			
      }

  }
 
  else
  {
		$data = array("status" => 0, "msg" => " User Id Not Found");	

  }
}
else
{
 $data = array("status" => 0, "msg" => "Request method not accepted");
}
@mysql_close($conn);

/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);


?>