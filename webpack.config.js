var Encore = require('@symfony/webpack-encore');
var webpack = require('webpack');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', [
        './assets/css/app.less',
        './assets/css/app.scss',
    ])

    .addEntry('js/backend', './assets/js/backend.js')
    .addStyleEntry('css/backend', [
        './assets/css/backend.less',
        './assets/css/backend.scss',
    ])

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
    .enableLessLoader()

// uncomment for legacy applications that require $/jQuery as a global variable
// .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
// module.exports.plugins.push(
//     new webpack.ProvidePlugin({
//         $: "jquery",
//         jQuery: "jquery",
//     })
// );
// module.exports.plugins.push(
//     new webpack.optimize.UglifyJsPlugin({
//         minimize: true,
//         compress: {
//             warnings: false
//         }
//     })
// );
