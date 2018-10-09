var gulp = require('gulp');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
var concatJS = require('gulp-concat');

var functionGlobal = [
	'public/js/app.js',
]

gulp.task('app-js', function () {
	gulp.src(functionGlobal)
	.pipe(uglify())
	.pipe(concatJS('app.min.js'))
	.pipe(gulp.dest('public/js/'));
});

gulp.task('plantilla', function(){
    gulp.src('public/js/plantilla.js')
    .pipe(uglify())
    .pipe(concatJS('plantilla.min.js'))
    .pipe(gulp.dest('public/js/'))
});

gulp.task('functions', function(){
    gulp.src('public/js/functions.js')
    .pipe(uglify())
    .pipe(concatJS('functions.min.js'))
    .pipe(gulp.dest('public/js/'))
});

//[Tareas Mobile]