<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once '../vendor/autoload.php';
$jwt = "eyJraWQiOiIyMDI0MDUzMTE0MjgxODFnMDZ0b3VxbmQzZWUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIiwiYXVkIjoic3NvMi1hdXRoIiwiaXNzIjoiQWJhY28tU1NPMiIsImV4cCI6MTcxNzU5NDg4NSwiaWF0IjoxNzE3NTk0NTg1LCJ0ZW5hbnQiOiJfIiwiX2xsIjpmYWxzZSwidXNlcm5hbWUiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIn0.M6YnAi8IWnKLkVTf_NG4pQQnjaj6epU-vBilGZCdmMPR0LwLSiOH6bRCGbPl9XBNGfXJgPZdbYmltup-hdancFse933CiInmk8qySX26-ET8goVaokSxGpecF9hg1cgOaT4hDeU0jkht2TfIr9mLI1NE-2EeEJw2Aq2ItpodZOd-I3MH6cXUF83InD2gxFkTDbeFGYGbtvvS8XU2Rwb4Njr1W5WctZLwBYNnnLYClqe0Jso3LNMgG69C4U25ia8YZLECGjsv6BujY9yDUZXvy0PzqxXgtyF9GWe4LnJyhcHhS3EZ-m4Dj4cdo8xKGUXNl4a63DdgBDbKPW0JnI1g2Q";
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
$keys = $filter[0]['n'];
$string = "";
if(strlen($keys) > 64){
    for ($i = 0 ; $i < strlen($keys); $i++){
        if($i%64 === 0)
            $string .= substr($keys,$i,64)."\n";
    }
}else $string= $keys;
$begin = str_repeat('-',5)."BEGIN PUBLIC KEY".str_repeat('-',5).str_repeat("\t",1)."\n";
$end   = str_repeat('-',5)."END PUBLIC KEY".str_repeat('-',5).str_repeat("\t",3);

$publicKey = str_replace("\\n", "\n",$begin."\n".$string."\n".$end);

//$h = fopen('keys.pub','w');
//fwrite($h,$publicKey);
//fclose($h);
//die;

try{
    $decode = JWT::decode($jwt, new Key($publicKey, 'RS256'));
    echo 'valid<br>';
    print_r($decode);
}catch (\Exception $e){
    echo 'jwt non valid: '.$e->getMessage();
}
