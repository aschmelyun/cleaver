let command = require('node-cmd'),
    AfterWebpack = require('on-build-webpack2');

module.exports = {
    cleaver: new AfterWebpack(() => {
        command.run('php cleaver build', (error, stdout, stderr) => {
            console.log(error ? stderr : stdout);
        });
    })
}