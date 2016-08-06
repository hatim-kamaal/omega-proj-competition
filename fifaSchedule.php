<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$userId=$jsondata->{'userId'};

//$userId=33;
 
  $query = "SELECT * FROM `ScheduleMaster` WHERE `userId`= '$userId'";

 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                 //   $result[] = $data;

             $userId=$data['userId'];

             $MatchPlayed=$data['MatchPlayed'];
             $MatchTillFinal=$data['MatchTillFinal'];
             $NextOpponent=$data['NextOpponent'];

             $UserRank=$data['UserRank'];
             $OpponentRank=$data['OpponentRank'];
             $PlayRoundUntil=$data['PlayRoundUntil'];

       }

    //  $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);	

     $data=array("status"=> 1 ,"msg"=>"Success","UserId"=>$userId,"MatchesPlayed"=>$MatchPlayed,"MatchTillFinal"=>$MatchTillFinal,"NextOpponent"=>$NextOpponent,"UserRank"=>$UserRank,"OpponentRank"=>$OpponentRank,"PlayRoundUntil"=>$PlayRoundUntil);	
	
	
    }
     else
      {
			$data = array("status" => 0, "msg" => "Failure");	
			
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