<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 $champid=$jsondata->{'champid'};
 $userid =$jsondata->{'userid'};
/*
$champid=1;
$userid=33;
*/

if(isset($champid) && isset($userid))
{
  $query = mysql_query("SELECT max(Round.Round) as CurrentRound FROM `ScheduleRound`,Round WHERE ScheduleRound.RoundId=Round.RoundId and (ScheduleRound.UserId='$userid' or ScheduleRound.OpponentId='$userid') and `ChampionshipId`='$champid'");

 
 //$sqlresult = mysql_query($query);
 $count = mysql_num_rows($query);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($query))
       {

                    $result = $data['CurrentRound'];
       }
        $query2 = mysql_query("select RoundId from Round where Round='$result' and `ChampId`='$champid'");
        $count2 = mysql_num_rows($query2);
        if($count2 > 0)
        {
             while($data1 = mysql_fetch_assoc($query2))
             {

                    $roundId= $data1['RoundId'];
             }
                   $data=array("status"=> 1 ,"msg"=>"Success","CurrentRound"=>$result,"RoundId"=>$roundId);		

        }
        else
        {
               	$data = array("status" => 0, "msg" => "Failure");	

        }

    }
     else
      {
			$data = array("status" => 0, "msg" => "Failure");	
			
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