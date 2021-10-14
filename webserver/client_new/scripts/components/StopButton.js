define([
    'react',
    'game-logic/clib',
    'game-logic/stateLib',
    'constants/AppConstants',
    'components/Payout',
    'game-logic/engine',
    'actions/ControlsActions',
], function(
    React,
    Clib,
    StateLib,
    AppConstants,
    PayoutClass,
    Engine,
    ControlsActions,
){

    var D = React.DOM;
    var Payout = React.createFactory(PayoutClass);

    return React.createClass({
        displayName: 'StopButton',

        propTypes: {
            engine: React.PropTypes.object.isRequired,
            // placeBet: React.PropTypes.func.isRequired,
            // cancelBet: React.PropTypes.func.isRequired,
            // cashOut: React.PropTypes.func.isRequired,
            isMobileOrSmall: React.PropTypes.bool.isRequired,
            // betSize: React.PropTypes.string.isRequired,
            // betInvalid: React.PropTypes.any.isRequired,
            // cashOutInvalid: React.PropTypes.any.isRequired,
            // controlsSize: React.PropTypes.string.isRequired
        },

        getInitialState: function() {
            
        },

        componentDidMount: function() {
            
        },

        componentWillUnmount: function() {
            
        },
       
        stopgame: function () {
            //localStorage.setItem('stopgame', 'true');
            ControlsActions.stopgame(); 
        },

        render: function() {            
            return D.div({ className: 'bet-button-container' },
                D.button({  onClick:() => this.stopgame()  },
                    'StopGame'
                )

            );
        }
    });

});