<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 $champid=$jsondata->{'champid'};
 $userid =$jsondata->{'userid'};
 $opponentid =$jsondata->{'opponentid'};
 $roundid =$jsondata->{'roundid'};
/*
$champid=1;
$userid=33;
$opponentid=2;
$roundid=1;
*/
if(isset($champid) && isset($userid) && isset($opponentid) && isset($roundid))
{
  $query = mysql_query("CALL getChampTableDetails('$champid','$userid','$opponentid','$roundid')");

 
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