<?php

include_once('connection.php');
//require '/stripe-php-3.17.0 2/lib/Stripe.php';
require '/stripe-php-3.17.0 2/init.php';


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $json=file_get_contents("php://input");
    $jsondata=json_decode($json);

 
$stripeToken='tok_18XmloBPXfl9x1jPlsqotFys';
$apikey='sk_test_b4rdHO0YQqClDqyQJendYGWx';
$amount='10';
$currency="USD";


  \Stripe\Stripe::setApiKey($apikey);
  $error = '';
  $success = '';

  try {
    if (!isset($stripeToken))
      throw new Exception("The Stripe Token was not generated correctly");
    \Stripe\Charge::create(array("amount" => $amount,
                                "currency" => $currency,
                                "card" => $stripeToken));
    $success = 'Your payment was successful';
   $data = array("status" => 1, "msg" =>$success);

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