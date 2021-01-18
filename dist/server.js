const express = require('express');
const { fork, exec } = require('child_process');
const cors = require('cors');
const { response } = require('express');
require('dotenv').config();

const app = express();
app.use(cors());

app.get('/', (req, res) => {
    exec("php predict_server.php " + req.data, (error, stdout, stderr) => {
        if (error) {
            console.log(`error: ${error.message}`);
            return;
        }
        if (stderr) {
            console.log(`stderr: ${stderr}`);
            return;
        }
        console.log(`stdout: ${stdout}`);
        res.send(stdout);
    });
});

app.listen(process.env.APP_PORT || 6618, () => console.log('ML server listening on port ' + process.env.APP_PORT + '!'));