var assert = require('assert');
var ethClient = require('./eth_client');
var database = require('./database');
var request = require('request');
var config = require('../config/config');


module.exports = function(userid,deposit_address, currency_type, currency_amt, wow_amt, deposit_name, status,  callback) {
// console.log('uuuuuuuuuuuuu',userid);
//  console.log('ddddddddddddd',deposit_address);
//  console.log('cccccccccccc', currency_type);
//  console.log('caaaaaaaaaaaaa',currency_amt);
//  console.log('wwwwwwwwwwwww', wow_amt);
//  console.log('dddddddddddddd', deposit_name);
//  console.log('ssssssssssssss', status);
 

   database.requestdepositgqc(userid, deposit_address, currency_type, currency_amt, wow_amt, deposit_name, status,   function (err, reqId) {

        if (err) {
            if (err.code === '23514')
                callback('NOT_ENOUGH_MONEY');
            else if(err.code === '23505')
                callback('SAME_TIP_ID');
            else
                callback(err);
            return;
        }
        else{ callback(); }
        
    });
};
