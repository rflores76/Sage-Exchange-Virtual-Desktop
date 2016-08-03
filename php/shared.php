<?php

    function getEnvelope($xmlRequest){
        
        // this function sends SEVD the intended XML request,
        // and SEVD responds with a tokenized version of the same request.
        // the user submits the tokenized version to SEVD from the  
        // browser, which safely produces the equivalent request.
        // this keeps sensitive data from being exposed client-side
        
        $url = "https://www.sageexchange.com/sevd/frmEnvelope.aspx";
        $body = "request=" . urlencode($xmlRequest);
        
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
    
    function openEnvelope($xmlResponse){
        $url = "https://www.sageexchange.com/sevd/frmOpenEnvelope.aspx";
        //$url = "http://requestb.in/rbzg3yrb";
        $body = "request=" . urlencode($xmlResponse);
        
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

    function getRedirectUrl(){
        
        // this is a little more complicated than it needs to be... we need
        // to send an absolute URL to SEVD, but this sample code may be run
        // in a variety of environments - so I can't just hard-code a value.
        
        $currentUrl = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $redirectUrl = str_replace(basename($currentUrl), "response.php", $currentUrl);
        
        return $redirectUrl;
    }

?>