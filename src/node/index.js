const jose = require('node-jose');
const jwt = require('jsonwebtoken');
const axios = require("axios");
const api = "https://demetra.bluarancio.com/sso2/api/v1/certs";

const validateToken = (token,key) => {
    return new Promise(async (resolve,reject) => {
        try {
            const keystore = jose.JWK.createKeyStore();
            const rsaKey = await keystore.add(key, 'json');
            const publicKey = rsaKey.toPEM(false);
            const decoded = jwt.verify(token, publicKey, { algorithms: ['RS256'] });
            resolve(decoded)
        } catch (err) {
            reject(err.message || err.text)
        }
    })
}

const Certs = async (token) => {
    let header = Split(token)
    return new Promise((resolve, reject) => {
        axios.get(api).then(response =>{
            let data = response.data.keys;
            let filter = data.filter(e => {
                return e['kid'] === header['kid'];
            })
            if(filter.length > 0){
                resolve(validateToken(token,filter[0]))
            }
            reject("Key not found");

        }).catch(e => {
            reject(e.message || e.text)
        })
    })

}

const Split = (token) => {
    let split = token.toString().split('.');
    try{
        return JSON.parse(atob(split[0]))
    }catch (e){
        console.error(e)
    }

}

const token = 'eyJraWQiOiIyMDI0MDUzMTE0MjgxODFnMDZ0b3VxbmQzZWUiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJzdWIiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIiwiYXVkIjoic3NvMi1hdXRoIiwiaXNzIjoiQWJhY28tU1NPMiIsImV4cCI6MTcxNzU5ODYzNiwiaWF0IjoxNzE3NTk4MzM2LCJ0ZW5hbnQiOiJfIiwiX2xsIjpmYWxzZSwidXNlcm5hbWUiOiJBTlRPTklPLlNVR0FNRUxFQEJMVUFSQU5DSU8uQ09NIn0.c5Q-wE6v_iZikt0gpxWlq3bVJVL3_jc8iYA0Wa6S5RTGB21swqFTHOlZjxfa6AuCrpvBblJJCbCf3Mu15xCRFASzVvShvBK5sBj98NT6jevLCgZRBTWamgOus_3Zi3KuGiq5J1lHuhD8MPb60aOQPhjJpCzx1j45A4W80R-2faB03EljZy5_zDpZIXFX2-DvCtB0KIdu8K7YNLWdKzDwjs82wk1j-U57ioHnSJcVMpGojBxDt4Q8ukKu9B-PnFIEvFxrZwjzFK2pG9bYRWBl5dpWITnm2jSnGOa5ZbPfgqwIib3LEpu83C5hyDJs0AfHtK6G9cDGyCBIB9EGVTiLeg';

Certs(token).then(r => {
    console.log('ok: ',r)
}).catch(e => {
    console.log('eccezione: ',e.message || e.text)
})



