let mix = require('laravel-mix'),
    build = require('./cleaver.build.js'),
    command = require('node-cmd');

require('mix-tailwindcss');

mix.disableNotifications();
mix.webpackConfig({
    plugins: [
        build.cleaver
    ],
    devServer: {
        contentBase: path.join(__dirname, 'dist')
    }
});

mix.setPublicPath('./')
   .js('resources/assets/js/app.js', 'dist/assets/js')
   .sass('resources/assets/sass/app.scss', 'dist/assets/css')
   .options({
       processCssUrls: false
   })
   .tailwind('./tailwind.config.js')
   .version();

mix.browserSync({
    files: [
        "dist/**/*",
        {
            match: ["resources/**/*"],
            fn: function(event, file) {
                command.get('php cleaver build', (error, stdout, stderr) => {
                    console.log(error ? stderr : stdout);
                });
            }
        }
    ],
    proxy: 'localhost:8080'
});