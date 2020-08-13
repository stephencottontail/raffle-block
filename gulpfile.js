var gulp = require( 'gulp' ),
	terser = require( 'gulp-terser' ),
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

gulp.task( 'babel', function( done ) {
	return gulp.src( [ './index.js' ] )
		.pipe( stream( require( './webpack.config.js' ), webpack ) )
		.pipe( gulp.dest( './dist' ) )
	done()
} )

gulp.task( 'others', function( done ) {
	return gulp.src( './src/js/items.js' )
		.pipe( terser() )
		.pipe( gulp.dest( './dist' ) )
	done()
} )

gulp.task( 'scripts', gulp.parallel( 'babel', 'others' ) );
