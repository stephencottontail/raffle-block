var gulp = require( 'gulp' ),
	sass = require( 'gulp-sass' ),
	postCSS = require( 'gulp-postcss' ),
	webpack = require( 'webpack' ),
	stream = require( 'webpack-stream' )

gulp.task( 'styles', function() {
	return gulp.src( [ './src/css/style.scss' ] )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( postCSS() )
		.pipe( gulp.dest( './dist' ) )
} )

gulp.task( 'scripts', function() {
	return gulp.src( [ './index.js', './src/js/*.js' ] )
		.pipe( stream( require( './webpack.config.js' ), webpack ) )
		.pipe( gulp.dest( './dist' ) )
} )
