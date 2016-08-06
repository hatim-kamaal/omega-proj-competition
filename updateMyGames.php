<?php
include_once('connection.php');
 
if($_SERVER['REQUEST_METHOD'] == "POST"){
 // Get data
  
 $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
 
$userid = $jsondata->{'userid'};
$gamename = $jsondata->{'gamename'};
$gameimage = $jsondata->{'gameimage'};

/*

$userid = '1';

$gamename = 'mmm';
$gameimage = 'india';
*/


if(isset($gamename) && isset($userid) && isset($gameimage))
{
      $qry="SELECT `gamename` FROM `MyGames` WHERE `userid`='$userid'";
      $q=mysql_query($qry);
      $qc= $count = mysql_num_rows($q);
       if ($count > 0) 
       {
                   while($data = mysql_fetch_assoc($q))
                  {

                         $gamename1 = $data['gamename'];
                   
                  }
           if($gamename1 == $gamename)
           {
               $sq= "DELETE FROM `MyGames` WHERE `userid`='$userid' and `gamename`='$gamename'";
              $sqq=mysql_query($sq); 
              if($sqq)
              {
                     $insertQuery = "INSERT INTO `MyGames`(`gamename`, `gameimage`, `userid`) VALUES ('$gamename','$gameimage','$userid')";		   
                  $insertQueryResult = mysql_query($insertQuery);
                  if($insertQueryResult)
                  {

                       $json = array("status" => 1, "msg" => "Success");
                  }else
                  {
	               $json = array("status" => 0, "msg" => "Failure");
                  } 
             }
             else
             {
	               $json = array("status" => 0, "msg" => "Failure");

             }

     
    }
     else
      {
		 $insertQuery = "INSERT INTO `MyGames`(`gamename`, `gameimage`, `userid`) VALUES ('$gamename','$gameimage','$userid')";		   
                  $insertQueryResult = mysql_query($insertQuery);
                  if($insertQueryResult)
                  {

                       $json = array("status" => 1, "msg" => "Success");
                  }else
                  {
	               $json = array("status" => 0, "msg" => "Failure");
                  } 	
      }



      }
     else
      {
		 $insertQuery = "INSERT INTO `MyGames`(`gamename`, `gameimage`, `userid`) VALUES ('$gamename','$gameimage','$userid')";		   
                  $insertQueryResult = mysql_query($insertQuery);
                  if($insertQueryResult)
                  {

                       $json = array("status" => 1, "msg" => "Success");
                  }else
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