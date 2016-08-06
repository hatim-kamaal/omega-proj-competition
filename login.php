<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
 $json=file_get_contents("php://input");
 $jsondata=json_decode($json);
 
 $username=$jsondata->{'username'};
 $password=$jsondata->{'password'};
 //$username='Ash';
//$password='123';

if(isset($username) && isset($password))
{
 $query = "SELECT  * FROM `User` WHERE `username`='$username' AND `Password`='$password'";

 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);

 $query1 = "SELECT  `user_id` FROM `User` WHERE `username`='$username' AND `Password`='$password'";
 $sqlresult1 = mysql_query($query1);

      
    while($re=mysql_fetch_array($sqlresult1))
     {
        $sql1=$re['user_id'];
     }




     if ($count > 0)
     {
        
               $data = array('msg'=>"Success","userid"=>$sql1);
          
     }
     else
     {
         $data=array("msg"=>"Failed");
      }
}
else
{
 $data = array("status" => 0, "msg" => "Invalid Parameter");

}	
}else{
 $data = array("status" => 0, "msg" => "Request method not accepted",);
}
 
@mysql_close($conn);
/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);
?>