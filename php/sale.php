<?php
    
    // ===============================
    // SAMPLE SEVD REQUEST - PHP
    // Majid Razvi
    // Software Engineer
    // Sage Payment Solutions
    // August 3rd, 2016
    // Standard MIT License.
    // ===============================

    require('envelope.php');
    
    // you (or your client's) merchant credentials.
    // grab a test account from us for development!
    $merchant_id = "417227771521";
    $merchant_key = "I5T2R2K6V1Q3";

    // configuring the transaction
    $amount = "25.00";
    $transaction_type = "11"; // 11 -> Sale

    // some arbitrary values for the samaple
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
              </TransactionBase>
            </PaymentType>
          </Payments>
        </Request_v1>";
    

?>