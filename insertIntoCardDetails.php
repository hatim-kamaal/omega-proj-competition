<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$fullname = $jsondata->{'fullname'};
//$accountno = $jsondata->{'accountno'};
$month = $jsondata->{'month'};
$year = $jsondata->{'year'};
$cardholdername = $jsondata->{'cardholdername'};
$cardtype = $jsondata->{'cardtype'};
$userid = $jsondata->{'userid'};
$firstfourdigit=$jsondata->{'firstfourdigit'};
$secondfourdigit=$jsondata->{'secondfourdigit'};
$thirdfourdigit=$jsondata->{'thirdfourdigit'};
$fourthfourdigit=$jsondata->{'fourthfourdigit'};
/*

$fullname = 'ashish';
$accountno = '1234123412341234';
$month = '08';
$year = '2020';
$cardholdername = 'ashish';
$cardtype = 'visa';
$userid = '2';
$firstfourdigit='1122';
$secondfourdigit='2211';
$thirdfourdigit='1212';
$fourthfourdigit='2121';

*/

if(isset($fullname) && isset($firstfourdigit) && isset($secondfourdigit) && isset($thirdfourdigit) && isset($fourthfourdigit) && isset($month) && isset($year) && isset($cardholdername) && isset($cardtype) && isset($userid))
{


        $insertQuery = "INSERT INTO `CreditCardDetails`(`fullname`, `month`, `year`, `cardholdername`, `cardtype`, `userid`, `firstfourdigit`, `secondfourdigit`, `thirdfourdigit`, `fourthfourdigit`) VALUES ('$fullname','$month','$year','$cardholdername','$cardtype','$userid','$firstfourdigit','$secondfourdigit','$thirdfourdigit','$fourthfourdigit')";			   
 $insertQueryResult = mysql_query($insertQuery);
 
     // $wd="SELECT max(`user_id`) as userid FROM `User`";
      //$wd1=mysql_query($wd);


     //while($re=mysql_fetch_array($wd1))
    // {
      //  $sql1=$re['userid'];
     //}



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