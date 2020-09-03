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
    merge           = require('merge-stream'),
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
const screenshot = 'source/screenshot.png';
const languageFiles = 'source/languages/*.*';
const wpLanguageFiles = 'content/languages/*.*';
const fonts = 'source/assets/fonts/*.*';
const readme = 'README.md';
const favicons = 'source/assets/images/favicons/*.*';
const htaccess = '.htaccess';

// copy PHP files.
gulp.task('php', function(done) {
    return gulp.src(files.source)
        .pipe(newer(build))
        .pipe(gulp.dest(build))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
    done();
});

// copy Assets not included in the other tasks.
gulp.task('copy-assets', function(done) {
    var copyFonts = gulp.src(fonts).pipe(newer(build + 'assets/fonts')).pipe(gulp.dest(build + 'assets/fonts'));
    var copyLanguageFiles = gulp.src(languageFiles).pipe(gulp.dest(build + 'languages'));
    var copyScreenshot = gulp.src(screenshot).pipe(newer(build)).pipe(gulp.dest(build));
    var copyFavicons = gulp.src([favicons, '!source/assets/images/favicons/master-picture.png']).pipe(newer(build + 'assets/images/favicons')).pipe(gulp.dest(build + 'assets/images/favicons'));
    return merge(copyScreenshot, copyFavicons);
    done();
});

gulp.task('copy-config-files', function(done) {
    var copyReadme = gulp.src(readme).pipe(newer(files.dist)).pipe(gulp.dest(files.dist));
    var copyHtaccess = gulp.src(htaccess).pipe(gulp.dest(files.dist));
    var copyWpLanguageFiles = gulp.src(wpLanguageFiles).pipe(gulp.dest(files.dist + 'content/languages'));
    done();
});

gulp.task('acf-json', function(done) {
    return gulp.src(acfFields)
        .pipe(newer(build + 'includes/acf-json'))
        .pipe(gulp.dest(build + 'includes/acf-json'))
    done();
});

gulp.task('styles', function(done){
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
        done();
});

// Generate Javascript
gulp.task('js-compiled', function(){
    return gulp.src([
            'source/assets/javascript/compile/*.js'
        ])
        .pipe(concat('javascript.min.js'))
        .pipe(gulp.dest(build + 'assets/javascript'))
        .pipe(babel({
            presets: ['@babel/preset-env']
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

gulp.task('copy-images', function(done) {
    return gulp.src([
            'source/assets/images/**/*',
            '!source/assets/images/_*/',
            '!source/assets/images/_*/**/*'
        ])
        .pipe(newer(build + 'assets/images'))
        .pipe(gulp.dest(build + 'assets/images'))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
        done();
});

gulp.task('copy-fonts', function(done) {
    return gulp.src(['source/assets/fonts/*'])
        .pipe(newer(build + 'assets/fonts'))
        .pipe(gulp.dest(build + 'assets/fonts'))
        .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
        done();
});

gulp.task('copy-muplugins', function(done) {
    return gulp.src('content/mu-plugins/*')
        .pipe(gulp.dest('dist/content/mu-plugins/'));
    done();
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

gulp.task('svgsprites', function(done) {
    gulp.src('source/assets/images/_svg-sprites/*.svg')
    .pipe(svgSprites(config))
    .pipe(gulp.dest(build + 'assets/images'))
    .pipe(browserSync ? browserSync.reload({ stream: true }) : gutil.noop());
    done();
});

gulp.task('watch', function() {
    gulp.watch('source/assets/css/styl/**/*.styl', gulp.series('styles'));
    gulp.watch('source/assets/javascript/source/*.js', gulp.series('js-templates'));
    gulp.watch('source/assets/javascript/compile/*.js', gulp.series('js-compiled'));
    gulp.watch('source/assets/images/*.*', gulp.series('copy-images'));
    gulp.watch('source/assets/fonts/*.*', gulp.series('copy-fonts'));
    gulp.watch('source/**/*.php', gulp.series('php'));
    gulp.watch(acfFields, gulp.series('acf-json'));
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
        dest: 'source/assets/images/favicons',
        iconsPath: 'source/assets/images/favicons/',
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

gulp.task('env-prod', function(done) {
    build = files.dist + build;
    done();
});

gulp.task('release', gulp.series('env-prod', 
    gulp.parallel(
        'styles',
        'js-templates',
        'js-compiled',
        'copy-images',
        'copy-assets',
        'copy-config-files',
        'svgsprites',
        'php',
        'acf-json',
        'copy-muplugins'
    ), 
    function release(done) { done();}
));

// Show errors on console.
function swallowError (error) {
    console.log(error.toString())
    this.emit('end')
}