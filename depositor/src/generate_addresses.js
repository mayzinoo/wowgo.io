var debug = require('debug')('app:generate_addresses');
var lib = require('./lib');
var config = require('./config/config')


var count = config.GENERATE_ADDRESSES; // how many addresses to watch

debug('Generating %n addresses', count);

console.log('{');

for (var i = 1; i <= count; ++i) {
  var address = lib.deriveAddress(i);
  console.log('"' + address + '": ' + i + (i != count ? ',' : ''));
}

console.log('}');

