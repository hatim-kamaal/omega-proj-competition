<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$userid=$jsondata->{'userid'};
$champid=$jsondata->{'champid'};
$MatchPlayed=$jsondata->{'MatchPlayed'};
$MatchTillFinal=$jsondata->{'MatchTillFinal'};
$NextOpponent=$jsondata->{'NextOpponent'};
$UserRank=$jsondata->{'UserRank'};
$OpponentRank=$jsondata->{'OpponentRank'};
$PlayRoundUntil=$jsondata->{'PlayRoundUntil'};



/*

$userid='36';
$champid='1';
$MatchPlayed='2';
$MatchTillFinal ='1';
$NextOpponent='1';
$UserRank='33';
$OpponentRank='1';
$PlayRoundUntil='10/07/2015';
*/
if(isset($userid) && isset($champid) && isset($MatchPlayed)  && isset($MatchTillFinal) && isset($NextOpponent) && isset($UserRank)&& isset($OpponentRank) && isset($PlayRoundUntil))

{


     $query="SELECT * FROM `ScheduleMaster` WHERE `userId`='$userid' and `champId`='$champid'";

     $sqlresult = mysql_query($query);

      $count = mysql_num_rows($sqlresult);


       if ($count > 0) 
   {
          $sql="UPDATE `ScheduleMaster` SET `MatchPlayed`='$MatchPlayed',`MatchTillFinal`='$MatchTillFinal',`NextOpponent`='$NextOpponent',`UserRank`='$UserRank',`OpponentRank`='$OpponentRank' WHERE `userId`=33 and `champId`=1";
         $sql1=mysql_query($sql);
          if($sql1)
          {
                $data=array("status"=> 1 ,"msg"=>"Success");	
          }
          else
          {
               $data = array("status" => 0, "msg" => "Failure");
           }	
   }
      
  else
      {

            $qur="INSERT INTO `ScheduleMaster`(`userId`, `MatchPlayed`, `MatchTillFinal`, `NextOpponent`, `UserRank`, `OpponentRank`, `PlayRoundUntil`, `champId`) VALUES ('$userid','$MatchPlayed','$MatchTillFinal','$NextOpponent','$UserRank','$OpponentRank','$PlayRoundUntil','$champid')";
           $qurRes=mysql_query($qur);
           if($qurRes)
           {
                  $data=array("status"=> 1 ,"msg"=>"Success");	

           }
           else
           {
			$data = array("status" => 0, "msg" => "Failure");	
	   }		
      }

  }
 
  else
  {
		$data = array("status" => 0, "msg" => "Failure");	

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