<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 $champid=$jsondata->{'champid'};
 $userid =$jsondata->{'userid'};
 $opponentid =$jsondata->{'opponentid'};
 $round =$jsondata->{'round'};
/*
$champid=1;
$userid=33;
$opponentid=2;
$round=1;
*/
if(isset($champid) && isset($userid) && isset($opponentid) && isset($round))
{
  $query = mysql_query("SELECT * FROM `Results` WHERE (`UserId`='$opponentid' OR `UserId`='$userid') AND (`OpponentId`='$opponentid' OR `OpponentId`='$userid') AND `Round`='$round' AND `ChampId`='$champid'");

 
 //$sqlresult = mysql_query($query);
 $count = mysql_num_rows($query);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($query))
       {

                    $result[] = $data;
       }

      $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);		
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