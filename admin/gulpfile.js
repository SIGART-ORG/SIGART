var gulp = require('gulp');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var cache = require('gulp-cached');
var minifycss =require('gulp-minify-css');
var del = require('del');
var imagemin = require('gulp-imagemin');
var cleanCss = require('gulp-cleancss');

var resource = './resources/assets';
var src = './public/dev';
var dest = './public/dist';

var functionGlobal = [
    src + '/js/app.js',
];

/* Development */
var appDev = function () {
    return gulp.src(functionGlobal)
        .pipe(concat('app.min.js'))
        .pipe(cache('linting'))
        .pipe(gulp.dest( dest + '/js/' ));
};

var lantillaDev = function (){
    return gulp.src( src + '/js/plantilla.js')
        .pipe(concat('plantilla.min.js'))
        .pipe(gulp.dest( dest + '/js/' ));
};

var functionsDev = function (){
    return gulp.src( src + '/js/functions.js')
        .pipe(concat('functions.min.js'))
        .pipe(gulp.dest( dest + '/js/'));
};

var plantillasCssDev = function (){
    return gulp.src( src+'/css/plantilla.css')
        .pipe(concat('plantilla.css'))
        .pipe(gulp.dest( dest + '/css/' ));
};

var appCssDev = function (){
    return gulp.src( 'resources/assets/css/app.css')
        .pipe(concat('app.css'))
        .pipe(gulp.dest( dest + '/css/' ));
};

/* production */
var appDist = function () {
     return gulp.src(functionGlobal)
        .pipe(uglify())
        .pipe(concat('app.min.js'))
        .pipe(cache('linting'))
        .pipe(gulp.dest( dest + '/js/' ));
};

var plantillaDist = function () {
    return gulp.src( src + '/js/plantilla.js')
		.pipe(uglify())
		.pipe(concat('plantilla.min.js'))
		.pipe(gulp.dest( dest + '/js/' ));
};

var functionsDist = function () {
    return gulp.src( src + '/js/functions.js')
		.pipe(uglify())
		.pipe(concat('functions.min.js'))
		.pipe(gulp.dest( dest + '/js/'));
};

var plantillaCssDist = function () {
    return gulp.src( src+'/css/plantilla.css')
		.pipe(concat('plantilla.css'))
		.pipe(cleanCss({processImport: false}))
		.pipe(minifycss())
		.pipe(gulp.dest( dest + '/css/' ));
};

var appCssDist = function () {
    return gulp.src( resource+'/css/app.css')
		.pipe(concat('app.css'))
		.pipe(cleanCss({processImport: false}))
		.pipe(minifycss({ keepSpecialComments: 1, processImport: false }))
		.pipe(gulp.dest( dest + '/css/' ));
};

/*static*/
var images = function () {
	return gulp.src(resource + '/img/**/*.+(png|jpg|jpeg|gif|svg)')
		.pipe(imagemin())
		.pipe(gulp.dest(dest + '/img/'));
};

var font = function () {
    return gulp.src(resource + '/fonts/**/*')
		.pipe(gulp.dest(dest + '/fonts/'));
};

/*Cleaner*/
var scriptsCleanup = function () {
    return del.sync([dest], {force: true});
};

gulp.task('default', gulp.series(
    appDev,
    lantillaDev,
    functionsDev,
    gulp.parallel(font, images)
));

gulp.task( 'dist', gulp.series(
    scriptsCleanup,
    gulp.parallel(
        gulp.series(
            appDist,
            plantillaDist,
            functionsDist,
            plantillaCssDist,
            appCssDist,
            gulp.parallel(font, images)
        )
    )
));
