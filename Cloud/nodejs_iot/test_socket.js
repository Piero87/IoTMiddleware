var io = require('./node_modules/socket.io').listen(5000);

io.sockets.on('connection', function (socket) {
	
	console.log('a user connected');
});