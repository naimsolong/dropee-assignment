const mix = require('laravel-mix');

require('laravel-mix-svelte');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


const findPath = {
    vendor: {
        css: {
            resources: function(vendor, filePath) {
                return 'resources/vendor/'+vendor+'/sass/'+filePath
            },
            public: function(vendor, filePath) {
                return 'public/vendor/'+vendor+'/css/'+filePath
            }
        },
        js: {
            resources: function(vendor, filePath) {
                return 'resources/vendor/'+vendor+'/js/'+filePath
            },
            public: function(vendor, filePath) {
                return 'public/vendor/'+vendor+'/js/'+filePath
            }
        },
    },
    modules: {
        css: {
            resources: function(module, filePath) {
                return 'Modules/'+module+'/Resources/assets/sass/'+filePath
            },
            public: function(module, filePath) {
                return 'public/modules/'+module+'/css/'+filePath
            }
        },
        js: {
            resources: function(module, filePath) {
                return 'Modules/'+module+'/Resources/assets/js/'+filePath
            },
            public: function(module, filePath) {
                return 'public/modules/'+module+'/js/'+filePath
            }
        },
    }
};

mix
.sass(
    findPath.vendor.css.resources('bootstrap','bootstrap.scss'),
    findPath.vendor.css.public('bootstrap','bootstrap.css')
)
.js(
    findPath.vendor.js.resources('bootstrap','bootstrap.js'),
    findPath.vendor.js.public('bootstrap','bootstrap.js')
)
.js(
    findPath.vendor.js.resources('dropee','form.js'),
    findPath.vendor.js.public('dropee','form.js')
);

mix.js(
    findPath.modules.js.resources('Admin','app.js'),
    findPath.modules.js.public('Admin','app.js')
).svelte();