<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 

$fullname = $jsondata->{'fullname'};
$country = $jsondata->{'country'};
$platform = $jsondata->{'platform'};
$username = $jsondata->{'username'};
//$games = $jsondata->{'games'};
$language = $jsondata->{'language'};
$profile_pic = $jsondata->{'profile_pic'};
$password = $jsondata->{'password'};
$email = $jsondata->{'email'};
$fblogin = $jsondata->{'fblogin'};

/*

$fullname = 'ashish';
$country = 'india';
$platform = 'ps3';
$username = 'Ash1';
$games = 'fifa 16';
$language = 'English';
$profile_pic = ashish.png;
$password = '123';
$email='ashish.garud@gmail.com';
*/


if(isset($fullname) && isset($country) && isset($platform) && isset($username) && isset($language) && isset($profile_pic) &&  isset($email))
{


$query = "SELECT * FROM `User` WHERE `username`='$username'";

 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


     if ($count > 0)
     {
        
               $json = array('msg'=>"User Name Already Exists");
          
     }
     else
     {
        // $data=array("msg"=>"Failed");
     



        $insertQuery = "INSERT INTO `User`(`fullname`, `country`, `platform`, `username`,`language`, `profile_pic`, `password`, `email`, `facebookLogin`) VALUES ('$fullname','$country','$platform','$username','$language','$profile_pic','$password','$email','$fblogin')";			   
 $insertQueryResult = mysql_query($insertQuery);
 
      $wd="SELECT max(`user_id`) as userid FROM `User`";
      $wd1=mysql_query($wd);


     while($re=mysql_fetch_array($wd1))
     {
        $sql1=$re['userid'];
     }



       if($insertQueryResult){

       $json = array("status" => 1, "msg" => "Success","userid"=>$sql1);
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