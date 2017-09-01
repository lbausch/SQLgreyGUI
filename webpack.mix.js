let mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.disableNotifications()

mix.browserSync({
  open: false,
  proxy: 'sqlgreygui.local',
  files: [
    'app/**/*.php',
    'resources/views/**/*.php',
    'resources/views/**/*.twig',
    'public/assets/js/**/*.js',
    'public/assets/css/**/*.css'
  ]
})

mix.setPublicPath('public/assets')
mix.setResourceRoot('/assets/')

mix.sass('resources/assets/scss/style.scss', 'css')
  .js('resources/assets/js/app.js', 'js')
  .js('resources/assets/js/public.js', 'js')
  .extract([
    'axios',
    'bootstrap-vue',
    'lodash',
    'vue',
    'vuex',
    'vue-events',
    'vue-focus',
    'vue-sweetalert'
  ])

if (mix.inProduction()) {
  mix.version()

  // https://github.com/ratiw/vuetable-2/issues/41#issuecomment-275484453
  mix.webpackConfig({
    module: {
      rules: [{
        test: /\.js?$/,
        exclude: /(bower_components)/,
        use: [{
          loader: 'babel-loader',
          options: mix.config.babel()
        }]
      }]
    }
  })
}
