<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 $round=$jsondata->{'round'};
 $chmapid=$jsondata->{'chmapid'};
 $userid=$jsondata->{'userid'};

//$round=4;
//$chmapid=1;
//$userid=33;
if(isset($round) && isset($chmapid) && isset($userid))
{

for($i=1;$i<=$round;$i++)
{
    $query = "SELECT Results.`resultId`,Results.`UserId`,Results.`OpponentId`,Results.`UserScore`,Results.`OpponentScore`,Results.`Round`,User.username,User.profile_pic,O.username as OppUsername,O.profile_pic as OppUserpic,ImagesTable.UserRegistered,ImagesTable.TotalRounds FROM `Results`,User,User as O,ImagesTable WHERE (`UserId`='$userid' or `OpponentId`='$userid') and `Round`='$i' and `ChampId`='$chmapid' AND Results.UserId=User.user_id And Results.OpponentId=O.user_id and Results.`ChampId`=ImagesTable.imgId";
    $sqlresult = mysql_query($query);
    $count = mysql_num_rows($sqlresult);
    if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $result[] = $data;
       }

      //$data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);		
    }
    else
    {
          $query1 = "SELECT ScheduleRound.`ScheduleRoundId`,ScheduleRound.`UserId`,ScheduleRound.`OpponentId`,ScheduleRound.`RoundId`,ScheduleRound.`Time`,ScheduleRound.`Date`,Round.Round,User.username,User.profile_pic,O.username as OppUsername,O.profile_pic as OppUserpic,ImagesTable.UserRegistered,ImagesTable.TotalRounds FROM `ScheduleRound`,Round,User,User as O, ImagesTable WHERE (`UserId`='$userid' or `OpponentId`='$userid') and `ChampionshipId`='$chmapid' and Round.RoundId='$i' and ScheduleRound.`RoundId`=Round.RoundId and ScheduleRound.UserId=User.user_id and ScheduleRound.Opponentid=O.user_id and ScheduleRound.`ChampionshipId`=ImagesTable.imgId";
          $sqlresult1 = mysql_query($query1);
          $count1 = mysql_num_rows($sqlresult1);
          if ($count1 > 0) 
         {
             while($data1 = mysql_fetch_assoc($sqlresult1))
            {

                    $result[] = $data1;
            }

            // $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);		
         }
         else
         {
             			$data = array("status" => 0, "msg" => "Failure");	

         }

    }
     $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);		

}

}
else
{
			$data = array("status" => 0, "msg" => "Invalid Parameter");	

}
}
else{
 $data = array("status" => 0, "msg" => "Request method not accepted");
}
@mysql_close($conn);

/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);


?>