const mix = require("laravel-mix");
const fs = require("fs");
const path = require("path")

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

mix.styles(
    [
        "resources/css/bootstrap.css",
        "resources/css/date-picker-bootstrap.css",
        "resources/css/responsive.css",
        "resources/css/ui.css",
    ],
    "public/css/admin.css"
).copyDirectory("resources/fonts", "public/fonts")
.copyDirectory("resources/js/lib", "public/js/lib")
.js("resources/js/script.js", "public/js");

fs.readdirSync("resources/js/view").forEach((file) => {
    mix.js(
        `resources/js/view/${file}`,
        `public/js/view/${path.parse(file).name}.min.js`
    );
});
