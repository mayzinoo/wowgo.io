var admin = require('./admin'); var assert = require('better-assert'); var lib = require('./lib'); var database 
= require('./database'); var user = require('./user'); var games = require('./games'); var sendEmail = 
require('./sendEmail'); var stats = require('./stats'); var config = require('../config/config'); var 
recaptchaValidator = require('recaptcha-validator'); var logics = require('./logics'); var production =
process.env.NODE_ENV === 'production'; var geoip = require('geoip-lite'); var useragent = require('express-useragent');
var express = require('express'); var http = require('http'); var https=require('https');
 const router = express.Router();
 var eth_client = require('./eth_client');
var tip = require('./tip'); var jwt = require('jsonwebtoken'); const fs = require('fs');
const path = require('path');

function staticPageLogged(page, loggedGoTo) {
    
    return function(req, res) {
        var user = req.user;
        if (!user){
            //console.log(req.query.referral);
            //console.log('req.query.referral');
            if(req.query.referral)
                return res.render(page,{referral:req.query.referral});
            else
            return res.render(page);
        }
        if (loggedGoTo) return res.redirect(loggedGoTo);
        //Add userlogs
        var date = new Date();
        var hour = date.getHours();
        hour = (hour < 10 ? "0" : "") + hour;
        var min = date.getMinutes();
        min = (min < 10 ? "0" : "") + min;
        var sec = date.getSeconds();
        sec = (sec < 10 ? "0" : "") + sec;
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        month = (month < 10 ? "0" : "") + month;
        var day = date.getDate();
        day = (day < 10 ? "0" : "") + day;
        const ipInfo = req.ipInfo;
        //var message = `Hey, you are browsing from ${ipInfo.city}, ${ipInfo.country}`;
        
        // var ipAddress = req.ip;
     //    var userAgent = req.get('user-agent');
     //    var ua = req.headers['user-agent'];
     //    //console.log(ua);
     //    if(ipAddress.substr(0,7) == "::ffff:"){
     //            ipAddress = ipAddress.substr(7)
     //    }
     //    console.log(ipAddress);

     //    var login_time = year + ":" + month + ":" + day + ":" + hour + ":" + min + ":" + sec;
     //    var geo = geoip.lookup(ipAddress);
     //     var location = geo['city'];
     //      var device = req.useragent['browser'];

     //    database.setuserlogs(user.id, login_time, ipAddress,location,device, function(err,logs) {        
     //        console.log(logs);            
     //    });
        //End userlogs
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
    app.get('/', staticPageLogged('index'));
    //app.get('/login', staticPageLogged('login', '/play'));

    
    app.get('/register', function(req, res) {
      const query = req.query;       
      
      return res.render('forreferral', {username : req.query.referral });
        
    });    

    const file = fs.createWriteStream("WoWgo.APK");
    const request = app.get("https://wowgo.io/app", function(response) {
    response.pipe(file).on('close');
      
});   

    app.get('/downloadFile', function(req, res) {
    //return res.download("WoWgo.APK");
    return res.download("WoWgo.APK", (err) => { if(err) console.log(err); });	
});

 app.get('/download',(req, res) => {
  var file = "WoWgo.apk";
  var fileLocation = path.join(file);
  //console.log(fileLocation);
  res.download(file); 
});

    app.get('/newdownload', (req, res) => {
  res.download('WoWgo.apk');
});

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

    // for api
    app.get('/api', function(req,res){
        res.json({
            text: 'my api!'
        });
    });

     app.post('/api/login', function(req, res) {
        const user = { id: req.name };
        const token = jwt.sign( {user}, 'my_secret_key');
        res.json({
            token: token
        }); 
    });

    app.get('/api/protected', ensureToken, function(req, res){
        console.log('ppppppppppppp', req.params.balance);
         jwt.verify(req.token, 'my_secret_key', function(err,data){
            if(err){
                res.render('error');
            }
            else{
                 res.json({
                     text: 'this is protected',  
                     data: data          
                });
            }
         })             
    });
    

    app.put('/api/updatebalance/:senderid/:receiverid', ensureToken, function(req, res) {
        jwt.verify(req.token, 'my_secret_key', function(err,data){
            if(err){
                res.render('error');
            }
            else{
                 const id = parseInt(req.params.id, 10);
                 const senderid = parseInt(req.params.senderid, 10);
                 const receiverid = parseInt(req.params.receiverid, 10);
                 const balance = parseInt(req.body.balance);

                  if (!req.body.balance) {
                    return res.status(400).send({
                      success: 'false',
                      message: 'balance is required',
                    });
                  } else{}

                  const updatedbalance = {
                    senderid: senderid,
                    receiverid: receiverid,
                    balance: balance,
                  };

                  database.updatememberbalance(senderid,receiverid, balance,  function(err) {
                        if (err) {
                            console.log('update error', err);     
                        }        
                        else{
                            return res.status(201).send({
                            success: 'true',
                            message: 'balance updated successfully',
                            updatedbalance,
                          });
                        }    
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
            res.render('error');
        }
    }  
    
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
    app.post('/logout', restrictRedirectToHome, user.logout);
    app.post('/login', user.login);
    app.post('/transfer-referral-amount',user.transferReferralAmount);
    app.post('/register', user.register);
    
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

