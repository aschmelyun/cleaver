let command = require('node-cmd'),
    AfterWebpack = require('on-build-webpack');

module.exports = {
    cleaver: new AfterWebpack(() => {
        command.get('php cleaver', (error, stdout, stderr) => {
            console.log(error ? stderr : stdout);
        });
    })
}