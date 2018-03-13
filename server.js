var app = require('express')(); 
var server = require('http').Server(app);
var io = require('socket.io')(server);
var debug = require('debug')('Tranxit:Chat');
var request = require('request');
var port = process.env.PORT || '3000';

process.env.DEBUG = '*';
// process.env.DEBUG = '*,-express*,-engine*,-send,-*parser';

server.listen(port);

io.on('connection', function (socket) {

    var request_id = 'unassigned';
    var route = [];

    console.log('new connection established');

    socket.emit('connected', 'Connection to server established!');

    if(route.length) {
        soocket.emit('location update', route[route.length]);
    }

    socket.on('update sender', function(data) {
        console.log('update sender', data);
        request_id = data.request_id;
        socket.join(request_id);
        socket.emit('sender updated', 'Sender Updated ID:'+request_id);
    });

    socket.on('update location', function(data) {
        console.log('update location', data);
        data.timestamp = new Date();
        if(route.length) {
            if(route[route.length-1].latitude != data.latitude && route[route.length-1].longitude != data.longitude) {
                console.log('location update route exists'+request_id);
                route.push(data);
                socket.broadcast.to( request_id ).emit('location update', data);
            }
        } else {
            console.log('location update no route'+request_id);
            route.push(data);
            socket.broadcast.to( request_id ).emit('location update', data);
        }
    });

    socket.on('send message', function(data) {

        if(data.type == 'up') {
            receiver = 'pu' + data.provider_id;
        } else {
            receiver = 'up' + data.user_id;
        }

        console.log('data', data);
        console.log('receiver', receiver);

        socket.broadcast.to( receiver ).emit('message', data);

        // url = 'http://dev.xuber.com/message/save?user_id='+data.user_id
        // url = 'http://xuber.appoets.co/message/save?user_id='+data.user_id
        // +'&provider_id='+data.provider_id
        // +'&message='+data.message
        // +'&type='+data.type
        // +'&request_id='+socket.reqid;

        // console.log(url);

        // request(url, function (error, response, body) {
        //     if (!error && response.statusCode == 200) {
        //         // console.log(body); // Show the HTML for the Google homepage. 
        //     }
        // });
    });

    socket.on('disconnect', function(data) {
        console.log('disconnect', data);
    });
});