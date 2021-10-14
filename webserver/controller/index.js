//const uuidv4 = require("uuid/v4");
var uuid = require('uuid');
const Hashids = require("hashids");
const URL = require("url").URL;
const hashids = new Hashids();
const { genJwtToken } = require("./jwt_helper");
var database = require('../server/database');
var geoip = require('geoip-lite');
var DeviceDetector = require("device-detector-js");
const re = /(\S+)\s+(\S+)/;
var _ = require('lodash');
var cookieParser = require('cookie-parser');
const session = require("express-session");
var config = require('../config/config');

var sessionOptions = {
    httpOnly: true,
    secure : config.PRODUCTION
};

// Note: express http converts all headers
// to lower case.
const AUTH_HEADER = "authorization";
const BEARER_AUTH_SCHEME = "bearer";

function parseAuthHeader(hdrValue) {
  if (typeof hdrValue !== "string") {
    return null;
  }
  const matches = hdrValue.match(re);
  return matches && { scheme: matches[1], value: matches[2] };
}

const fromAuthHeaderWithScheme = function(authScheme) {
  const authSchemeLower = authScheme.toLowerCase();
  return function(request) {
    let token = null;
    if (request.headers[AUTH_HEADER]) {
      const authParams = parseAuthHeader(request.headers[AUTH_HEADER]);
      if (authParams && authSchemeLower === authParams.scheme.toLowerCase()) {
        token = authParams.value;
      }
    }
    return token;
  };
};

const fromAuthHeaderAsBearerToken = function() {
  return fromAuthHeaderWithScheme(BEARER_AUTH_SCHEME);
};

const appTokenFromRequest = fromAuthHeaderAsBearerToken();

// app token to validate the request is coming from the authenticated server only.
const appTokenDB = {
  sso_consumer: "l1Q7zkOL59cRqWBkQ12ZiGVW2DBL",
  simple_sso_consumer: "1g0jJwGmRQhJwvwNOrY4i90kD0m"
};

// const alloweOrigin = {
//   "http://localhost:2083": true,
//   "http://localhost:2083/login": true,
//   "http://consumertwo.ankuranand.in:3030": true,
//   "http://sso.ankuranand.in:3080": false
// };

const alloweOrigin = {
  //"http://consumer.ankuranand.in:3020": true,
  "http://consumer.ankuranand.in:8800": true,
  "http://consumertwo.ankuranand.in:3030": true
  //"https://wowkong.wowgo.io": true
};

const deHyphenatedUUID = () => uuid.v4().replace(/-/gi, "");
const encodedId = () => hashids.encodeHex(deHyphenatedUUID());

// A temporary cahce to store all the application that has login using the current session.
// It can be useful for variuos audit purpose
const sessionUser = {};
const sessionApp = {};

// const originAppName = {
//   "http://localhost:2083": "sso_consumer",
//   "http://localhost:2083/login": "sso_consumer",
//   "http://consumertwo.ankuranand.in:3030": "simple_sso_consumer"
// };

const originAppName = {
  //"http://consumer.ankuranand.in:3020": "sso_consumer"
  "http://consumer.ankuranand.in:8800": "sso_consumer"
};

// const userDB = {
//   "phyu": {
//     password: '1111',
//     userId: encodedId(), // incase you dont want to share the user-email.
//     appPolicy: {
//       sso_consumer: { role: "admin", shareEmail: true },
//       simple_sso_consumer: { role: "user", shareEmail: false }
//     }
//   }
// };

// these token are for the validation purpose
const intrmTokenCache = {};

const fillIntrmTokenCache = (origin, id, intrmToken) => {
  intrmTokenCache[intrmToken] = [id, originAppName[origin]];
};
const storeApplicationInCache = (origin, id, intrmToken) => {

  if (sessionApp[id] == null) {
    sessionApp[id] = {
      [originAppName[origin]]: true
    };
    fillIntrmTokenCache(origin, id, intrmToken);
  } else {
    sessionApp[id][originAppName[origin]] = true;
    fillIntrmTokenCache(origin, id, intrmToken);
  }
  //console.log('storeeeeeeeeeeeeeeeeeee', { ...sessionApp }, { ...sessionUser }, { intrmTokenCache });
  console.log('storaaaaaaaaaaaaaaaaaa', { ...sessionApp });
  console.log('storuuuuuuuuuuuuuuuuu', { ...sessionUser });
  console.log('stortrrrrrrrrrrrrrrrrrr',  { intrmTokenCache });
};

const generatePayload = ssoToken => {
  
  const globalSessionToken = intrmTokenCache[ssoToken][0];
  const appName = intrmTokenCache[ssoToken][1];
  const userEmail = sessionUser[globalSessionToken];
  const user = userDB[userEmail];
  //console.log('uuuuuuuuuuuuuuuuu', appName);
  const shareEmail = true;
  //const appPolicy = appPolicy[appName];
  const username = shareEmail === true ? userEmail : undefined;
  const payload = {
    //...{ ...appPolicy },
    ...{
      username,
      shareEmail: undefined,
      uid: encodedId(),
      // global SessionID for the logout functionality.
      globalSessionID: globalSessionToken
    }
  };
  
  return payload;
};

const verifySsoToken = async (req, res, next) => {
  console.log('verify hereeeeeeeeeeeeeeeeeeee')
  const appToken = appTokenFromRequest(req);
  const { ssoToken } = req.query;
  // if the application token is not present or ssoToken request is invalid
  // if the ssoToken is not present in the cache some is
  // smart.
  if (
    appToken == null ||
    ssoToken == null ||
    intrmTokenCache[ssoToken] == null
  ) {
    return res.status(400).json({ message: "badRequest" });
  }
  console.log('intrmmmmmmmmmmm', ssoToken)

  // if the appToken is present and check if it's valid for the application
  const appName = intrmTokenCache[ssoToken][1];
  const globalSessionToken = intrmTokenCache[ssoToken][0];
  // If the appToken is not equal to token given during the sso app registraion or later stage than invalid
  if (
    appToken !== appTokenDB[appName] ||
    sessionApp[globalSessionToken][appName] !== true
  ) {
    return res.status(403).json({ message: "Unauthorized" });
  }
  // checking if the token passed has been generated
  const payload = generatePayload(ssoToken);
  console.log('payloaddddddddddddd', payload)


  const token = await genJwtToken(payload);
  console.log('tokennnnnnnnnnn', token)
  // delete the itremCache key for no futher use,
  delete intrmTokenCache[ssoToken];
  return res.status(200).json({ token });
};

const clearsession =  (req, res, next) => {
  console.log('clear sessionnnnnnnnnnnnnnnnn')
  const appToken = appTokenFromRequest(req);
  const  { serviceURL }  = req.query;
  const { ssoToken } = req.query;
  
  // const payload = generaterePayload(ssoToken); 
  // const token = await genJwtToken(payload);
  delete req.session.user;
  res.clearCookie('id');
  // delete the itremCache key for no futher use,
  delete intrmTokenCache[ssoToken];
  
  //return res.redirect('http://consumer.ankuranand.in:8800/');
  return res.redirect(`${serviceURL}`);
};

const generaterePayload = ssoToken => {
  console.log('here hhhhhhhhhhhhhhhhhhhh')
  const globalSessionToken = '';
  //const appName = intrmTokenCache[ssoToken][1];
  const userEmail = sessionUser[globalSessionToken];
  const user = userDB[userEmail];
  //console.log('uuuuuuuuuuuuuuuuu', appName);
  const shareEmail = true;
  //const appPolicy = appPolicy[appName];
  const username = shareEmail === true ? userEmail : undefined;
  const payload = {
    //...{ ...appPolicy },
    ...{
      username,
      shareEmail: undefined,
      uid: '',
      // global SessionID for the logout functionality.
      globalSessionID: globalSessionToken
    }
  };
  console.log('ppppppppppppppppp', payload)
  return payload;
};


const userDB = {
            sname : {
                          password: "1111",
                          userId: encodedId(), // incase you dont want to share the user-email.
                          appPolicy: {
                          sso_consumer: { role: "admin", shareEmail: true },
                          simple_sso_consumer: { role: "user", shareEmail: false }
                        }
                      }                        
                    
          // "ppp": {
          //   password: "111",
          //   userId: encodedId(), // incase you dont want to share the user-email.
          //   appPolicy: {
          //     sso_consumer: { role: "admin", shareEmail: true },
          //     simple_sso_consumer: { role: "user", shareEmail: false }
          //   }
};

const doLogin = (req, res, next) => {
  //console.log('query qqqqqqqqqqqq', req.query)
  const hurl = req.body.hurl;
  // do the validation with email and password
  // but the goal is not to do the same in this right now,
  // like checking with Datebase and all, we are skiping these section
  const { username, password } = req.body;
  // if (!(userDB[username] && password === userDB[username].password)) {
  //   return res.status(404).json({ message: "Invalid email and password" });
  // }

  var otp = req.body.otp;
  var ipAddress = req.ip;
  var userAgent = req.get('user-agent');
  var remember = !!req.body.remember;
  database.validateUser(username, password, otp, function(err, userId, sname, spassword) {
        if (err) {
            console.log('[Login] Error for ', username, ' err: ', err);
            if (err === 'NO_USER')
                return res.redirect('/#nouserorpass');
             //return res.status(404).json({ message: "Invalid email and password" });
            if (err === 'USER_IS_BLOCKED')
                return res.redirect('/#userisblocked');
              //return res.status(404).json({ message: "Invalid email and password" });
            if (err === 'WRONG_PASSWORD')
                return res.redirect('/#wrongpassword');
              //return res.status(404).json({ message: "Invalid email and password" });
            if (err === 'INVALID_OTP') {
                var warning = otp ? 'Invalid one-time password' : undefined;
                return res.redirect('/#login-mfa', { username: username, password: password, warning: warning });
                //return res.status(404).json({ message: "Invalid email and password" });
            }
            return res.redirect('/#wrongpassword');
            //return res.status(404).json({ message: "Invalid email and password" });
        }

        database.createSession(userId, ipAddress, userAgent, remember, function(err, sessionId, expires) {
            console.log('CookieId',sessionId);

            if(remember)              
                sessionOptions.expires = expires;                

            res.cookie('id', sessionId, sessionOptions);

            const  serviceURL   = hurl;
            console.log('url url', serviceURL)
            const id = encodedId();
            req.session.user = id;
            
            //console.log('ssssssssssssssssssssss', )
            const userid = req.user;
            sessionUser[id] = username;

            if (serviceURL === 'undefined') {
              return res.redirect("/");
            }
            else{
              const url = new URL(serviceURL);
            const intrmid = encodedId();
            storeApplicationInCache(url.origin, id, intrmid);
            return res.redirect(`${serviceURL}?ssoToken=${intrmid}`); 
        }


       
   

        // var ip = req.ip;
        // var geo = geoip.lookup(ip);
        // var location = 'forlocal';
        // //var location = geo['city'];
        // const deviceDetector = new DeviceDetector();
        // const device = deviceDetector.parse(userAgent);
        // var dev_name = device['client']['name'];
        // //console.log('Divice',device['client']['name']);
        // //console.log('user Agent', userAgent);
        // //console.log('LOCATION',location);
        // database.setuserlogs(userId, ipAddress, location, dev_name, function(err, logId) {

        //     if (err)
        //         return next(new Error('Unable to add logs '+ err));            
        // });
    });
  

  // else redirect
   
  });
  
  
 
     

  // // else redirect
  
  // const serviceURL  = hurl;
  // const id = encodedId();

  // console.log('url url', serviceURL)

  // req.user = id;
  // sessionUser[id] = username;
  // if (serviceURL == null) {
  //   return res.redirect("/");
  // }

  
  // const url = new URL(serviceURL);
  // console.log('url origin', url.origin)
  // console.log('uuuuuuuuuuuuuuu', url)
  // const intrmid = encodedId();
  // console.log('encodedId', intrmid)
  // storeApplicationInCache(url.origin, id, intrmid);
  // return res.redirect(`${serviceURL}?ssoToken=${intrmid}`);
};

const login = (req, res, next) => {
  console.log('here here login login login')
  // The req.query will have the redirect url where we need to redirect after successful
  // login and with sso token.
  // This can also be used to verify the origin from where the request has came in
  // for the redirection
  const  { serviceURL }  = req.query;
  //const  { serviceURL }  = 'https://wowkong.wowgo.io';
  // direct access will give the error inside new URL.
  if (serviceURL != null) {
    const url = new URL(serviceURL);
    if (alloweOrigin[url.origin] !== true) {
      return res
        .status(400)
        .json({ message: "Your are not allowed to access the sso-server" });
    }
  }
  console.log('user cccccccccccccccccccc', req.session.user)
  //console.log('url', serviceURL)
  if (req.session.user != null && serviceURL == null) {
    console.log('request from here')
    return res.redirect("/");
  }
  console.log('login login login', req.session.user)
  // if global session already has the user directly redirect with the token
  if (req.session.user != null && serviceURL != null) {
    console.log('request from other')
    const url = new URL(serviceURL);
    const intrmid = encodedId();
    storeApplicationInCache(url.origin, req.session.user, intrmid);
    return res.redirect(`${serviceURL}?ssoToken=${intrmid}`);
  }

  return res.render("forlogin", {
    title: "SSO-Server | Login",
    hurl: serviceURL
  });
};

module.exports = Object.assign({}, { doLogin, login, verifySsoToken, clearsession });
