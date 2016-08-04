<?php

    $sharedCredentials = [
        
        "MID" => "417227771521",
        "MKEY" => "I5T2R2K6V1Q3"
        
    ];
    
    $transactionTypes = [
        
        "UI" => [
            "Sale" => "11",
            "Auth" => "12",
            "Cap" => "13",
            // no UI-based voids
            "Force" => "15",
            "Refund" => "16",
            "Credit" => "17",
        ],
        "NonUI" => [
            // non-ui requests must reference either a vault token,
            // or an existing transaction's VANReference (eg, refund)
            "Sale" => "01",
            "Auth" => "02",
            "Cap" => "03",
            "Void" => "04",
            "Force" => "05",
            "Refund" => "06",
        ]
        
    ];
    
    function getEnvelope($xmlRequest){
        
        // this function sends SEVD the intended XML request,
        // and SEVD responds with a tokenized version of the same request.
        // the user submits the tokenized version to SEVD from the  
        // browser, which safely produces the equivalent request.
        // this keeps sensitive data from being exposed client-side
        
        $url = "https://www.sageexchange.com/sevd/frmEnvelope.aspx";
        $body = "request=" . urlencode($xmlRequest);
        return makePostRequest($body, $url);
    }
    
    function openEnvelope($xmlResponse){
        
        // just like before, anything that's exposed to the client is
        // handled in a tokenized form. so when we get the payment response 
        // from them, we have to detokenize it.
        
        $url = "https://www.sageexchange.com/sevd/frmOpenEnvelope.aspx";
        $body = "request=" . urlencode($xmlResponse);
        return makePostRequest($body, $url);
    }
    
    function makePostRequest($body, $url){
        
        $config = [
            "http" => [
                "header" => [
                    "content-type: application/x-www-form-urlencoded",
                    "accept: application/xml"
                ],
                "method" => "POST",
                "content" => $body
            ]
        ];
        
        $context = stream_context_create($config);
        $result = file_get_contents($url, false, $context);
        
        return $result;
    }

    function getRedirectUrl($responsePage){
        
        // this is a little more complicated than it needs to be... we need
        // to send an absolute URL to SEVD, but this sample code may be run
        // in a variety of environments - so I can't just hard-code a value.
        
        $currentUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $redirectUrl = str_replace(basename($currentUrl), $responsePage, $currentUrl);
        
        return $redirectUrl;
    }

?>