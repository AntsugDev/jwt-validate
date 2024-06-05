const jwt = require('jsonwebtoken');
const jwksClient = require('jwks-rsa');
const api = "https://demetra.bluarancio.com/sso2/api/v1/certs";

const token = 'eyJraWQiOiIyMDI0MDUzMTE0MjgxODFnMDZ0b3VxbmQzZWUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIiwiYXVkIjoic3NvMi1hdXRoIiwiaXNzIjoiQWJhY28tU1NPMiIsImV4cCI6MTcxNzYwMjUxOSwiaWF0IjoxNzE3NjAyMjE5LCJ0ZW5hbnQiOiJfIiwiX2xsIjpmYWxzZSwidXNlcm5hbWUiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIn0.dZTCgeRLk74QRUIRMyKH7uvB09pWawRKXkdjwxg3_Lh4VR6a38QHtqX1uPbrB9CdZiXsLgHfAo6YD6idbDq2xXqwwb8wOu08bvJhqKgyehIPXCqABL2hWLg5dlSYtM-PPRKOk7qx7YFerAgbQ45aYo-8R3n8iDrfg297ro4rZwFmk2MY0g8mSCNyRaKiZII2wFElq3u8ufRMrMYy0h9hOkvZJuKf64IeEZyquMLfHtXg8I1asyu7b_idinamfI-7QNUzJEmldvdA6eQHF4-HPbjWhpRux818wpBwRuznSV5Gm-WcoP1KbeOcu49o03GkMJYMnDpwaSqQQ4939G_RBg';



const client = jwksClient({
    jwksUri:api
});

const  getKey = (header, callback) => {
    client.getSigningKey(header.kid, function(err, key) {
        let signingKey = key.publicKey || key.rsaPublicKey;
        callback(null, signingKey);
    });
}

const validate = (token) => {
    return new Promise((resolve,reject) => {
        jwt.verify(token, getKey, function(err, decoded) {
            if(err !== null) reject(err);
            resolve({
                username: decoded['username'],
                expired: new Date(decoded['exp']*1000).toLocaleTimeString()
            })
        });
    })
}

validate(token).then(r => {
    console.log(r)
}).catch(e => {
    console.error(e)
})