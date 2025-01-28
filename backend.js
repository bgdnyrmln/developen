// server.js
const express = require('express');
const appx = express();
const PORT = 3000;

// define the route
appx.get('/',
    (req, res) => {
        res.send(
            `<h1 style="color: red;">
            Hello Gfg xd!</h1>`
        );
    });

appx.listen(PORT,
    () => {
        console.log(
            `Server is listening at port 3000
            http://localhost:${PORT}`
        );
    });
