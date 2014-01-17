'use strict';
module.exports = function(grunt) {
 
    require('load-grunt-tasks')(grunt);
 
    grunt.initConfig({
 
        // watch our project for changes
        watch: {
            less: {
				files: ['public/assets/less/*'],
                tasks: ['less']
            },
            js: {
                files: [
                    '<%= jshint.all %>'
                ],
                tasks: ['jshint', 'uglify']
            },
            livereload: {
                options: { livereload: true },
                files: ['public/assets/**/*', '**/*.html', '**/*.php', 'public/assets/img/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },
        // style (Sass) compilation via Compass
		less: {
		  development: {
		    options: {
		      paths: ["public/assets/less"]
		    },
		    files: {
		      "public/assets/css/style.css": "public/assets/less/style.less"
		    }
		  },
		  production: {
		    options: {
		      paths: ["public/assets/less"],
		      cleancss:true
		    },
		    files: {
		      "public/assets/css/style.css": "public/assets/less/style.less"
		    }
		  }
		},
        // make sure js is clean
        jshint: {
            options: {
                "bitwise": true,
                "browser": true,
                "curly": true,
                "eqeqeq": true,
                "eqnull": true,
                "es5": true,
                "esnext": true,
                "immed": true,
                "jquery": true,
                "latedef": true,
                "newcap": true,
                "noarg": true,
                "node": true,
                "strict": false,
                "trailing": true,
                "undef": true,
                "globals": {
                    "jQuery": true,
                    "alert": true
                }
            },
            all: [
                'Gruntfile.js',
                'public/assets/js/*.js'
            ]
        },
        // concatenation and minification all in one
   		uglify: {
            plugins: {
                options: {
                    sourceMap: 'public/assets/js/ai-core.js.map',
                    sourceMappingURL: 'ai-core.js.map',
                    sourceMapPrefix: 2
                },
               	files: {
                    'public/assets/js/ai-core.min.js': [
                     	'public/assets/js/ai-core.js',
                    ]
                }
            }
        }
    });
 
    // register task
    grunt.registerTask('default', ['watch']);
 
};