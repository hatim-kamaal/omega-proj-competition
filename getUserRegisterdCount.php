<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 $champid=$jsondata->{'champid'};
 
//$champid=4;

if(isset($champid))
{
  $query = "SELECT count(*) as userRegistered FROM `MyChampionship` WHERE `champid`='$champid'";
  $sqlresult = mysql_query($query);


   if ($sqlresult) 
   {
        while($re=mysql_fetch_array($sqlresult))
     {
        $sql1=$re['userRegistered'];
     }
      $data=array("status"=> 1 ,"msg"=>"Success","Count"=>$sql1);		
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