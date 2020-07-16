<?php
/** flutterwave api ver 2 - verify payment  */
$POST = file_get_contents("php://input");
$req = json_decode($POST, true);
if ($req == "") {
    $req = $_POST;
}
require_once "functions.php";
//: secure key - allow only ur app to read it
$path = "/home/cpanel_username/ravesecret.txt"; // for shared hosting app. Or you can use env file to secure the key
$sec = GetSecretKey($path);

if (isset($req['reference'])) {

    $ref = $req['reference'];
    $amount = ""; //Correct Amount from Server
    $currency = "NGN"; //Correct Currency from Server

    $query = array(
        "SECKEY" => "$sec",
        "txref" => $ref,
    );

    $data_string = json_encode($query);

    $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify ');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $response = curl_exec($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $body = substr($response, $header_size);

    curl_close($ch);

    $resp = json_decode($response, true);

    $paymentStatus = $resp['data']['status'];
    $chargeResponsecode = $resp['data']['chargecode'];
    $chargeAmount = $resp['data']['amount'];
    $chargeCurrency = $resp['data']['currency'];
    echo json_encode($resp);   // do whatever u want with the reponse
    // if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {

    // if (($chargeResponsecode == "00" || $chargeResponsecode == "0") &&  ($chargeCurrency == $currency)) {
    //   //Give Value and return to Success page

    // } else {
    //     //Dont Give Value and return to Failure page
    // }
}
