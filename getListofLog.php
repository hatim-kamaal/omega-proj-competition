<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
$userid=$jsondata->{'userid'};
$date=$jsondata->{'date'};
 //$userid=3;
//$date='2016';
if(isset($userid) && isset($date))
{
  $query = "SELECT * FROM LogTable WHERE `date` LIKE '%$date' AND `userid`='$userid'";

 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
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
			$data = array("status" => 0, "msg" => "Invaid Parameter");	

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