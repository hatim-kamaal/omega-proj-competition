<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
$pic=$jsondata->{'pic'};
 
  $query = "UPDATE `User` SET `profile_pic`='$pic' WHERE `user_id`=33";

 
 $sqlresult = mysql_query($query);
 


   if ($sqlresult) 
   {
      
      $data=array("status"=> 1 ,"msg"=>"Success");		
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