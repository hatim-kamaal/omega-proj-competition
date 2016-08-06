<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 

$Email = $jsondata->{'email'};
$Name = $jsondata->{'name'};


/*
$Email = 'Email';
$Name ='Name';
*/


if(isset($Email) && isset($Name))
{
 $insertQuery = "INSERT INTO `FacebookDetails`(`Email`, `Name`) VALUES ('$Email','$Name')";			   
 $insertQueryResult = mysql_query($insertQuery);
 
$wd="SELECT max(fid) as fid FROM `FacebookDetails`";
$wd1=mysql_query($wd);


while($re=mysql_fetch_array($wd1))
{
$sql1=$re['fid'];
}



 if($insertQueryResult){

$json = array("status" => 1, "msg" => "Success","Fid"=>$sql1);
 }else{
	  $json = array("status" => 0, "msg" => "Failure");
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