<?php
include_once('connection.php');


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$PromoCode=$jsondata->{'PromoCode'};

  $query = "SELECT * FROM `PromoCode` WHERE `Code`='$PromoCode'";

 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $result[] = $data;
       }

      $data=array("status"=> 1 ,"msg"=>"Success","requestDetails"=>$result);		
    }
     else
      {
			$data = array("status" => 0, "msg" => "Promo code Not Available");	
			
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