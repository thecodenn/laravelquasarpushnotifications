const express = require("express");
const app = express();

// const http = require("https");
const http = require("http");
const socketIo = require("socket.io");

const redis = require("redis");
const fs = require("fs");

/* 
  const options = {
  key: fs.readFileSync("/etc/letsencrypt/live/channels.softsmart.co.za/privkey.pem"),
  cert: fs.readFileSync("/etc/letsencrypt/live/channels.softsmart.co.za/fullchain.pem")
}
*/
const options = {};

const server = http.createServer(options, app);
const io = socketIo(server, {
        cors: {
                origin: "*",
        }
});

console.log("server listening on port 8088");
server.listen(8088);

io.on("connection", socket => {

        console.log("socket on connection");

        const subscriber = getRedisClient();

        (async () => {
                await subscriber.connect();
        })();


        socket.on("pushy-page", (clientChannel) => {
                console.log("pushy-page: client connect with: " + clientChannel);
                subscriber.subscribe(clientChannel, (message, channel) => {
                        console.log(`Received ${message} from ${channel}`);

                        socket.emit(clientChannel, message);
                });

                console.log("subscribed to " + clientChannel);
        });


        socket.on("disconnect", () => {
                console.log("disconnected");
                subscriber.quit();
        });

        socket.emit("connected");
});


const getRedisClient = () => {
        const redisClient = redis.createClient({
                socket: {
                        host: "127.0.0.1",
                        port: 6379,
                },
        });

        redisClient.on("error", function(err) {
                console.error("redis error: ", err);
        });

        redisClient.on("ready", () => {
                console.log("connected to redis");
        });

        console.log("returning redisClient");
        return redisClient;
}

