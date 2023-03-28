<?php 
session_start();
$post_data_expected = file_get_contents("php://input");
$decoded_data = json_decode($post_data_expected, true);
$decrypt=json_decode(base64_decode($decoded_data['response']), true);


$paystatus = $decrypt['data']['payResponseCode'];
$mtransid = $decrypt['data']['merchantTransactionId'];
$transid = $decrypt['data']['transactionId'];
$paytype = $decrypt['data']['paymentInstrument']['type'];
$amount = $decrypt['data']['amount'];

$_SESSION['mtransid']=$mtransid;
$_SESSION['paytype']=$paytype;
$_SESSION['transid']=$transid;
$_SESSION['amount']=$amount;


    if(isset($paystatus) && $paystatus == "PAYMENT_SUCCESS"){
        header('Location: payfailure.php');
    }
    else if(isset($paystatus) && $paystatus == "PAYMENT_PENDING")
    {
        header('Location: paypending.php');
    }
    else
    {
        header('Location: payerror.php');
    }

?>