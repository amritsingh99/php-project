var http = require('http');

var server = http.createServer(function(req, res) {
    res.end('Hello, World\n')
})

server.listen(3000, function() {
    console.log("The server is listening on port 3000")
})