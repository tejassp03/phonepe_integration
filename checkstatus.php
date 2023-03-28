
<?php
  $merid='INNOVATIVEIDEASUAT';
  $transid='MT785859006816784533';
// Encode the request parameters as JSON and then as base64
// $requestJson = json_encode($requestParams);

$salt='3515227c-eb5b-4ff8-8c9f-5f5f3e119e20';
$saltIndex=1;

$xver = '/pg/v1/status/'.$merid.'/'.$transid . $salt;


// Calculate the SHA256 hash
$hashValue = hash("sha256", $xver);


// Concatenate the hash value with the salt index
$verificationString = $hashValue . "###" . $saltIndex;

$curl = curl_init();
// Set up the cURL request
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/status/INNOVATIVEIDEASUAT/MT785859006816784533",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
      "Content-Type: application/json",
      "X-MERCHANT-ID: INNOVATIVEIDEASUAT",
      "X-VERIFY: d003ac6fe03e022ec4d7daf2fcc723ebc6bc6c666a5d781d06c40400a1e5a521###1",
      "accept: application/json"
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    $resjson=json_decode($response,true);
    $paystatus = $resjson['data']['responseCode'];
    if(isset($paystatus) && $paystatus == "PAYMENT_SUCCESS"){
        header('Location: paysuccess.php');
    }
    else if(isset($paystatus) && $paystatus == "PAYMENT_PENDING")
    {
        header('Location: paypending.php');
    }
    else
    {
        header('Location: payerror.php');
    }
  }

?>