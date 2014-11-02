module.exports = function(grunt) {
	var path = require("path");

	grunt.loadNpmTasks('grunt-contrib-uglify'); // Minifier/Concaténer les fichiers JS
	grunt.loadNpmTasks('grunt-contrib-cssmin'); // Minifier/Concaténer les fichier CSS
	grunt.loadNpmTasks('grunt-contrib-jshint'); // Compilateur JS
	grunt.loadNpmTasks('grunt-contrib-watch'); 	// Watcher d'événement
	
	var jsDist = 'Website/Content/JS/_built.js';
    var jsSrc = ['Website/Content/JS/**/*.js', '!' + jsDist, '!Website/Content/JS/Base/jquery-1.10.min.js', '!Website/Content/JS/Base/jquery-ui-1.10.custom.min.js'];

	var cssDist = 'Website/Content/Css/_built.css';
    var cssSrc = ['Website/Content/Css/**/*.css', '!' + cssDist];
	
    // Configuration de Grunt
    grunt.initConfig({
    	jshint: {
    		all: ['Gruntfile.js', jsSrc]
		},
		uglify: {
		    options: {
		        separator: ';',
		        mangle: false
		    },
		    compile: {
		        src: jsSrc,
		        dest: jsDist
		    }
		},
		cssmin: {
            compile: {
                src: cssSrc,
                dest: cssDist
            }
        },
		watch: {
		    scripts: {
		        files: ['Gruntfile.js', jsSrc],
		        tasks: ['scripts']
		    }
		}
    });

    grunt.registerTask('default', ['scripts', 'watch']);
	grunt.registerTask('scripts', ['jshint', 'uglify:compile', 'cssmin:compile']);
};