var gulp = require('gulp');
var serve = require('gulp-serve');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var cache = require('gulp-cached');
var minifycss =require('gulp-minify-css');
var del = require('del');
var sequence = require('run-sequence');
var imagemin = require('gulp-imagemin');
var cleanCss = require('gulp-cleancss');

var resource = './resources/assets';
var src = './public/dev';
var functionGlobal = [
	src + '/js/app.js',
];
var dest = './public/dist';

/* JS */
function appDev(){
    return gulp.src(functionGlobal)
    .pipe(concat('app.min.js'))
    .pipe(cache('linting'))
	.pipe(gulp.dest( dest + '/js/' ));
}

function plantillaDev(){
    return gulp.src( src + '/js/plantilla.js')
    .pipe(concat('plantilla.min.js'))
    .pipe(gulp.dest( dest + '/js/' ));
}

function functionsDev(){
    return gulp.src( src + '/js/functions.js')
    .pipe(concat('functions.min.js'))
    .pipe(gulp.dest( dest + '/js/'));
}

/* CSS */
function plantillasCssDev(){
    return gulp.src( src+'/css/plantilla.css')
		.pipe(concat('plantilla.css'))
		.pipe(gulp.dest( dest + '/css/' ));
}

function appCssDev(){
    return gulp.src( 'resources/assets/css/app.css')
		.pipe(concat('app.css'))
		.pipe(gulp.dest( dest + '/css/' ));
}

function cssDev(){

}

exports.appDev = appDev;
exports.plantillaDev = plantillaDev;
exports.functionsDev = functionsDev;
exports.plantillasCssDev = plantillasCssDev;
exports.appCssDev = appCssDev;

var build = gulp.parallel(appDev);
gulp.task('default', build);

// /* Production */
//
// gulp.task('css:dist', ['plantillacss:dist', 'appcss:dist']);
//
// gulp.task('scripts-cleanup', function () {
//
// });
//

//
// gulp.task('default', [
// 	'app:dev',
// 	'css:dev',
// 	'functions:dev',
// 	'plantilla:dev',
// 	'static'
// 	//'watch:js'
// ]);
//
// gulp.task( 'dist', function() {
// 	sequence('scripts-cleanup', [
// 		'app:dist',
// 		'functions:dist',
// 		'plantilla:dist',
// 		'css:dist',
// 		'static'
// 	]);
// });
