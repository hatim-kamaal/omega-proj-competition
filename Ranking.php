<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);
$userid=$jsondata->{'userid'};
//$userid=1;

 if(isset($userid))
{
  $query = "SELECT * FROM `Ranking` WHERE `userId`=$userid";

 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);



   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $Rank = $data['Rank'];
                    $userId = $data['userId'];
                    $UserName = $data['UserName'];
                    $Medal = $data['Medal'];
                    $Loss = $data['Loss'];
                    $Trophee = $data['Trophee'];



       }

  //   $data=array("status"=>1);

 $data=array("status"=> 1 ,"msg"=>"Success","Rank"=>$Rank,"userId"=>$userId,"UserName"=>$UserName,"Medal"=>$Medal,"Loss"=>$Loss,"Trophee"=>$Trophee);
		
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
