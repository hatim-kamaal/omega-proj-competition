<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$userid=$jsondata->{'userid'};

$championshipId=$jsondata->{'championshipId'};

$roundId=$jsondata->{'roundId'};


//$userid='33';
//$championshipId='1';
//$roundId='1';

if(isset($userid))
{

$sql = "SELECT * FROM `ScheduleRound` WHERE (`UserId`='$userid' OR `OpponentId`='$userid') and `ChampionshipId`='$championshipId' and `RoundId`='$roundId'";

 $sqlresult = mysql_query($sql);
    

   while($data = mysql_fetch_assoc($sqlresult))
       {


                  $USERID=$data['UserId'];

                    $opponentid = $data['OpponentId'];

                    $scheduleId= $data['ScheduleRoundId'];

                    $RoundId= $data['RoundId'];


       }

      if($USERID==$userid)
    {

$query = "SELECT `username`,`profile_pic`,`user_Id`,(select username from User Where user_id='$opponentid') as Opponentname,(select user_id from User Where user_id='$opponentid') as Opponentid, (select profile_pic from User Where user_id='$opponentid') as Opponentpic FROM `ScheduleRound`,`User` WHERE `ScheduleRound`.`UserId` = `User`.`user_id` AND `ScheduleRound`.`UserId` ='$USERID'";
   }
else
{
$query = "SELECT `username`,`profile_pic`,`user_Id`,(select username from User Where user_id='$USERID') as Opponentname,(select user_id from User Where user_id='$USERID') as Opponentid, (select profile_pic from User Where user_id='$USERID') as Opponentpic FROM `ScheduleRound`,`User` WHERE `ScheduleRound`.`OpponentId` = `User`.`user_id` AND `ScheduleRound`.`OpponentId` ='$opponentid'";
}
 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $result[] = $data;
       }

      $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result,"ScheduleId"=>$scheduleId,"RoundId"=>$RoundId);		
    }
     else
      {
			$data = array("status" => 0, "msg" => "Failure","opp"=>$opponentid);	
			
      }

  }

  
  else
  {
		$data = array("status" => 0, "msg" => "UserID Empty");	

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