<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 
$gameimage = $jsondata->{'gameimage'};
$gamename = $jsondata->{'gamename'};

$userid = $jsondata->{'userid'};

/*
$gameimage = 'ashish';
$gamename = 'india';

$userid = '1';
*/

if(isset($gameimage) && isset($gamename) && isset($userid))
{

$query = "SELECT * FROM `MyGames` WHERE `gamename`='$gamename' AND `userid`='$userid'";

 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


     if ($count > 0)
     {
        
               $json = array('msg'=>"Already selected");
          
     }
     else
     {
        // $data=array("msg"=>"Failed");
     

     



        $insertQuery = "INSERT INTO `MyGames`(`gamename`, `gameimage`, `userid`) VALUES ('$gamename','$gameimage','$userid')";			   
 $insertQueryResult = mysql_query($insertQuery);
 
     


       if($insertQueryResult){

       $json = array("status" => 1, "msg" => "Success");
        }else{
	  $json = array("status" => 0, "msg" => "Failure");
       }
     }
 }
else
{
	  $json = array("status" => 0, "msg" => "Invalid Parameter");

}
 }else{
 $json = array("status" => 0, "msg" => "Request method not accepted");
}
 
@mysql_close($conn);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 
?>