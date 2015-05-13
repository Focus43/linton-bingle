module.exports = function( gulp ){

    // Get the name of the parent directory so we can use it to "namespace" tasks
    var directoryName = require('path').basename(__dirname);
    
    /**
     * Return full path on the file system.
     * @param _path
     * @returns {string}
     */
    function _packagePath(_path){
        return __dirname + '/' + _path;
    }

    /** Prepends a task name with the parent directory for uniqueness. */
    function _taskName( taskName ){
        return directoryName + ':' + taskName;
    }

    var utils   = require('gulp-util'),
        concat  = require('gulp-concat'),
        uglify  = require('gulp-uglify'),
        sass    = require('gulp-ruby-sass'),
        jshint  = require('gulp-jshint');


    var sourcePaths = {
        css: {
            core: _packagePath('css/src/core.scss'),
            app: _packagePath('css/src/app.scss')
        },
        js: {
            core: [
                _packagePath('bower_components/fastclick/lib/fastclick.js'),
//                _packagePath('bower_components/knockout/dist/knockout.js'),
                _packagePath('bower_components/gsap/src/uncompressed/TweenMax.js'),
                _packagePath('bower_components/zepto/zepto.min.js'),
                _packagePath('bower_components/zepto/touch.js'),
                _packagePath('bower_components/mustache.js/mustache.min.js'),
//                _packagePath('bower_components/gsap/src/uncompressed/plugins/ScrollToPlugin.js'),
//                _packagePath('bower_components/isotope/dist/isotope.pkgd.js'),
//                _packagePath('bower_components/moment/min/moment.min.js'),
                _packagePath('js/3rd_party/*.js')
            ],
            app: [
                _packagePath('js/src/elements/*.js'),
                _packagePath('js/src/*.js')
            ]
        }
    };


    /**
     * Sass compilation
     * @param _style
     * @returns {*|pipe|pipe}
     */
    function runSass( files, _style ){ utils.log("runSass" )
        return gulp.src(files)
            .pipe(sass({compass:true, style:(_style || 'nested')}))
            .on('error', function( err ){
                utils.log(utils.colors.red(err.toString()));
                this.emit('end');
            })
            .pipe(gulp.dest(_packagePath('css/')));
    }


    /**
     * Javascript builds (concat, optionally minify)
     * @param files
     * @param fileName
     * @param minify
     * @returns {*|pipe|pipe}
     */
    function runJs( files, fileName, minify ){
        return gulp.src(files)
            .pipe(concat(fileName))
            .pipe(minify === true ? uglify() : utils.noop())
            .pipe(gulp.dest(_packagePath('js/')));
    }


    /**
     * JS-Linter using JSHint library
     * @param files
     * @returns {*|pipe|pipe}
     */
    function runJsHint( files ){
        return gulp.src(files)
            .pipe(jshint(_packagePath('.jshintrc')))
            .pipe(jshint.reporter('jshint-stylish'));
    }


    /**
     * Individual tasks
     */
    gulp.task(_taskName('sass:core:dev'), function(){ return runSass(sourcePaths.css.core); });
    gulp.task(_taskName('sass:core:prod'), function(){ return runSass(sourcePaths.css.core, 'compressed'); });
    gulp.task(_taskName('sass:app:dev'), function(){ return runSass(sourcePaths.css.app); });
    gulp.task(_taskName('sass:app:prod'), function(){ return runSass(sourcePaths.css.app, 'compressed'); });
    gulp.task(_taskName('jshint'), function(){ return runJsHint(sourcePaths.js.app); });
    gulp.task(_taskName('js:core:dev'), function(){ return runJs(sourcePaths.js.core, 'core.js') });
    gulp.task(_taskName('js:core:prod'), function(){ return runJs(sourcePaths.js.core, 'core.js', true) });
    gulp.task(_taskName('js:app:dev', 'jshint'), function(){ return runJs(sourcePaths.js.app, 'app.js') });
    gulp.task(_taskName('js:app:prod', 'jshint'), function(){ return runJs(sourcePaths.js.app, 'app.js', true) });


    /**
     * Grouped tasks (by environment target)
     */
    gulp.task(_taskName('build:dev'), [_taskName('sass:core:dev'), _taskName('sass:app:dev'), _taskName('js:core:dev'), _taskName('js:app:dev')], function(){
        utils.log(utils.colors.bgGreen('Dev build OK'));
    });

    gulp.task(_taskName('build:prod'), [_taskName('sass:core:prod'), _taskName('sass:app:prod'), _taskName('js:core:prod'), _taskName('js:app:prod')], function(){
        utils.log(utils.colors.bgGreen('Prod build OK'));
    });


    /**
     * Watch tasks
     */
    gulp.task(_taskName('watches'), function(){
        gulp.watch(_packagePath('css/src/_required.scss'), {interval:1000}, [_taskName('sass:core:dev')]);
        gulp.watch(_packagePath('css/src/**/*.scss'), {interval:1000}, [_taskName('sass:app:dev')]);
        gulp.watch(_packagePath('js/src/**/*.js'), {interval:1000}, [_taskName('js:app:dev')]);
    });

};