module.exports = function( grunt ) {
	// Config
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Sass
		sass: {
			dist: {
				options: {
					sourceMap: true,
					style: 'expanded'
				},
				files: {
					'assets/painel/css/style.min.css': 'assets/painel/scss/painel.scss'
				}
			}
		}
	});

	// Load
	grunt.loadNpmTasks( 'grunt-contrib-sass' );

	// Tasks
	grunt.registerTask( 'css', [ 'sass' ] );
}