<?php
    
    require('shared.php');
    
    // you (or your client's) merchant credentials.
    // grab a test account from us for development!
    $merchant_id = $sharedCredentials["MID"];
    $merchant_key = $sharedCredentials["MKEY"];

    // configuring the request
    $amount = "25.00";
    $vaultOperation = "CREATE";

    // some arbitrary values for this demo
    $vault_id = uniqid();

    // and then piecing together our XML request.
    // in this sample, we're using the vault to tokenize a card.
    // you can use the token to charge the card in the future
    $xmlRequest = "<?xml version=\"1.0\" encoding=\"utf-16\"?>
    <Request_v1 xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
        <Application>
            <ApplicationID>DEMO</ApplicationID>
            <LanguageID>EN</LanguageID>
        </Application>
        <VaultOperation>
            <Merchant>
                <MerchantID>$merchant_id</MerchantID>
                <MerchantKey>$merchant_key</MerchantKey>
            </Merchant>
            <VaultID>$vault_id</VaultID>
            <VaultStorage>
                <Service>$vaultOperation</Service>
            </VaultStorage>
        </VaultOperation>
    </Request_v1>";
    
    $tokenizedRequest = getEnvelope($xmlRequest);
    $redirectUrl = getRedirectUrl("vaultResponse.php");

?>

<html>
    <form method="POST" action="https://www.sageexchange.com/sevd/frmPayment.aspx">
        <input type="hidden" name="request" value="<?php echo htmlspecialchars($tokenizedRequest) ?>" />
        <input type="hidden" name="redirect_url" value="<?php echo "https://$redirectUrl" ?>" />
        <input type="hidden" name="consumer_initiated" value="true" />
        <input type="submit" value="Store Card" />
    </form>
</html>