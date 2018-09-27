var elixir = require('laravel-elixir')
var gulp = require('gulp')

require('laravel-elixir-webpack');

// build out a public version of all of our better organized scripts
elixir(function(mix) {
    mix.browserify('main.js')
    mix.browserify('app.js')
    mix.sass(['boss.scss'], 'public/css/boss.css')
    mix.sass(['store.scss', 'slick-theme.css', 'store-styles.scss'], 'public/css/store.css')
        .scriptsIn('resources/assets/js/controllers', 'resources/assets/js/controllers.js')
        .scriptsIn('resources/assets/js/directives', 'resources/assets/js/directives.js')
        .scriptsIn('resources/assets/js/services', 'resources/assets/js/services.js')
        .babel([
          'angApp.js',
          'helpers.js',
          'slick.js',
          'directives.js',
          'controllers.js',
          'services.js'
        ], 'public/js/angApp.js')
    mix.version(['js/main.js', 'css/app.css', 'css/boss.css', 'css/store.css', 'js/app.js'])
});

// copy modules over to the public folder
gulp.task('copy-modules', function () {
  return gulp.src('./node_modules/**/*')
  .pipe(gulp.dest('public/node_modules')).on('end', function () {
    console.log('The node modules have been copied to the public folder.')
    process.exit()
  })
})
