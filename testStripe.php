<?php

include_once('connection.php');
//require '/stripe-php-3.17.0 2/lib/Stripe.php';
require '/stripe-php-3.17.0 2/init.php';


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 
$stripeToken=$jsondata->{'stripeToken'};
$apikey='sk_test_b4rdHO0YQqClDqyQJendYGWx';
$amount=$jsondata->{'amount'};
$currency=$jsondata->{'currency'};


  \Stripe\Stripe::setApiKey($apikey);
  $error = '';
  $success = '';

  try {
    if (!isset($stripeToken))
      throw new Exception("The Stripe Token was not generated correctly");
    $charge=\Stripe\Charge::create(array("amount" => (int)$amount,
                                "currency" => $currency,
                                "card" => $stripeToken));
    $success = 'Your payment was successful.';
   $data = array("status" => 1, "msg" =>$success,"response"=>$charge);

  }
  catch (Exception $e) {
    $error = $e->getMessage();
    echo $error;
   //$data = array("status" => 0, "msg" =>"error");

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