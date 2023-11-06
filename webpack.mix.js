const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js")
    .sourceMaps()
    .vue()
    .postCss("resources/css/app.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
    ])
    .webpackConfig(require("./webpack.config"));
mix.browserSync("http://127.0.0.1:8000/");

// mix.browserSync({
//     proxy: "logexpert.test",
//     open: false,
//     socket: {
//         domain: "localhost:3000",
//     },
// });

// mix.browserSync({
//     proxy: "localhost",
//     host: "localhost:3000",
// });

if (mix.inProduction()) {
    mix.version();
}
