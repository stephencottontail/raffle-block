var gulp = require( 'gulp' ),
	webpack = require( 'webpack' ),
	stream = require( 'webpack-stream' )

gulp.task( 'scripts', function() {
	return gulp.src( [ './index.js', './src/js/*.js' ] )
		.pipe( stream( require( './webpack.config.js' ), webpack ) )
		.pipe( gulp.dest( './dist' ) )
} )
