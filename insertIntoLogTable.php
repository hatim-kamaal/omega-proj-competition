<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$userid=$jsondata->{'userid'};
$date=$jsondata->{'date'};
$why=$jsondata->{'why'};
$category=$jsondata->{'category'};
$howmuch=$jsondata->{'howmuch'};
$status=$jsondata->{'status'};
/*
$userid='1';
$date='10/07/2016';
$why='Credit';
$category='abd';
$howmuch='10';
$status='ac';

*/

if(isset($userid) && isset($date) && isset($why) && isset($category) && isset($howmuch) && isset($status))
{
  $query = "INSERT INTO `LogTable`(`userid`, `date`, `why`, `category`, `howmuch`, `status`) VALUES ('$userid','$date','$why','$category','$howmuch','$status')";

 
 $sqlresult = mysql_query($query);


   if ($sqlresult) 
   {
      
      $data=array("status"=> 1 ,"msg"=>"Success");		
    }
     else
      {
			$data = array("status" => 0, "msg" => "Failure");	
			
      }
}
else
{
		$data = array("status" => 0, "msg" => "Invalid Parameter");	

}
}
else{
 $data = array("status" => 0, "msg" => "Request method not accepted");
}
@mysql_close($conn);

/* JSON Response */
header('Content-type: application/json');
echo json_encode($data);


?>