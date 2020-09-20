'use strict';
module.exports = function(grunt) {

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // watch our project for changes
        watch: {
        	concat: {
        		files: ['public/assets/js/source/*'],
        		tasks:['concat:dist', 'uglify' ]
        	},
            less: {
				files: ['public/assets/less/**/*','admin/assets/less/**/*'],
                tasks: ['less:coreLess','less:settingsLess']
            },
            livereload: {
                options: { livereload: true },
                files: ['public/assets/**/*','admin/assets/**/*', '**/*.html', '**/*.php', 'public/assets/img/**/*.{png,jpg,jpeg,gif,webp,svg}']
            },
        },
        less: {
		  	coreLess: {
		  		options: {
		      		paths: ['public/assets/less/*'],
		      		cleancss:true
		    	},
		    	files: {
		      		'public/assets/css/lasso.css': 'public/assets/less/style.less'
		    	}
		  	},
		  	settingsLess: {
		  		options: {
		      		paths: ['admin/assets/less/*'],
		      		cleancss:true
		    	},
		    	files: {
		      		'admin/assets/css/lasso-editor-settings.css': 'admin/assets/less/style.less'
		    	}
		    }
        },
   		concat: {
            dist: {
                src: [
                    'public/assets/js/source/util--undo.js',
                    'public/assets/js/source/util--rangy-core.js',
                    'public/assets/js/source/util--rangy-classapplier.js',
                    'public/assets/js/source/util--content-editable.js',
                    'public/assets/js/source/util--scrollbar.js',
                    'public/assets/js/source/util--sweet-alert.js',
                    'public/assets/js/source/util--geo-complete.js',
                    'public/assets/js/source/util--imagesloaded.js',
                    'public/assets/js/source/util--slider.js',
                    'public/assets/js/source/util--touch-punch.js',
                    'public/assets/js/source/util--tagit.js',
                    'public/assets/js/source/enter-editor.js',
                    'public/assets/js/source/post-settings.js',
                    'public/assets/js/source/settings-panel.js',
                    'public/assets/js/source/settings-live-editing.js',
                    'public/assets/js/source/toolbar.js',
                    'public/assets/js/source/process-save.js',
                    'public/assets/js/source/process-gallery.js',
                    'public/assets/js/source/process-gallery-opts.js',
                    'public/assets/js/source/process-map.js',
                    'public/assets/js/source/process-image-upload.js',
                    'public/assets/js/source/process-save-component.js',
                    'public/assets/js/source/process-new-post.js',
                    'public/assets/js/source/process-save-title.js',
                    'public/assets/js/source/process-wpimg.js',
                    'public/assets/js/source/process-save-meta.js',
                    'public/assets/js/source/modal-sizing.js',
                    'public/assets/js/source/all-posts.js',
                    'public/assets/js/source/tour.js',
                    'public/assets/js/source/revisions.js'
               	],
                dest: 'public/assets/js/lasso.js'
            }
        },
   		uglify: {
            scripts: {
            	options: {
					sourceMap: 'public/assets/js/lasso.js.map',
					sourceMappingURL: 'lasso.js.map'
				},
                files: {
                    'public/assets/js/lasso.min.js': [
                        'public/assets/js/lasso.js'
                    ]
                }
            }
        },
        makepot: {
		    target: {
		        options: {
		          	domainPath: '/languages/',    // Where to save the POT file.
		          	exclude: ['build/.*'],
		          	mainFile: 'lasso.php',    // Main project file.
		          	potFilename: 'lasso.pot',    // Name of the POT file.
		          	potHeaders: {
		                poedit: true,                 // Includes common Poedit headers.
		              	'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
		           	},
		         	type: 'wp-plugin',    // Type of project (wp-plugin or wp-theme).
		          	updateTimestamp: true,    // Whether the POT-Creation-Date should be updated without other changes.
		          	processPot: function( pot, options ) {
		            	pot.headers['report-msgid-bugs-to'] = 'http://edituswp.com';
		            	pot.headers['language'] = 'en_US';
		            	return pot;
		          	}
		        }
		    }
	    }
    });

    // register task
    grunt.registerTask('default', ['watch']);

};
