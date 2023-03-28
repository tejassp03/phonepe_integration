
<?php
session_start();

if(isset($_POST['amount']))
{
$amt=$_POST['amount'].'00';
$requestParams = '{
    "merchantId": "INNOVATIVEIDEASUAT",
    "merchantTransactionId": "MT785859026815784533",
    "merchantUserId": "MUID123",
    "amount": '.$amt.',
    "redirectUrl": "https://eltscertification.in/landing/paysuccess.php",
    "redirectMode": "POST",
    "callbackUrl": "https://eltscertification.in/landing/pay_callback.php",
    "mobileNumber": "9999999999",
    "paymentInstrument": {
      "type": "PAY_PAGE"
    }
  }';

// Encode the request parameters as JSON and then as base64
// $requestJson = json_encode($requestParams);
$requestBase64 =base64_encode($requestParams);
$salt='3515227c-eb5b-4ff8-8c9f-5f5f3e119e20';
$saltIndex=1;

$xver = $requestBase64 . "/pg/v1/pay" . $salt;

// Calculate the SHA256 hash
$hashValue = hash("sha256", $xver);


// Concatenate the hash value with the salt index
$verificationString = $hashValue . "###" . $saltIndex;
setcookie('xverify', $verificationString, time() + (300), "/");


// Set up the cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/pay');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"request":"' . $requestBase64 . '"}');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    "X-VERIFY: " . $verificationString,
    "X-REQUEST-ID: " . uniqid()
));

// Send the request
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);
if($response)
{
$resjson=json_decode($response,true);
$url = $resjson['data']['instrumentResponse']['redirectInfo']['url'];
if(isset($url)){
    echo $url;
}
}

}

// ...and so on


?>