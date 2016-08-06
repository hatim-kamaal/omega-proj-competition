<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$code=$jsondata->{'code'};
//$code=QWCZX123;
if(isset($code))
{
  $query = "SELECT * FROM `PromoCode` WHERE `Code`='$code' and `Status`='True'";

 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $result[] = $data;
       }
       $qury="UPDATE `PromoCode` SET `Status`='False' WHERE `Code`='$code'";
       $quryResult=mysql_query($qury);
       if($quryResult)
       {
             $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);		

       }
       else
       {
             $data = array("status" => 0, "msg" => "Failure");	

       }
        
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