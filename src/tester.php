<?php
require_once '../vendor/autoload.php';
try{
    $jwt = "eyJraWQiOiIyMDI0MDUzMTE0MjgxODFnMDZ0b3VxbmQzZWUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIiwiYXVkIjoic3NvMi1hdXRoIiwiaXNzIjoiQWJhY28tU1NPMiIsImV4cCI6MTcxNzU5MDYxNywiaWF0IjoxNzE3NTkwMzE3LCJ0ZW5hbnQiOiJfIiwiX2xsIjpmYWxzZSwidXNlcm5hbWUiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIn0.T1pajBOBglPgjwQFWvFARl7bMX91I_4UKaJGA14nkgpbQ8txx_wFZbrHZSqJY4TnJoYPrjZnR_yTBdr3XmXOyiv_aEpWupGG4mnhypwSTq2U81eBFLMzYzLzsVvPuokgtAacewTas9wT48EmrEY_bawegb_PBtfXQAlex887s54Bqx7mTMKNloeKW4VI7BEIkcF5hM6LLU-Vf9WX_409t1U40UbvWIHkMcCpYqluaEkq8XMIFnR67YYiURf3tB3JaIt5RzbdXR2oJWx6mh6A8A-qeiaZiCpefi2la551fMqGujb-zGyRFpoAYo0KAXvLONR1YOG00LS23V-bbqULVQ";
    $jwtExplode = explode('.',$jwt);
    $header = json_decode(base64_decode($jwtExplode[0]));
    $payload = json_decode(base64_decode($jwtExplode[1]));

    $path = "https://demetra.bluarancio.com/sso2/api/v1/certs";
    $client = new \GuzzleHttp\Client();
    $response = $client->get($path);
    $body = $response->getBody();
    $decode = json_decode($response->getBody(), true);
    $keys = $decode['keys']; //202405311428181g06touqnd3ee
    $filter = array_values(array_filter($keys, function ($item) use ($header) {
        return strcmp($item['kid'], $header->kid) === 0;
    }));

//
//    $baseHeader = Base64UrlEncode($explodeJwt[0]);
//    $basePayload = Base64UrlEncode($explodeJwt[1]);
//
//    $signature = hash_hmac('sha256', "$baseHeader.$basePayload", $filter[0]['n']);
//    $jwtValidate = "$explodeJwt[0]. $explodeJwt[1].$signature";
//
    $result = array(
        "expired" => date('d/m/Y H:i:s',($payload->exp)),
        "user" => $payload->sub
    );

    echo json_encode($result, true);
}catch (\Exception $e){
    throw new \Exception($e->getMessage());
} catch (\GuzzleHttp\Exception\GuzzleException $e){
    throw new \Exception($e->getMessage());
}

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
