module.exports = function (grunt) {
	var path = require("path");
	
	var jsDist = 'Website/Content/Js/_built.js';
	var jsSrc = ['Website/Content/Js/**/*.js', '!' + jsDist, '!Website/Content/Js/Module/**/*.js'];

	var cssDist = 'Website/Content/Css/_built.css';
	var cssSrc = ['Website/Content/Css/**/*.css', '!' + cssDist, '!Website/Content/Css/Module/**/*.css'];
	var sassSrc = ['Website/Content/Sass/**/*.scss'];

	// Configuration de Grunt
	grunt.initConfig({
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				jsSrc
			]
		},
		sass: {
			dist: {
				options: {
					style: 'compressed',
					compass: true,
					sourcemap: false
				},
				files: {
					"Website/Content/Css/_built.css": ["Website/Content/Sass/index.scss"]
				}
			}
		},
		uglify: {
			dist: {
				files: {
					'Website/Content/Js/_built.js': jsSrc
				},
				options: {
					mangle: false
				},
			}
		},
		cssmin: {
			compile: {
				src: cssSrc,
				dest: cssDist
			}
		},
		watch: {
			options: {
				livereload: true
			},
			sass: {
				files: sassSrc,
				tasks: ['sass']
			},
			js: {
				files: jsSrc,
				tasks: ['uglify']
			},
			html: {
				files: [
					'**/*.html'
				]
			}
		},
		clean: {
			dist: [
				cssDist,
				jsDist
			]
		},
		img: {
			task: {
				src: ['Website/Content/Media/Image/**/*.jpg', 'Website/Content/Media/Image/**/*.jpeg', 'Website/Content/Media/Image/**/*.png', 'Website/Content/Media/Image/**/*.gif']
			}
		}
	});

	// Load tasks
	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify-es');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-cssmin'); // Minifier/Concaténer les fichier CSS
	grunt.loadNpmTasks('grunt-img');
  
	// Register tasks
	grunt.registerTask('default', [
	  'clean',
	  'sass',
	  'uglify',
	  'img:task'
	]);
	grunt.registerTask('dev', [
	  'watch'
	]);
};