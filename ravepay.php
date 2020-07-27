<?php
/**
 *  Craft a post request to this endpoint file
 * @var endpoint: https://ur-domain.com/ravepay.php
 * @var request: {email, reference, public_key, amount, allow_redirect: 'no' }
 * @var response: a payment link you can load on an iframe popup or you redirect
 * */
$POST = file_get_contents("php://input");

$req = json_decode($POST, true);

if ($req == "") {

    $req = $_POST;
}

if (isset($req["reference"])) {

    extract($req);

    $curl = curl_init();

    $customer_email = $email;

    $currency = "NGN";
    $txref = $reference; // ensure you generate unique references per transaction.
    $PBFPubKey = "$public_key"; // get your public key from the dashboard.

    $payment_plan = ""; // this is only required for recurring payments.

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount' => $amount,
            'customer_email' => $customer_email,
            'currency' => $currency,
            'txref' => $txref,
            'PBFPubKey' => $PBFPubKey,
            'meta' => isset($meta) ?  json_decode($meta) : "",    
            "payment_options" =>  isset($payment_options) ? $payment_options : "",       
            'redirect_url' => $redirect_url,
            "custom_title" =>  isset($product_name) ?  $product_name: "",
            "custom_desc" =>  isset($product_description) ?  $product_description: "",
            "custom_logo" =>  isset($custom_logo) ?  $custom_logo: ""
            //'payment_plan'=>$payment_plan
        ]),
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "cache-control: no-cache",
        ],
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    if ($err) {
        // there was an error contacting the rave API
        die('Curl returned error: ' . $err);
    }

    $transaction = json_decode($response);

    if (!$transaction->data && !$transaction->data->link) {
        // there was an error from the API
        print_r('API returned error: ' . $transaction->message);
        exit;
    }

    // uncomment out this line if you want to redirect the user to the payment page
    //print_r($transaction->data->message);
    if(! isset($transaction->data->link)){
        print_r($transaction->data->message);
        exit;
    }

    // redirect to page so User can pay
    // uncomment this line to allow the user redirect to the payment page
    if (isset($allow_redirect)) {
        if ($allow_redirect != "no") {
            header('Location: ' . $transaction->data->link);
            exit;
        }
    }

    echo $transaction->data->link;
}
