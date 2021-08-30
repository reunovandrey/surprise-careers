/*
* run "npm install" to install all dependencies from package.json or run those manually:
npm install gulp gulp-sass gulp-concat gulp-uglify-es gulp-sourcemaps gulp-autoprefixer gulp-notify --save
*
*/

'use strict';

var gulp =      require('gulp'),
sass =          require('gulp-sass'),
concat =        require('gulp-concat'),
uglify =        require('gulp-uglify-es').default,
sourcemaps =    require('gulp-sourcemaps'),
autoprefixer =  require('gulp-autoprefixer'),
livereload =    require('gulp-livereload'),
notify =        require('gulp-notify');

var notifyOptions = {
  message : 'Error:: <%= error.message %> \nLine:: <%= error.line %> \nCode:: <%= error.extract %>'
};

/*
* compile theme scss
*/
gulp.task('theme-styles', function(){
  return gulp
  .src('./../assets/sass/theme.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer())
  .pipe(concat('theme.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../assets/public/'))
  .pipe(livereload());
});

gulp.task('blocks-styles', function(){
  return gulp
  .src('./../assets/sass/template-blocks/*.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../assets/public/template-blocks/'))
  .pipe(livereload());
});

gulp.task('pages-styles', function(){
  return gulp
  .src('./../assets/sass/pages/*.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../assets/public/pages/'))
  .pipe(livereload());
});
/*
* compile theme js
*/
gulp.task('theme-scripts', function() {
  return gulp
  .src('./../assets/js/*.js')
  .pipe(concat('theme.min.js'))
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../assets/public/'))
  .pipe(livereload());
});

gulp.task('blocks-scripts', function() {
  return gulp
  .src('./../assets/js/template-blocks/*.js')
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../assets/public/template-blocks/'))
  .pipe(livereload());
});

// Internal Plugins
gulp.task('internal-plugins', function() {
  return gulp
  .src('./../assets/js/plugins/*.js')
  .pipe(sourcemaps.init())
  .pipe(uglify())
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../assets/public/plugins/'))
  .pipe(livereload());
});

/*
* wrap front styling for gutenberg admin
*/
gulp.task('gtb-styles', function(){
  return gulp
  .src('./../assets/sass/gutenberg/gutenberg.scss')
  .pipe(sourcemaps.init())
  .pipe(sass({outputStyle: 'compressed'}).on('error',  notify.onError(notifyOptions)))
  .pipe(autoprefixer())
  .pipe(concat('gutenberg.min.css'))
  .pipe(sourcemaps.write('.'))
  .pipe(gulp.dest('./../inc/gutenberg/'));
});

/* run task for continuous track of theme scss files */
gulp.task('default', function(){
  livereload.listen();
  // track general scss styles
  gulp.watch(['./../assets/sass/**/*.scss','!./../assets/sass/template-blocks','!./../assets/sass/pages','!./../assets/sass/utilities'], { usePolling: true },  gulp.series('theme-styles'));

  // track only template-blocks scss files
  gulp.watch('./../assets/sass/template-blocks/*.scss', { usePolling: true },  gulp.series('blocks-styles'));

  // track only pages styles
  gulp.watch('./../assets/sass/pages/*.scss', { usePolling: true },  gulp.series('pages-styles'));
  // recompile all styles if basic scss is changed
  gulp.watch('./../assets/sass/utilities/*.scss', { usePolling: true },  gulp.series('theme-styles','blocks-styles','pages-styles'));



  gulp.watch('./../assets/js/*.js',   gulp.series('theme-scripts'));
  gulp.watch('./../assets/js/template-blocks/*.js',   gulp.series('blocks-scripts'));
  gulp.watch('./../assets/js/plugins/*.js',   gulp.series('internal-plugins'));
});

/* run task for one time gtb scss, js files compiling */
gulp.task('gtb', gulp.series('gtb-styles'));