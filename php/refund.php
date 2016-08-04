<?php

    $reference = $_REQUEST['ref'];
    
    require('shared.php');
    
    // you (or your client's) merchant credentials.
    // grab a test account from us for development!
    $merchant_id = $sharedCredentials["MID"];
    $merchant_key = $sharedCredentials["MKEY"];

    // configuring the transaction
    $amount = "10.00";
    $transaction_type = $transactionTypes["NonUI"]["Refund"];

    // some arbitrary values for this demo
    $order_number = "Invoice " . rand(0, 1000);
    $transaction_id = uniqid();

    // and then piecing together our XML request
    $xmlRequest = "<?xml version=\"1.0\" encoding=\"utf-16\"?>
    <Request_v1 xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
        <Application>
            <ApplicationID>DEMO</ApplicationID>
            <LanguageID>EN</LanguageID>
        </Application>
        <Payments>
            <PaymentType>
            <Merchant>
                <MerchantID>$merchant_id</MerchantID>
                <MerchantKey>$merchant_key</MerchantKey>
            </Merchant>
            <TransactionBase>
                <TransactionID>$transaction_id</TransactionID>
                <TransactionType>$transaction_type</TransactionType>
                <Reference1>$order_number</Reference1>
                <Amount>$amount</Amount>
                <VANReference>$reference</VANReference>
            </TransactionBase>
            </PaymentType>
        </Payments>
    </Request_v1>";

    // since no user interaction is required, this request can be done
    // directly from the server. and since it's a server-side request,
    // there's no need to tokenize the xml.
    $url = "https://www.sageexchange.com/sevd/frmPayment.aspx";
    $body = "request=" . urlencode($xmlRequest);
    $response = makePostRequest($body, $url);
    
    // work with it as a simplexml object...
    $xmlResponse = simplexml_load_string($response);
    
    // or as json...
    $jsonResponse = json_encode($xmlResponse);
    
    // ... or as an array.
    $arrayResponse = json_decode($jsonResponse, true);
    
    echo '<pre>';
    print_r($arrayResponse);
    echo '</pre>';

?>