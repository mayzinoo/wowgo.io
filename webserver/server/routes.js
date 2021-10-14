var admin = require('./admin'); var assert = require('better-assert'); var lib = require('./lib'); var database 
= require('./database'); var user = require('./user'); var games = require('./games'); var sendEmail = 
require('./sendEmail'); var stats = require('./stats'); var config = require('../config/config'); var 
recaptchaValidator = require('recaptcha-validator'); var logics = require('./logics'); var production =
process.env.NODE_ENV === 'production'; var geoip = require('geoip-lite'); var useragent = require('express-useragent');
var express = require('express'); var http = require('http'); const router = express.Router(); var eth_client = require('./eth_client');
var tip = require('./tip'); const fs = require('fs'); const jwt = require('jsonwebtoken');
const session = require("express-session");
var bodyParser = require('body-parser');

const URL = require("url").URL;
const controller = require("../controller");

const isAuthenticatedlogout = require("./isAuthenticatedlogout");

function staticPageLogged(page, loggedGoTo) {
    
    return function(req, res) {
        var user = req.user;
        //console.log('user user', user)
        //console.log('login cache', JSON.stringify(req.user))
        if (!user){
            //console.log(req.query.referral);
            //console.log('req.query.referral');
            if(req.query.referral)
                return res.render(page,{referral:req.query.referral});
            else
            return res.render(page);
        }
        if (loggedGoTo) return res.redirect(loggedGoTo);
        
        res.render(page, {
            user: user
        });
    }
}
 
function contact(origin) {
    assert(typeof origin == 'string');
    return function(req, res, next) {
        var user = req.user;
        var from = req.body.email;
        var message = req.body.message;
        if (!from ) return res.render(origin, { user: user, warning: 'email required' });
        if (!message) return res.render(origin, { user: user, warning: 'message required' });
        if (user) message = 'user_id: ' + req.user.id + '\n' + message;
        sendEmail.contact(from, message, null, function(err) {
            if (err)
                return next(new Error('Error sending email: \n' + err ));
            return res.render(origin, { user: user, success: 'Thank you for writing, one of my humans will write you back very soon :)' });
        });
    }
}
function restrict(req, res, next) {
    if (!req.user) {
       res.status(401);
       if (req.header('Accept') === 'text/plain')
          res.send('Not authorized');
       else
          res.render('401');
       return;
    } else
        next();
}
function restrictRedirectToHome(req, res, next) {
    if(!req.user) {
        res.redirect('/');
        return;
    }
    next();
}
function adminRestrict(req, res, next) {
    // if (!req.user || !req.user.admin) {
    //     res.status(401);
    //     if (req.header('Accept') === 'text/plain')
    //         res.send('Not authorized');
    //     else
    //         res.render('401'); //Not authorized page.
    //     return;
    // }
    next();
}
function recaptchaRestrict(req, res, next) {
  var recaptcha = lib.removeNullsAndTrim(req.body['g-recaptcha-response']);
  
  recaptchaValidator.callback(config.RECAPTCHA_PRIV_KEY, recaptcha, req.ip, function(err) {
    if (err) {
      if (typeof err === 'string')
        res.send('Got recaptcha error: ' + err + ' please go back and try again');
      else {
        console.error('[INTERNAL_ERROR] Recaptcha failure: ', err);
        res.render('error');
      }
      return;
    }
    next();
  });
}
function table() {
    return function(req, res) {
        res.render('table_old', {
            user: req.user,
            table: true
        });
    }
}
function tableNew() {
    return function(req, res) {
        res.render('table_new', {
            user: req.user,
            buildConfig: config.BUILD,
            table: true
        });
    }
}
function tableDev() {
    return function(req, res) {
        if(config.PRODUCTION)
            return res.status(401);
        requestDevOtt(req.params.id, function(devOtt) {
            res.render('table_new', {
                user: req.user,
                devOtt: devOtt,
                table: true
            });
        });
    }
}
function requestDevOtt(id, callback) {
    var curl = require('curlrequest');
    var options = {
        url: 'https://www.dlkfdsj.com/ott',
        include: true ,
        method: 'POST',
        'cookie': 'id='+id
    };
    var ott=null;
    curl.request(options, function (err, parts) {
        parts = parts.split('\r\n');
        var data = parts.pop()
            , head = parts.pop();
        ott = data.trim();
        console.log('DEV OTT: ', ott);
        callback(ott);
    });
}

module.exports = function(app) {

    app.use(
      session({
        secret: "keyboard cat",
        resave: false,
        saveUninitialized: true
      })
    );
    app.use((req, res, next) => {
      console.log(req.session);
      next();
    });
    //app.use(express.urlencoded({ extended: true }));
    //app.use(express.json());
    app.use(bodyParser.json());
    app.use(bodyParser.urlencoded({ extended: true }));
    
    //app.get('/', staticPageLogged('index'));

    app.get("/", (req, res, next) => {
        //console.log('session next next', req.session);
        var current_user = req.session.user;
        console.log('current userrrrrr', current_user)
        if(current_user === undefined){
             res.render("index", {
             user: req.user
            }); 
        }
        else{
            res.render("index", {
            what: req.session.user ,
            user: req.user
      });
        }
      
    });

    app.get('/register', function(req, res) {
      const query = req.query;       
      
      return res.render('forreferral', {username : req.query.referral });
        
    }); 

    /** For login cache  **/
     app.get("/simplesso/deletesession", controller.clearsession);   
     app.get("/simplesso/verifytoken", controller.verifySsoToken);
     app.get("/simplesso/login", controller.login);
     app.post("/login", controller.doLogin);


    // app.get('/login', function(req, res) {
    //     var url1 = req.headers.host;
    //     console.log('uuuuuuuuuu', url1)
    //   // The req.query will hav,e the redirect url where we need to redirect after successful
    //   // login and with sso token.
    //   // This can also be used to verify the origin from where the request has came in
    //   // for the redirection
    //   const { serviceURL } = req.query;
    //   // direct access will give the error inside new URL.
    //   if (serviceURL != null) {
        
    //     const url = new URL(serviceURL);
    //     console.log('uuuuuuuuuu', url.origin)
    //     if (alloweOrigin[url.origin] !== true) {
    //       return res
    //         .status(400)
    //         .json({ message: "Your are not allowed to access the sso-server" });
    //     }
    //   }
    //   console.log('user user', req.user)
    //   console.log('url url', serviceURL)
    //   if (req.user != null && serviceURL == null) {       
    //     return res.redirect("/");
    //   }
    //   // if global session already has the user directly redirect with the token
    //   if (req.user != null && serviceURL != null) {
    //     console.log('hjhhhhhhhhhh')
    //     const url = new URL(serviceURL);
    //     const intrmid = encodedId();
    //     storeApplicationInCache(url.origin, req.user, intrmid);
    //     return res.redirect(`${serviceURL}?ssoToken=${intrmid}`);
    //   }

    //   return res.render("forlogin", {
    //     title: "SSO-Server | Login"
    //   });
        
    // }); 

//     const file = fs.createWriteStream("WoWgo.apk");
//     const request = app.get("http://localhost:2053", function(response) {        
//     response.pipe(file);
// });

//     app.get('/downloadFile', function(req, res) {
//     return res.download('WoWgo.apk');
// });

    app.get('/newdownload', (req, res) => {
  res.download('WoWgo.apk');
});

    //app.get('/', staticPageLogged('index'));
    app.get('/stoptime', user.stoptime);
    app.get('/register/:referral', user.contact);
    app.get('/reset/:recoverId', user.validateResetPassword);
    app.get('/faq', staticPageLogged('faq'));
    app.get('/contact', staticPageLogged('contact'));
    app.get('/request', user.request);
    app.get('/support', restrict, user.contact);
    app.get('/account', restrict, user.account);
    app.get('/referral', restrict, user.referral);
    app.get('/security', restrict, user.security);
    app.get('/forgot-password', staticPageLogged('forgot-password'));
    app.get('/calculator', staticPageLogged('calculator'));
    app.get('/guide', staticPageLogged('guide'));
    app.get('/wallet', restrict, user.wallet);
    app.get('/deposit', restrict, user.deposit);    
    app.get('/withdraw', restrict, user.withdraw);
    app.get('/withdraw/request', restrict, user.withdrawRequest);
    app.get('/tip', restrict, user.tip);
    app.get('/tip-send', restrict, user.tipSend);
    app.get('/play-old', table());
    app.get('/play', tableNew());
    app.get('/play-id/:id', tableDev());
    app.get('/leaderboard', games.getLeaderBoard);
    app.get('/game/:id', games.show);
    app.get('/user/:name', user.profile);
    app.get('/withdraw-info/:id', restrict, user.withdrawinfo);   

    app.get('/confirmwithdraw/:id' , user.sendwithdraw );

    // app.get('/dashboard' , function(req,res) {
    //     return res.redirect('/admin_dashboard');
    
    // }); 
    
    app.get('/error', function(req, res, next) { // Sometimes we redirect people to /error
      return res.render('error');
    });
    app.post('/request', user.giveawayRequest);
    app.post('/sent-reset', user.resetPasswordRecovery);
    app.post('/sent-recover', recaptchaRestrict, user.sendPasswordRecover);
    app.post('/reset-password', restrict, user.resetPassword);
    app.post('/edit-email', restrict, user.editEmail);
    app.post('/enable-2fa', restrict, user.enableMfa);
    app.post('/disable-2fa', restrict, user.disableMfa);
    app.post('/deposit-request', restrict, user.handleDepositRequest);
    app.post('/new-withdraw-request', restrict, user.handlenewWithdrawRequest);
    app.post('/withdraw-request', restrict, user.handleWithdrawRequest);
    app.post('/cancel-withdraw', restrict, user.cancelWithdraw);
    app.post('/cancel-deposit', restrict, user.cancelDeposit);
    app.post('/tip-send', restrict, user.handleTipSend);
    app.post('/support', restrict, contact('support'));
    app.post('/contact', contact('contact'));
    //app.post('/logout', restrictRedirectToHome, user.logout);
    //app.post('/login', user.login);
    app.post('/transfer-referral-amount',user.transferReferralAmount);
    app.post('/register', user.register);

    app.post("/logout", isAuthenticatedlogout, (req, res, next) => {
        var sessionId = req.cookies.id;
        var userId = req.user.id;

        console.log('uuuuuuuuuuuuuuuuuuu', userId);
        database.expireSessionsByUserId(userId, function(err) {
            if (err)
            return next(new Error('Unable to logout got error: \n' + err));
            res.redirect('/');
       });
        
    }); 

    // for api
    app.get('/api', function(req,res){
        res.json({
            text: 'my api!'
        });
    });

     app.post('/api/login', restrict, function(req, res) {
        const user = { id: 3 };
        const token = jwt.sign( {user}, 'my_secret_key');
        res.json({
            token: token
        }) 
    });

    app.get('/api/protected', ensureToken, function(req, res){
        jwt.verify(req.token, 'my_secret_key', function(err, data){
            if(err) {
                res.sendStatus(403);
            } else{
                res.json({
                    text: 'this is protected',
                    data:data
                });
            }
        })
    });

    function ensureToken(req,res,next){
        const bearerHeader = req.headers["authorization"];
        if(typeof bearerHeader !== 'undefined') {
            const bearer = bearerHeader.split(" ");
            const bearerToken = bearer[1];
            req.token = bearerToken;
            next();
        }
        else{
            res.sendStatus(403);
        }
    }  

    
    // ott: one-time token
    app.post('/ott', restrict, function(req, res, next) {
        var user = req.user;
        var ipAddress = req.ip;
        var userAgent = req.get('user-agent');
        assert(user);
        database.createOneTimeToken(user.id, ipAddress, userAgent, function(err, token) {
            if (err) {
                console.error('[INTERNAL_ERROR] unable to get OTT got ' + err);
                res.status(500);
                return res.send('Server internal error');
            }
            res.send(token);
        });
    });

    // get withdraw status

    app.get('/stats', stats.index);
    // Admin stuff
    app.get('/admin/options', adminRestrict, admin.options);
    app.post('/admin/options', adminRestrict, admin.updateOptions);
    app.get('/admin/giveaway', adminRestrict, admin.giveAway);
    app.post('/admin/giveaway', adminRestrict, admin.giveAwayHandle);
    
    app.get('*', function(req, res) {
        res.status(404);
        res.render('404');
    });


};

