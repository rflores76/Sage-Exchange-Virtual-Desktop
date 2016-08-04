<?php 
    
    require('shared.php');
    
    // the browser posts a tokenized response to our redirect_url.
    // detokenize it server-side, just like we
    // tokenized our request earlier. see shared.php
    $response = openEnvelope($_REQUEST['response']);
    
    // work with it as a simplexml object...
    $xmlResponse = simplexml_load_string($response);
    
    // or as json...
    $jsonResponse = json_encode($xmlResponse);
    
    // ... or as an array.
    $arrayResponse = json_decode($jsonResponse, true);

    // use the VANReference to void or refund the transaction  
    $vaultToken = $arrayResponse["VaultResponse"]["GUID"];
?>

<html>
    
    <form action="vaultSale.php">
        <input type="hidden" name="vaultToken" value="<?php echo $vaultToken ?>" />
        <input type="submit" value="CHARGE this card" />
    </form>
    
    <pre>
        <?php print_r($arrayResponse) ?>
    </pre>
</html>