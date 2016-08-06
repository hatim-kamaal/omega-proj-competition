<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$userid=$jsondata->{'userid'};
$championshipId=$jsondata->{'championshipId'};

//$userid='2';
//$championshipId='1';

if(isset($userid))
{

$sql = "SELECT * FROM `ScheduleRound` WHERE (`UserId`='$userid' OR `OpponentId`='$userid') and `ChampionshipId`='$championshipId'";

 $sqlresult = mysql_query($sql);
    

       while($data = mysql_fetch_assoc($sqlresult))
       {


                  $USERID=$data['UserId'];

                    $OpponentId = $data['OpponentId'];

                    $ChampId= $data['ChampionshipId'];

                    $RoundId= $data['RoundId'];
                  
                    $ScheduleRoundId= $data['ScheduleRoundId'];

       }

	/*	
       $data = array("status" => 1, "msg" => "Success","userid" => $USERID,"OpponentId"=>$SecondUserId,"champid"=>$ChampId,"roundid"=>$RoundId);	


*/

    if($USERID==$userid)
    {

$query = "SELECT `username`,`profile_pic`,`user_Id`,(select username from User Where user_id='$OpponentId') as Opponentname,(select user_id from User Where user_id='$OpponentId') as Opponentid, (select profile_pic from User Where user_id='$OpponentId') as Opponentpic FROM `ScheduleRound`,`User` WHERE `ScheduleRound`.`UserId` = `User`.`user_id` AND `ScheduleRound`.`UserId` ='$USERID'";
   }
else
{
$query = "SELECT `username`,`profile_pic`,`user_Id`,(select username from User Where user_id='$USERID') as Opponentname,(select user_id from User Where user_id='$USERID') as Opponentid, (select profile_pic from User Where user_id='$USERID') as Opponentpic FROM `ScheduleRound`,`User` WHERE `ScheduleRound`.`OpponentId` = `User`.`user_id` AND `ScheduleRound`.`OpponentId` ='$OpponentId'";
}
 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $result[] = $data;
       }
      

      $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result,"ChampId"=>$ChampId,"RoundId"=>$RoundId,"ScheduleRoundId"=>$ScheduleRoundId);		
    }
     else
      {
			$data = array("status" => 0, "msg" => "Failure",$ScheduleRoundId);	
			
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