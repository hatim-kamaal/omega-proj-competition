<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
$ChampId = $jsondata->{'ChampId'};
$UserId = $jsondata->{'UserId'};
$OpponentId = $jsondata->{'OpponentId'};
$UserScore = $jsondata->{'UserScore'};
$OpponentScore = $jsondata->{'OpponentScore'};
$Round = $jsondata->{'Round'};
$status='CLOSED';


/*
$ChampId ='3';
$UserId = '1';
$OpponentId=1;
$UserScore=10;
$OpponentScore=20;
$Round=1;
*/

if(isset($ChampId) &&  isset($UserId) && isset($OpponentId) && isset($UserScore) &&  isset($OpponentScore) && isset($Round))
{
     

        $insertQuery = "INSERT INTO `Results`(`ChampId`, `UserId`, `OpponentId`, `UserScore`, `OpponentScore`, `Round`,`Status`) VALUES ('$ChampId','$UserId','$OpponentId','$UserScore','$OpponentScore','$Round','$status')";			   
 $insertQueryResult = mysql_query($insertQuery);
 



       if($insertQueryResult){
         
          $json = array("status" => 1, "msg" => "Success");

          
          

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