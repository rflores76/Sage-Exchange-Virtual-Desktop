<?php 
    
    require('shared.php');
    
    // the browser posts a tokenized response to our redirect_url
    // detokenize it server-side, very similar to the way we
    // tokenized our request earlier. see shared.php
    $response = openEnvelope($_POST['response']);
    
    // work with it as a simplexml object...
    $xml = simplexml_load_string($response);
    // or as json...
    $json = json_encode($xml);
    // ... or as an array.
    $array = json_decode($json, true);
  
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  
?>