const
    // source and build folders
    dir = {
        source  : 'source/',
        build   : 'content/themes/miguelmorera/'
    }
    themeSlug       = 'source/',
    fs              = require('fs'),
    gulp            = require('gulp'),
    nib             = require('nib'),
    newer           = require('gulp-newer'),
    babel           = require('gulp-babel'),
    stylus          = require('gulp-stylus'),
    notify          = require('gulp-notify'),
    concat          = require('gulp-concat'),
    uglify          = require('gulp-uglify'),
    sourcemaps      = require('gulp-sourcemaps'),
    realFavicon     = require('gulp-real-favicon'),
    checktextdomain = require('gulp-checktextdomain');

// Browser-sync
var browsersync = false;

// PHP settings
const php = {
    source      : dir.source + '**/*.php',
    build       : dir.build
};

// copy PHP files
gulp.task('php', function() {
    return gulp.src(php.source)
        .pipe(newer(php.build))
        .pipe(gulp.dest(php.build));
});

gulp.task('styles', function(){
    gulp.src(dir.source + 'assets/css/styl/style.styl')
        .pipe(sourcemaps.init())
        .pipe(stylus({
            compress: true, 
            use: nib(),
            'include css': true,
            paths: [dir.source + 'assets/css/styl']
        }))
        .on('error', swallowError)
        .pipe(sourcemaps.write('.'))
        .pipe(notify('Compiled!'))
        .pipe(gulp.dest(dir.build))
});

// Generate Javascript
gulp.task('js-compiled', function(){
    return gulp.src([
            dir.source + 'assets/javascript/compile/*.js'
        ])
        .pipe(concat('javascript.min.js'))
        .pipe(gulp.dest(dir.build + 'assets/javascript'))
        .pipe(babel({
            presets: ['es2015']
        }))
        .pipe(uglify())
        .on('error', swallowError)
        .pipe(gulp.dest(dir.build + 'assets/javascript'));
});

gulp.task('js-templates', function(){
    return gulp.src(dir.source + 'assets/javascript/source/*.js')
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .on('error', swallowError)
        .pipe(gulp.dest(dir.build + 'assets/javascript'));
});

gulp.task('copy-images', function() {
    return gulp.src(dir.source + 'assets/images/**/*.*')
        .pipe(newer(php.build + 'assets/images'))
        .pipe(gulp.dest(php.build + 'assets/images'));
});

gulp.task('watch', function() {
    gulp.watch(dir.source + 'assets/css/styl/**/*.styl', ['styles']);
    gulp.watch(dir.source + 'assets/javascript/source/*.js', ['js-templates']);
    gulp.watch(dir.source + 'assets/javascript/compile/*.js', ['js-compiled']);
    gulp.watch(dir.source + '**/*.php', ['php']);
});


// Check textdomains in the theme.
gulp.task('checktextdomain', function() {
    var textdomain = 'miguelmorera';
    return gulp.src([
        dir.source + '*.php',
        dir.source + '**/*.php',
        dir.source + '**/**/*.php'
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
    var FAVICON_DATA_FILE = dir.source + 'assets/images/favicons/faviconData.json';
    realFavicon.generateFavicon({
        masterPicture: dir.source + 'assets/images/favicons/master-picture.png',
        dest: dir.build + 'assets/images/favicons',
        iconsPath: dir.build + '/assets/images/favicons/',
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

gulp.task('build', ['php', 'css', 'js', 'copy-images']);

// Show errors on console.
function swallowError (error) {
    console.log(error.toString())
    this.emit('end')
}