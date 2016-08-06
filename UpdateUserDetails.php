<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 
$userid = $jsondata->{'userid'};
$fullname = $jsondata->{'fullname'};
$country = $jsondata->{'country'};
$platform = $jsondata->{'platform'};
$username = $jsondata->{'username'};
//$games = $jsondata->{'games'};
$language = $jsondata->{'language'};
$profile_pic = $jsondata->{'profile_pic'};
$password = $jsondata->{'password'};
$email = $jsondata->{'email'};

/*
$userid = '1';

$fullname = 'ashish';
$country = 'india';
$platform = 'ps-4';
$username = 'Ash3';
$games = 'fifa 16';
$language = 'English';
$profile_pic = ashish.png;
$password ='123';
$email='abc@gmail.com';
*/

if(isset($fullname) && isset($userid) && isset($country) && isset($platform) && isset($username) && isset($language) && isset($profile_pic) && isset($email))
{

$query = "SELECT * FROM `User` WHERE `username`='$username' AND `user_id`<>'$userid'";

 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


     if ($count > 0)
     {
        
               $json = array('msg'=>"User Name Already Exists");
          
     }
     else
     {
 $insertQuery = "UPDATE `User` SET `fullname`='$fullname',`country`='$country',`platform`='$platform',`username`='$username',`language`='$language',`profile_pic`='$profile_pic',`password`='$password',`email`='$email' WHERE `user_id`='$userid'";			   
 $insertQueryResult = mysql_query($insertQuery);
 

 if($insertQueryResult)
{

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