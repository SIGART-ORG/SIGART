var gulp = require('gulp');
var serve = require('gulp-serve');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var cache = require('gulp-cached');
var minifycss =require('gulp-minify-css');

var src = './public/dev';
var functionGlobal = [
	src + '/js/app.js',
];
var dest = './public';

/* JS */
gulp.task('app:dev', function () {
	gulp.src(functionGlobal)
	.pipe(uglify())
    .pipe(concat('app.min.js'))
    .pipe(cache('linting'))
	.pipe(gulp.dest( dest + '/js/' ));
});

gulp.task('plantilla', function(){
    gulp.src( src + '/js/plantilla.js')
    .pipe(uglify())
    .pipe(concat('plantilla.min.js'))
    .pipe(gulp.dest( dest + '/js/' ))
});

gulp.task('functions', function(){
    gulp.src( src + '/js/functions.js')
    .pipe(uglify())
    .pipe(concat('functions.min.js'))
    .pipe(gulp.dest( dest + '/js/'))
});

gulp.task('watch:js', function(){
	gulp.watch(src + '/js/app.js', ['app:dev']);
});

/* CSS */
gulp.task('plantilla:dev', function(){
	gulp.src( src+'/css/plantilla.css')
		.pipe(concat('plantilla.css'))
		.pipe(minifycss())
		.pipe(gulp.dest( dest + '/css/' ))
});

gulp.task('css:dev', ['plantilla:dev']);

gulp.task('default', [
	'app:dev',
	'plantilla',
	'functions',
	'plantilla:dev',
	'watch:js'
]);