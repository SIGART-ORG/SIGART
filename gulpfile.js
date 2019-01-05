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
gulp.task('app:dev', function () {
	gulp.src(functionGlobal)
    .pipe(concat('app.min.js'))
    .pipe(cache('linting'))
	.pipe(gulp.dest( dest + '/js/' ));
});

gulp.task('plantilla:dev', function(){
    gulp.src( src + '/js/plantilla.js')
    .pipe(concat('plantilla.min.js'))
    .pipe(gulp.dest( dest + '/js/' ))
});

gulp.task('functions:dev', function(){
    gulp.src( src + '/js/functions.js')
    .pipe(concat('functions.min.js'))
    .pipe(gulp.dest( dest + '/js/'))
});

/* CSS */
gulp.task('plantillacss:dev', function(){
	gulp.src( src+'/css/plantilla.css')
		.pipe(concat('plantilla.css'))
		.pipe(gulp.dest( dest + '/css/' ))
});
gulp.task('appcss:dev', function(){
	gulp.src( 'resources/assets/css/app.css')
		.pipe(concat('app.css'))
		.pipe(gulp.dest( dest + '/css/' ))
});

gulp.task('css:dev', ['plantillacss:dev', 'appcss:dev']);

/* Production */
gulp.task('app:dist', function () {
	gulp.src(functionGlobal)
	.pipe(uglify())
	.pipe(concat('app.min.js'))
	.pipe(cache('linting'))
	.pipe(gulp.dest( dest + '/js/' ));
});
gulp.task('plantilla:dist', function(){
	gulp.src( src + '/js/plantilla.js')
		.pipe(uglify())
		.pipe(concat('plantilla.min.js'))
		.pipe(gulp.dest( dest + '/js/' ))
});
gulp.task('functions:dist', function(){
	gulp.src( src + '/js/functions.js')
		.pipe(uglify())
		.pipe(concat('functions.min.js'))
		.pipe(gulp.dest( dest + '/js/'))
});
gulp.task('plantillacss:dist', function(){
	gulp.src( src+'/css/plantilla.css')
		.pipe(concat('plantilla.css'))
		.pipe(cleanCss({processImport: false}))
		.pipe(minifycss())
		.pipe(gulp.dest( dest + '/css/' ))
});
gulp.task('appcss:dist', function(){
	gulp.src( resource+'/css/app.css')
		.pipe(concat('app.css'))
		.pipe(cleanCss({processImport: false}))
		.pipe(minifycss({ keepSpecialComments: 1, processImport: false }))
		.pipe(gulp.dest( dest + '/css/' ))
});

gulp.task('css:dist', ['plantillacss:dist', 'appcss:dist']);
/* Watch */
gulp.task('watch:js', function(){
	gulp.watch(src + '/js/app.js', ['app:dev']);
});

gulp.task('scripts-cleanup', function () {
	del.sync([dest], {force: true});
});

// minify images
gulp.task('images', function(){
	gulp.src(resource + '/img/**/*.+(png|jpg|jpeg|gif|svg)')
		.pipe(imagemin())
		.pipe(gulp.dest(dest + '/img/'));
});

// copy fonts
gulp.task('fonts', function(){
	gulp.src(resource + '/fonts/**/*')
		.pipe(gulp.dest(dest + '/fonts/'));
});

gulp.task('bootstrap', function(){
	gulp.src( resource+'/css/bootstrap.css')
		.pipe(concat('bootstrap.min.css'))
		.pipe(cleanCss({processImport: false}))
		.pipe(minifycss({ keepSpecialComments: 1, processImport: false }))
		.pipe(gulp.dest( dest + '/css/' ))
});

gulp.task('static', ['bootstrap', 'fonts', 'images']);

gulp.task('default', [
	'app:dev',
	'css:dev',
	'functions:dev',
	'plantilla:dev',
	'static'
	//'watch:js'
]);

gulp.task( 'dist', function() {
	sequence('scripts-cleanup', [
		'app:dist',
		'functions:dist',
		'plantilla:dist',
		'css:dist',
		'static'
	]);
});