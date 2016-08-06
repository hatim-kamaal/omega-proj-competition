<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$fullname=$jsondata->{'fullname'};
$email=$jsondata->{'email'};


//$fullname='ra';
//$email='garud.ashish51@gmail.com';

 if(isset($fullname) && isset($email))
{ 
    $query = "SELECT * FROM `User` WHERE `fullname`='$fullname' and `email`='$email' and `facebookLogin`='YES'";

 
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
			$data = array("status" => 0, "msg" => "No Data Found");	
			
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