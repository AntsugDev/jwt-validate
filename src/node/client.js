const jwksClient = require('jwks-rsa');
const jwt = require('jsonwebtoken');
function getKey(header, callback){
    let client = jwksClient({
        jwksUri: 'https://demetra.bluarancio.com/sso2/api/v1/certs'
    });
    client.getSigningKey(header.kid, function(err, key) {
        let signingKey = key.publicKey || key.rsaPublicKey;
        callback(null, signingKey);
    });
}
const token = 'eyJraWQiOiIyMDI0MDUzMTE0MjgxODFnMDZ0b3VxbmQzZWUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIiwiYXVkIjoic3NvMi1hdXRoIiwiaXNzIjoiQWJhY28tU1NPMiIsImV4cCI6MTcxNzYwMTgxNywiaWF0IjoxNzE3NjAxNTE3LCJ0ZW5hbnQiOiJfIiwiX2xsIjpmYWxzZSwidXNlcm5hbWUiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIn0.mW6kHAltGPs7kWwpS5-F8x9gSBhhH9CitSuYGEGMGtHpmlhEuxXtr1v3iRrdBGmpgzp5_mOsawUf85968VEpCG-oBY_E6TJYSegLDbGDRowE2VcrjeYWGXmtAqn73HWhpsaZHAidcaO2SjgwGJ6n1hhamQN__vNBJxW1I_OuhKp8cxBcFOSLjUVMEWk9YKt8M4n0AIHW5zpZrnWtnm3vwp04m3OR-UHgZYH2AKwP-gQuXLrcNrm08B3PTNXSfhupGzMBXR1E0mYm4-qLR03gRz4z_hSWnErD7qkQjcP8EouadoWykqHj5xPlJK1PsWG_7z5_oo71P_NnmElNAtSCdw';
jwt.verify(token, getKey, function(err, decoded) {
    console.log(decoded) // bar
    console.log(err) // bar
});