var async = require('async');
var assert = require('assert');
var bitcoinjs = require('bitcoinjs-lib');
const Web3 = require('web3');
const ethers = require('ethers');
const config = require('./config/config');

const web3 = new Web3(new Web3.providers.HttpProvider(config.ETHEREUM_PROVIDER));

exports.ethersToBits = function(ethers) {
    assert(typeof ethers === 'number');
    return Math.floor(ethers * config.BIT_TO_ETH_RATIO);
}

exports.bitsToEthers = function(bits) {
    assert(typeof bits === 'number');
    return bits / config.BIT_TO_ETH_RATIO;
}
/**
 * Chunk an array by given size
 * @param     {array}        Array to chunk
 * @param     {chunkSize}    The size of each chunk
 * @returns   {array}        Array of array of chunks [[],[], ...]
*/ 
function chunk(array, chunkSize) {
    return [].concat.apply([],
        array.map(function(elem,i) {
            return i%chunkSize ? [] : [array.slice(i,i+chunkSize)];
        })
    );
}

function chunkRun(func, inputs, chunkSize, parallel, callback) { // (doGetTransactionIdsAddresses, txIds, 20, 2, callback}
    var chunks = chunk(inputs, chunkSize);

    //Array of functions with a callback
    var todo = chunks.map(function(chunk) {
        return function(callback) {
            func(chunk, function(err, data) {
                if (err) {
                    console.log('Got ', err, ' on chunk: ', chunk);
                }

                callback(err, data);
            });
        }
    });

    async.parallelLimit(todo, parallel, function(err, results) {
        if (err) return callback(err);
        var total = [].concat.apply([], results);
        callback(null, total);
    });
}

function intersperse(arr, item) {
    var na = [];

    for (var i = 0; i < arr.length; ++i) {
        na.push(arr[i]);
        if (i < arr.length - 1)
            na.push(item);
    }

    return na;
}

function desperse(arr) {
    var na = [];

    for (var i = 0; i < arr.length ; i += 2) {
        na.push(arr[i]);
    }

    return na;
}

function chunkSlow(func, inputs, chunkSize, delay, callback) {

    function slow(callback) {
        setTimeout(function() {  callback(null); }, delay);
    }

    var chunks = chunk(inputs, chunkSize);
    var todo = chunks.map(function(chunk) {
        return function(callback) {
            func(chunk, callback);
        }
    });

    todo = intersperse(todo, slow);

    async.series(todo, function(err, res) {
        if (err)
            return callback(err);

        res = desperse(res);
        res = [].concat.apply([], res);
        callback(null, res);
    });
}

exports.chunk = chunk;
exports.chunkRun = chunkRun;
exports.chunkSlow = chunkSlow;

//========== BITCOIN ===============

// var derivedPubKey = process.env.BIP32_DERIVED_KEY;
// if (!derivedPubKey)
//     throw new Error('Must set env var BIP32_DERIVED_KEY');

// var hdNode = bitcoinjs.HDNode.fromBase58(derivedPubKey);

// exports.deriveAddress = function(index) {
//     return hdNode.derive(index).getAddress().toString();
// };

//========== ETHEREUM ===============
const masterNode = ethers.utils.HDNode.fromMnemonic(config.MNEMONIC);

exports.deriveAddress = function(index) {
    var path = `m/44'/60'/0'/0/${index}`;
    let childNode = masterNode.derivePath(path);
    return childNode.address;
};
//===================================

