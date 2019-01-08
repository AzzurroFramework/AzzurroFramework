const {task, series, parallel, watch, src, dest} = require('gulp');
const del = require('del');
const path = require('path');
const clean = require('gulp-clean');

// Folders
var PATH = {
	SRC: '.', // Src directory
	BUILD: './build', // Build directory
}

// Clean build directory
task('clean', function () {
	return src(PATH.BUILD)
		.pipe(clean());
});


// Build tasks
// -------------------------

// Copy index.php from src to build folder
function index() {
	return src(PATH.SRC + '/index.php')
		.pipe(dest(PATH.BUILD));
}

// Copy htaccess from src to build
function htaccess() {
	return src(PATH.SRC + '/.htaccess')
		.pipe(dest(PATH.BUILD));
}

// Copy core files from src to build
function core() {
    return src(PATH.SRC + '/core/**/*')
        .pipe(dest(PATH.BUILD + '/core/'));
}

// Copy core modules from src to build
function modules() {
    return src(PATH.SRC + '/modules/**/*')
        .pipe(dest(PATH.BUILD + '/modules/'));
}

// Copy vendors from src to build
function vendors() {
    return src(PATH.SRC + '/vendors/**/*')
        .pipe(dest(PATH.BUILD + '/vendors/'));
}

// Copy app from src to build
function app() {
    return src(PATH.SRC + '/app/**/*')
        .pipe(dest(PATH.BUILD + '/app/'));
}

// Build project in development environment
task('build-dev', parallel(
	index,
	htaccess,
	core,
	modules,
	app,
	vendors
));


// Watchers
// -------------------------

// Function to remove from build folder a deleted source file to prevent polluting build folder
function deleteFile(filename, source, build) {
	var pathFromSource = path.relative(path.resolve(source), filename);
	var pathFromBuild = path.resolve(build, pathFromSource);
	del.sync(pathFromBuild);
}

// Watcher
task('watch-dev', function (cb) {
	// Watch index.php file
	watch(PATH.SRC + '/**/*')
		.on('all', index);

	// Watch htaccess file
	watch(PATH.SRC + '/.htaccess')
		.on('all', htaccess);
		
	// Watch core files
	watch(PATH.SRC + '/core/**/*')
		.on('add', core)
		.on('change', core)
		.on('unlink', function (filename) {
			deleteFile(filename, PATH.SRC, PATH.BUILD);
		});

	// Watch modules files
	watch(PATH.SRC + '/modules/**/*')
		.on('add', modules)
		.on('change', modules)
		.on('unlink', function (filename) {
			deleteFile(filename, PATH.SRC, PATH.BUILD);
		});

    // Watch app files
	watch(PATH.SRC + '/app/**/*')
        .on('add', app)
        .on('change', app)
        .on('unlink', function (filename) {
            deleteFile(filename, PATH.SRC, PATH.BUILD);
		});
		
	// Watch vendors files
	watch(PATH.SRC + '/vendors/**/*')
        .on('add', vendors)
        .on('change', vendors)
        .on('unlink', function (filename) {
            deleteFile(filename, PATH.SRC, PATH.BUILD);
        });

	cb();
});

// Development
// -------------------------

task('dev', series(
	task('build-dev'),
	task('watch-dev')
));

// Default
// -------------------------

task('default', task('dev'));