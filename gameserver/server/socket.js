//var CBuffer = require('CBuffer');
var socketio = require('socket.io');
var database = require('./database');
var lib = require('./lib');

module.exports = function(server,game,chat) {
  var io = socketio(server);
  //console.log(server);
 
 //io.configure(function () {
  //io.set("transports", ["xhr-polling"]);
 //});
//     var io.configure(function () {
//   io.set("transports", ["xhr-polling"]);
// });

    (function() {
        function on(event) {
            game.on(event, function (data) {
                io.to('joined').emit(event, data);
            });
        }

        on('game_starting');
        on('game_started');
        on('game_tick');
        on('game_crash');
        on('cashed_out');
        on('player_bet');
    })();

    // Forward chat messages to clients.
   chat.on('msg', function (msg) { io.to('joined').emit('msg', msg); });
    chat.on('modmsg', function (msg) { io.to('moderators').emit('msg', msg); });

   
    io.on('connection', onConnection);

  
    function onConnection(socket) {
   
      // socket.request.headers.host = 'www.wowgo.io:8443';
      // socket.request.headers.referer = 'www.wowgo.io:8443/play';
      // socket.request.headers.origin  = 'www.wowgo.io:8443/play';  
    //console.log(socket);    
          socket.once('join', function(info) {
            console.log('socket join')
            // console.log(info.ott);

            // // if (typeof ack !== 'function')
            // //     return sendError(socket, '[join] No ack function');

            // // if (typeof info !== 'object')
            // //     return sendError(socket, '[join] Invalid info');

            // var ott = info.ott;
            // console.log('ott ott', ott);
            // if (ott) {
            //     if (!lib.isUUIDv4(ott))
            //         return sendError(socket, '[join] ott not valid');

                database.validateOneTimeToken( function (err, user) {
                    if (err) {
                        if (err == 'NOT_VALID_TOKEN')
                            return ack(err);
                        return internalError(socket, err, 'Unable to validate ott');
                    }
                    console.log('no error')
                    console.log(user)
                    cont(user);
                });
            


            function cont(loggedIn) {
                console.log(loggedIn);
                if (loggedIn) {
                    loggedIn.admin     = loggedIn.userclass === 'admin';
                    loggedIn.moderator = loggedIn.userclass === 'admin' ||
                        loggedIn.userclass === 'moderator';
                }

                var res = game.getInfo();
               // res['chat'] = chat.getHistory(loggedIn);
                res['table_history'] = game.gameHistory.getHistory();
                res['username'] = loggedIn ? loggedIn.username : null;
                res['balance'] = loggedIn ? loggedIn.balance : null;
                
               if(loggedIn && loggedIn.user_type === 'sitemanager'){
                    res['role'] = loggedIn.user_type ;
                }
                else{
                    res['role'] = '';
                }
                console.log('rrrrrrrrrrrrrrrrrrrr',loggedIn.user_type)
                //ack(null, res);

                joined(socket, loggedIn);
            }
        });

    }

    var clientCount = 0;

    function joined(socket, loggedIn) {
        
        ++clientCount;
        console.log('Client joined: ', clientCount, ' - ', loggedIn ? loggedIn.username : '~guest~');

        socket.join('joined');
        if (loggedIn && loggedIn.moderator) {
            socket.join('moderators');
        }

        socket.on('disconnect', function() {
            --clientCount;
            console.log('Client disconnect, left: ', clientCount);

            if (loggedIn)
                game.cashOut(loggedIn, function(err) {
                    if (err && typeof err !== 'string')
                        console.log('Error: auto cashing out got: ', err);

                    if (!err)
                        console.log('Disconnect cashed out ', loggedIn.username, ' in game ', game.gameId);
                });
        });

        if (loggedIn)
        socket.on('place_bet', function(amount, autoCashOut, ack) {

            if (!lib.isInt(amount)) {
                return sendError(socket, '[place_bet] No place bet amount: ' + amount);
            }
            //if (amount <= 0 || !lib.isInt(amount / 100)) {
            if (amount <= 0) {
                return sendError(socket, '[place_bet] Must place a bet in multiples of 100, got: ' + amount);
            }

            if (amount > 1e8) // 1 BTC limit
                return sendError(socket, '[place_bet] Max bet size is 1 BTC got: ' + amount);

            if (!autoCashOut)
                return sendError(socket, '[place_bet] Must Send an autocashout with a bet');

            else if (!lib.isInt(autoCashOut) || autoCashOut < 100)
                return sendError(socket, '[place_bet] auto_cashout problem');

            if (typeof ack !== 'function')
                return sendError(socket, '[place_bet] No ack');

            game.placeBet(loggedIn, amount, autoCashOut, function(err) {
                if (err) {
                    if (typeof err === 'string')
                        ack(err);
                    else {
                        console.error('[INTERNAL_ERROR] unable to place bet, got: ', err);
                        ack('INTERNAL_ERROR');
                    }
                    return;
                }

                ack(null); // TODO: ... deprecate
            });
        });

        socket.on('cash_out', function(ack) {
            if (!loggedIn)
                return sendError(socket, '[cash_out] not logged in');

            if (typeof ack !== 'function')
                return sendError(socket, '[cash_out] No ack');

            game.cashOut(loggedIn, function(err) {
                if (err) {
                    if (typeof err === 'string')
                        return ack(err);
                    else
                        return console.log('[INTERNAL_ERROR] unable to cash out: ', err); // TODO: should we notify the user?
                }

                ack(null);
            });
        });

        socket.on('cash_out_all', function(ack) {
            if (!loggedIn)
                return sendError(socket, '[cash_out] not logged in');

            if (loggedIn.userclass !== 'admin')
                return sendError(socket, '[cash_out] not authorized');

            if (typeof ack !== 'function')
                return sendError(socket, '[cash_out] No ack');

            var at = Date.now();
            game.cashOutAll(at, function(err) {
                if (err) {
                    if (typeof err === 'string')
                        return ack(err);
                    else
                        return console.log('[INTERNAL_ERROR] unable to cash out: ', err); // TODO: should we notify the user?
                }

                ack(null);
            });
        });

        socket.on('say', function(message) {
            if (!loggedIn)
                return sendError(socket, '[say] not logged in');

            if (typeof message !== 'string')
                return sendError(socket, '[say] no message');

            if (message.length == 0 || message.length > 500)
                return sendError(socket, '[say] invalid message side');

            var cmdReg = /^\/([a-zA-z]*)\s*(.*)$/;
            var cmdMatch = message.match(cmdReg);

            if (cmdMatch) {
                var cmd  = cmdMatch[1];
                var rest = cmdMatch[2];

                switch (cmd) {
                case 'shutdown':
                    if (loggedIn.admin) {
                        game.shutDown();
                    } else {
                        return sendErrorChat(socket, 'Not an admin.');
                    }
                    break;
                case 'mute':
                case 'shadowmute':
                    if (loggedIn.moderator) {
                        var muteReg = /^\s*([a-zA-Z0-9_\-]+)\s*([1-9]\d*[dhms])?\s*$/;
                        var muteMatch = rest.match(muteReg);

                        if (!muteMatch)
                            return sendErrorChat(socket, 'Usage: /mute <user> [time]');

                        var username = muteMatch[1];
                        var timespec = muteMatch[2] ? muteMatch[2] : "30m";
                        var shadow   = cmd === 'shadowmute';

                        chat.mute(shadow, loggedIn, username, timespec,
                                  function (err) {
                                      if (err)
                                          return sendErrorChat(socket, err);
                                  });
                    } else {
                        return sendErrorChat(socket, 'Not a moderator.');
                    }
                    break;
                case 'unmute':
                    if (loggedIn.moderator) {
                        var unmuteReg = /^\s*([a-zA-Z0-9_\-]+)\s*$/;
                        var unmuteMatch = rest.match(unmuteReg);

                        if (!unmuteMatch)
                            return sendErrorChat(socket, 'Usage: /unmute <user>');

                        var username = unmuteMatch[1];
                        chat.unmute(
                            loggedIn, username,
                            function (err) {
                                if (err) return sendErrorChat(socket, err);
                            });
                    }
                    break;
                default:
                    socket.emit('msg', {
                        time: new Date(),
                        type: 'error',
                        message: 'Unknown command ' + cmd
                    });
                    break;
                }
                return;
            }

            chat.say(socket, loggedIn, message);
        });

    }

    function sendErrorChat(socket, message) {
        console.warn('Warning: sending client: ', message);
        socket.emit('msg', {
            time: new Date(),
            type: 'error',
            message: message
        });
    }

    function sendError(socket, description) {
        console.warn('Warning: sending client: ', description);
        socket.emit('err', description);
    }

    function internalError(socket, err, description) {
        console.error('[INTERNAL_ERROR] got error: ', err, description);
        socket.emit('err', 'INTERNAL_ERROR');
    }
};
