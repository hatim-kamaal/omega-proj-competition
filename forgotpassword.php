<?php
include_once('connection.php');

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

$email=$jsondata->{'email'};
//$email='gauravbangad33@gmail.com';
if(isset($email))
{
  $query = "SELECT `username`,`password`,`facebookLogin` FROM `User` WHERE `email`='$email'";

 
 $sqlresult = mysql_query($query);
 $count = mysql_num_rows($sqlresult);


   if ($count > 0) 
   {
       while($data = mysql_fetch_assoc($sqlresult))
       {

                    $username = $data['username'];
                    $pass=$data['password'];
                    $fb=$data['facebookLogin'];
        }
                    if($fb=='YES')
                    {
                       	$data = array("status" => 0, "msg" => "Logged In With FB");	


                    }
                    else
                    {

                             $to =$email;
         $fullname=$username;
         $pass1=$pass;
         $EmailFrom = "info@omega-solutions.in";
         $EmailTo = $to;
         $Subject1 = "Gamrland:ForgetPassword";
         //.$Name.
         $Name = Trim(stripslashes($fullname)); 
         $password = Trim(stripslashes($pass1)); 
         $Subject = Trim(stripslashes($Subject1));
          $message="
              Your username and password

              Name - ".$Name.",
              Password - ".$password.".
             

              Thank you

             ";
// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
  exit;
}

// prepare email body text
$Body = "";
$Body .= $message;
$Body .= "\n";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");






      $data=array("status"=> 1 ,"msg"=>"Success");	

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