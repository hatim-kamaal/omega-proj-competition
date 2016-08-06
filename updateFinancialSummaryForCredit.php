<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);



$credit=$jsondata->{'credit'};
$year=$jsondata->{'year'};
$userid=$jsondata->{'userid'};


/*
$userid = '33';
$year='2017';
$credit='10';
*/
$spent=0;
$won=0;
$balance=0;

if(isset($userid) && isset($year))
{


        $insertQuery = "SELECT `credit`,`balance` FROM `FinancialSummary` WHERE `userid`='$userid' and `year`='$year'";			   
 $insertQueryResult = mysql_query($insertQuery);
  $count = mysql_num_rows($insertQueryResult );

     
       if($count > 0)
       {
               while($data = mysql_fetch_assoc($insertQueryResult))
              {

                    $cred = (int)$data['credit'];
                    $bal = (int)$data['balance'];
                    
               }
               $cr=$cred+$credit;
               $bl=$bal+$credit;

               $query="UPDATE `FinancialSummary` SET `credit`='$cr',`balance`='$bl' WHERE `userid`='$userid' and `year`='$year'";
               $queryResult = mysql_query($query);
               if($queryResult)
               {
                   $json = array("status" => 1, "msg" => "Success");
               }
               else
               {
	           $json = array("status" => 0, "msg" => "Failure");

               }
       }
       else
       {
             $que="INSERT INTO `FinancialSummary`(`userid`, `spent`, `won`, `credit`, `balance`, `year`) VALUES ('$userid','$spent','$won','$credit','$credit','$year')";
             $queResult=mysql_query($que);
             if($queResult)
             {
                   $json = array("status" => 1, "msg" => "Success");


             }
             else
             {
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