<?php
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Rsa\Sha256; // Use the appropriate signer for your algorithm
use Lcobucci\JWT\Signer\Key;

require_once '../vendor/autoload.php';

$tokenString = 'eyJraWQiOiIyMDI0MDUzMTE0MjgxODFnMDZ0b3VxbmQzZWUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIiwiYXVkIjoic3NvMi1hdXRoIiwiaXNzIjoiQWJhY28tU1NPMiIsImV4cCI6MTcxNzU4MjU2MiwiaWF0IjoxNzE3NTgyMjYyLCJ0ZW5hbnQiOiJfIiwiX2xsIjpmYWxzZSwidXNlcm5hbWUiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIn0.JNIdqVPX6keBxbfPIf2gzTg7Tg_o4ESvKtS-iOTH82m9OTrhG1wGJErGhG5zmmIbovbyBDuXiAGBpCLsiBr_FCuZRSFE7MRwHvKmNCQIqJfCFGKbA-yM8YwNpGqEFKUmBFJ8B23CvEolClCSklNJp81um-eR3tyLuhdY_BVvHp_RDlvIz5PIIUNA55zcK7RaAa_VTi3-8Y8VPuURngbGnYqi0ZRMhNPR62dY9ZZ5ty8osgIRSQT1A3b1q73WA37xAML18j5uO7Pt6UT8PDkljGFYG0P0ZGcVjLjL2ZflvTmsXoD4_qdGycNnk1MlCxQy9H3rL7ecJpEb23BmKO9CCw';
$token = (new \Parser())->parse($tokenString);
$data = new \ValidationData();
$publicKey = 'AM9AvTHkqu7dsl5_G6aswPX6SCLhaefBRMme1Lym1pJSxfwbaRZi8Uays9KUAHJ3n7XKds6qBt_aU2mDa3Bkbhz8xg2YEo5SxPTxtUaoJUcKUN1fM583smyYMlDPYzRSHbIWhRJDkntKZLyx3Thii9cQB5snca9H9uPjM__-Wd0OxEwapy3Hek0BUPJEYsn6lk8kMNzniLbDlatXHdMZNu3hvbP69a8fITpD544cozp85fY-_LujgjkIx-eRqirySWgUkdfZo7zU7cFYVtGeHLIFUkDxaISXM0tMH3mmi9mLCMwUgjQzhw-3OjIIS-Gz7RP5nYt_9jNsk6hot6sAzm8='; // Replace with your actual public key
$signer = new Sha256();

if ($token->validate($data) && $token->verify($signer, new \Key($publicKey))) {
    // Token is valid!
    echo 'Token is valid.';
} else {
    // Token validation failed
    echo 'Token validation failed.';
}