<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$numberOfPlayers=$jsondata->{'numberOfPlayers'};
//$userid=1;
//$numberOfPlayers='3';

if(isset($numberOfPlayers))
{

$query = "SELECT * FROM `masterChampRound` WHERE `MinimumLimt`<='$numberOfPlayers' AND `MaximumLimit`>='$numberOfPlayers'";

 $sqlresult = mysql_query($query);

 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                 //   $result[] = $data;
               $Rounds=$data['Rounds'];
               $MinLimt=$data['MinimumLimt'];
               $MaxLimt=$data['MaximumLimit'];




       }

      $data=array("status"=> 1 ,"msg"=>"Success","Rounds"=>$Rounds,"MinimumLimit"=>$MinLimt,"MaximumLimit"=>$MaxLimt);		
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