const mix = require("laravel-mix");

mix.options({
    processCssUrls: false
});

// Compile assets into the module’s own dist folder
mix.setPublicPath("Resources/dist");

mix.js("Resources/assets/js/basic.js", "js/schoolviser.basic.js")
    .js("Resources/assets/js/tertiary_students.js", "js/tertiary_students.js")
    .vue()
    .sass("Resources/assets/sass/basic.scss", "css/schoolviser.basic.css");

if (mix.inProduction()) {
    mix.version();
}
