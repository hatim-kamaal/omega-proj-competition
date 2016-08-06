<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 
//$images = $jsondata->{'images'};
//$gamename = $jsondata->{'gamename'};
//$platform = $jsondata->{'platform'};
//$entryfees = $jsondata->{'entryfees'};
//$until = $jsondata->{'until'};
//$winningprice = $jsondata->{'winningprice'};

$champid = $jsondata->{'champid'};
$userid = $jsondata->{'userid'};

$status='Waiting';
/*
$champid =3;
$userid = 2;
*/

if(isset($champid) &&  isset($userid) && isset($status))
{


$query = "SELECT * FROM `MyChampionship` WHERE `champid`='$champid' AND `userid`='$userid'";

 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


     if ($count > 0)
     {
        
               $json = array('msg'=>"Already Registered");
          
     }
     else
     {
        // $data=array("msg"=>"Failed");
     



        $insertQuery = "INSERT INTO `MyChampionship`(`champid`, `userid`, `status`) VALUES ('$champid','$userid','$status')";			   
        $insertQueryResult = mysql_query($insertQuery);

      $wd="SELECT `UserRegistered` FROM `ImagesTable` WHERE `imgId`='$champid'";
      $wd1=mysql_query($wd);
     while($re=mysql_fetch_array($wd1))
     {
        $sql1=$re['UserRegistered'];
        $sql1=$sql1+1;
     }
    
     $quy = "SELECT * FROM `masterChampRound` WHERE `MinimumLimt`<='$sql1' AND `MaximumLimit`>='$sql1'";
     $sqlresult = mysql_query($quy);
     while($da = mysql_fetch_assoc($sqlresult))
     {
               $Rounds=$da['Rounds'];
     }
       if($insertQueryResult && $wd1 && $quy){
      $upd="UPDATE `ImagesTable` SET `UserRegistered`='$sql1',`TotalRounds`='$Rounds' WHERE `imgId`='$champid'";        
      $upd1=mysql_query($upd);

      if($upd1)
       {
        
          $json = array("status" => 1, "msg" => "Success");

       }
       else
       {
       	  $json = array("status" => 0, "msg" => "Failure");

       }   
          

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