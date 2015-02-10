module.exports = (grunt) ->
	@initConfig
		pkg   : @file.readJSON('package.json')
		watch :
			files: ['**/**.coffee', '**/*.scss']
			tasks: ['develop']
		coffee:
			compile:
				expand : true
				flatten: true
				cwd    : 'js/src/'
				src    : ['*.coffee']
				dest   : 'js/'
				ext    : '.js'
		compass:
			dist:
				options:
					config : 'config.rb'
					specify: ['css/src/*.scss']
		jshint :
			files  : ['js/*.js']
			options:
				globals:
					jQuery  : true
					console : true
					module  : true
					document: true
				force  : true
		csslint:
			options:
				'star-property-hack'       : false
				'duplicate-properties'     : false
				'unique-headings'          : false
			# 'ids': false
				'display-property-grouping': false
				'floats'                   : false
				'outline-none'             : false
				'box-model'                : false
				'adjoining-classes'        : false
				'box-sizing'               : false
				'universal-selector'       : false
				'font-sizes'               : false
				'overqualified-elements'   : false
				force                      : true
			src    : ['css/*.css']
		concat :
			adminjs :
				src : ['js/src/admin-*.js']
				dest: 'js/admin.min.js'
			publicjs:
				src : ['js/src/public-*.js']
				dest: 'js/public.min.js'

	@loadNpmTasks 'grunt-contrib-coffee'
	@loadNpmTasks 'grunt-contrib-compass'
	@loadNpmTasks 'grunt-contrib-jshint'
	@loadNpmTasks 'grunt-contrib-csslint'
	@loadNpmTasks 'grunt-contrib-concat'
	@loadNpmTasks 'grunt-contrib-watch'

	@registerTask 'default', ['coffee']
	@registerTask 'develop', ['coffee', 'jshint']
	@registerTask 'package', ['default', 'cssmin', 'csslint']

	@event.on 'watch', (action, filepath) =>
		@log.writeln('#{filepath} has #{action}')