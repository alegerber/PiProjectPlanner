var Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .autoProvidejQuery()
    .addEntry('js/app', [
        './node_modules/jquery/dist/jquery.slim.js',
        './node_modules/popper.js/dist/umd/popper.min.js',
        './node_modules/bootstrap/dist/js/bootstrap.min.js',
        './assets/js/app.js'
    ])
    .addEntry('js/tab-form', [
        './node_modules/bloodhound-js/dist/bloodhound.min.js',
        './node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
        './assets/js/tab-form.js'
    ])
    .addEntry('js/dropzone', [
        './node_modules/dropzone/dist/dropzone.js'
    ])
    .addEntry('js/media', [
        './assets/js/media.js'
    ])
    .addStyleEntry('css/app', [
        './node_modules/bootstrap/dist/css/bootstrap.min.css',
        './assets/scss/app.scss',
    ])
    .addStyleEntry('css/tab-form', [
        './assets/scss/tab-form.scss'
    ])
    .addEntry('css/dropzone', [
        './node_modules/dropzone/dist/dropzone.css'
    ])
    .addStyleEntry('css/media', [
        './assets/scss/media.scss'
    ])

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
