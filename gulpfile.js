const
    // source and build folders
    theme           = 'content/themes/prometheus/',
    fs              = require('fs'),
    gulp            = require('gulp'),
    nib             = require('nib'),
    gutil           = require('gulp-util'),
    newer           = require('gulp-newer'),
    babel           = require('gulp-babel'),
    stylus          = require('gulp-stylus'),
    notify          = require('gulp-notify'),
    concat          = require('gulp-concat'),
    uglify          = require('gulp-uglify'),
    rename          = require('gulp-rename'),
    svgSprites      = require('gulp-svg-sprite'),
    sourcemaps      = require('gulp-sourcemaps'),
    realFavicon     = require('gulp-real-favicon'),
    checktextdomain = require('gulp-checktextdomain'),
    browserSync     = require('browser-sync').create();

// Files settings
const files = {
    source      : 'source/**/*.php',
    dist        : 'dist/'
};

var build = theme;

const acfFields = 'source/includes/acf-json/*.json';

// copy PHP files
gulp.task('php', function() {
    return gulp.src(files.source)
        .pipe(newer(build))
        .pipe(gulp.dest(build))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

gulp.task('acf-json', function() {
    return gulp.src(acfFields)
        .pipe(newer(build + 'includes/acf-json'))
        .pipe(gulp.dest(build + 'includes/acf-json'))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

gulp.task('styles', function(){
    gulp.src('source/assets/css/styl/style.styl')
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true, 
            use: nib(),
            'include css': true,
            paths: ['source/assets/css/styl']
        }))
        .on('error', swallowError)
        .pipe(sourcemaps.write('.'))
        .pipe(notify('Compiled!'))
        .pipe(gulp.dest(build))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

// Generate Javascript
gulp.task('js-compiled', function(){
    return gulp.src([
            'source/assets/javascript/compile/*.js'
        ])
        .pipe(concat('javascript.min.js'))
        .pipe(gulp.dest(build + 'assets/javascript'))
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(uglify())
        .on('error', swallowError)
        .pipe(gulp.dest(build + 'assets/javascript'))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

gulp.task('js-templates', function(){
    return gulp.src('source/assets/javascript/source/*.js')
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .on('error', swallowError)
        .pipe(gulp.dest(build + 'assets/javascript'))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

gulp.task('copy-images', function() {
    return gulp.src([
            'source/assets/images/**/*',
            '!source/assets/images/_*/',
            '!source/assets/images/_*/**/*'
        ])
        .pipe(newer(build + 'assets/images'))
        .pipe(gulp.dest(build + 'assets/images'))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

gulp.task('copy-muplugins', function() {
    return gulp.src('content/mu-plugins/*')
        .pipe(gulp.dest('dist/content/mu-plugins/'));
});

gulp.task('copy-screenshot', function() {
    return gulp.src('source/*.png')
        .pipe(newer(build))
        .pipe(gulp.dest(build));
});

config = {
    svg: {
        xmlDeclaration: false,
        doctypeDeclaration: false
    },
    mode: {
        symbol: {
            dest: '.',
            sprite: 'sprites.svg'
        }
    }
};

gulp.task('svgsprites', function() {
    gulp.src('source/assets/images/_svg-sprites/*.svg')
    .pipe(svgSprites(config))
    .pipe(gulp.dest(build + 'assets/images'))
    .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
});

gulp.task('watch', function() {
    console.log(build);
    gulp.watch('source/assets/css/styl/**/*.styl', ['styles']);
    gulp.watch('source/assets/javascript/source/*.js', ['js-templates']);
    gulp.watch('source/assets/javascript/compile/*.js', ['js-compiled']);
    gulp.watch('source/assets/images/*.*', ['copy-images']);
    gulp.watch('source/**/*.php', ['php']);
    gulp.watch(acfFields, ['acf-json']);
});


// Check textdomains in the theme.
gulp.task('checktextdomain', function() {
    var textdomain = 'prometheus';
    return gulp.src([
        'source/*.php',
        'source/**/*.php',
        'source/**/**/*.php'
    ])
    .pipe(checktextdomain({
        text_domain: textdomain, // Specify allowed domain
        keywords: [ // List keyword specifications
            '__:1,2d',
            '_e:1,2d',
            '_x:1,2c,3d',
            'esc_html__:1,2d',
            'esc_html_e:1,2d',
            'esc_html_x:1,2c,3d',
            'esc_attr__:1,2d',
            'esc_attr_e:1,2d',
            'esc_attr_x:1,2c,3d',
            '_ex:1,2c,3d',
            '_n:1,2,4d',
            '_nx:1,2,4c,5d',
            '_n_noop:1,2,3d',
            '_nx_noop:1,2,3c,4d'
        ],
        force: true,
        correct_domain: true
    }));
});

gulp.task('generate-favicon', function(done) {
    // File where the favicon markups are stored (unnecessary but I don't know how to avoid its generation).
    var FAVICON_DATA_FILE = 'source/assets/images/favicons/faviconData.json';
    realFavicon.generateFavicon({
        masterPicture: 'source/assets/images/favicons/master-picture.png',
        dest: build + 'assets/images/favicons',
        iconsPath: build + '/assets/images/favicons/',
        design: {
            ios: {
                pictureAspect: 'noChange',
                assets: {
                    ios6AndPriorIcons: false,
                    ios7AndLaterIcons: false,
                    precomposedIcons: false,
                    declareOnlyDefaultIcon: true
                }
            },
            desktopBrowser: {},
            windows: {
                pictureAspect: 'noChange',
                backgroundColor: '#2b5797',
                onConflict: 'override',
                assets: {
                    windows80Ie10Tile: false,
                    windows10Ie11EdgeTiles: {
                        small: false,
                        medium: true,
                        big: false,
                        rectangle: false
                    }
                }
            },
            androidChrome: {
                pictureAspect: 'noChange',
                themeColor: '#ffffff',
                manifest: {
                    display: 'standalone',
                    orientation: 'notSet',
                    onConflict: 'override',
                    declared: true
                },
                assets: {
                    legacyIcon: false,
                    lowResolutionIcons: false
                }
            },
            safariPinnedTab: {
                pictureAspect: 'blackAndWhite',
                threshold: 50,
                themeColor: '#5bbad5'
            }
        },
        settings: {
            scalingAlgorithm: 'Mitchell',
            errorOnImageTooSmall: false,
            readmeFile: false,
            htmlCodeFile: false,
            usePathAsIs: false
        },
        markupFile: FAVICON_DATA_FILE
    }, function() {
        done();
    });
});

gulp.task('env-prod', function() {
    build = files.dist + build;
});

gulp.task('release', ['env-prod'], function(){
    console.log(build);
    gulp.start('styles');
    gulp.start('js-templates');
    gulp.start('js-compiled');
    gulp.start('copy-images');
    gulp.start('svgsprites');
    gulp.start('php');
    gulp.start('acf-json');
    gulp.start('copy-muplugins');
});

// Show errors on console.
function swallowError (error) {
    console.log(error.toString())
    this.emit('end')
}