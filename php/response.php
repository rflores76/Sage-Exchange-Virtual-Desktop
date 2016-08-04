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
    $reference = $arrayResponse["PaymentResponses"]["PaymentResponseType"]["TransactionResponse"]["VANReference"]
?>

<html>
    
    <form action="void.php">
        <input type="hidden" name="ref" value="<?php echo $reference ?>" />
        <input type="submit" value="VOID this transaction" />
    </form>
    
    <form action="refund.php">
        <input type="hidden" name="ref" value="<?php echo $reference ?>" />
        <input type="submit" value="REFUND this transaction" />
    </form>
    
    <pre>
        <?php print_r($arrayResponse) ?>
    </pre>
</html>