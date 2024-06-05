<?php
// Generate a new private and public key pair
$keyPair = openssl_pkey_new();
var_dump($keyPair);die;

$publicKey = openssl_pkey_get_details($keyPair)['key'];
file_put_contents('publickey.pem', $publicKey);
$privateKey = '';
openssl_pkey_export($keyPair, $privateKey);
file_put_contents('privatekey.pem', $privateKey);

echo "Public key saved to publickey.pem\n";
echo "Private key saved to privatekey.pem (optional)\n";
?>
