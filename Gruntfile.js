'use strict';
module.exports = function (grunt) {

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // watch our project for changes
        watch: {
            less: {
                files: ['public/assets/less/**/*', 'admin/assets/less/**/*'],
                tasks: ['less:coreLess']
            },
            livereload: {
                options: {livereload: true},
                files: ['admin/assets/**/*', 'public/assets/**/*', '**/*.html', '**/*.php', 'public/assets/img/**/*.{png,jpg,jpeg,gif,webp,svg}']
            }
        },
        // less compiling
        less: {
            adminLess: {
                options: {
                    paths: ["admin/assets/less/**/*"],
                    cleancss: true
                },
                files: {
                    "admin/assets/css/aesop-admin.css": "admin/assets/less/style.less"
                }
            },
            coreLess: {
                options: {
                    paths: ["public/assets/less/**/*"],
                    cleancss: true
                },
                files: {
                    "public/assets/css/ai-core.css": "public/assets/less/style.less"
                }
            },
            publicLess: {
                options: {
                    paths: ["public/assets/less/**/*"],
                    cleancss: true
                },
                files: {
                    "public/assets/css/components/gallery.css": "public/assets/less/components/gallery.less",
                    "public/assets/css/components/parallax.css": "public/assets/less/components/parallax.less",
                    "public/assets/css/components/content.css": "public/assets/less/components/content.less",
                    "public/assets/css/components/image.css": "public/assets/less/components/image.less",
                    "public/assets/css/components/video.css": "public/assets/less/components/video.less",
                    "public/assets/css/components/audio.css": "public/assets/less/components/audio.less",
                    "public/assets/css/components/quote.css": "public/assets/less/components/quote.less",
                    "public/assets/css/components/collection.css": "public/assets/less/components/collection.less",
                    "public/assets/css/components/chapter.css": "public/assets/less/components/chapter.less",
                    "public/assets/css/components/character.css": "public/assets/less/components/character.less",
                    "public/assets/css/components/document.css": "public/assets/less/components/document.less",
                    "public/assets/css/components/map.css": "public/assets/less/components/map.less",
                    "public/assets/css/components/timeline.css": "public/assets/less/components/timeline.less"
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
                'public/assets/js/*.js',
                'admin/assets/js/*.js'
            ]
        },
        // concatenation and minification all in one
        uglify: {
            adminscripts: {
                options: {
                    sourceMap: 'admin/assets/js/generator.js.map',
                    sourceMappingURL: 'generator.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'admin/assets/js/generator.min.js': [
                        'admin/assets/js/generator.js',
                        'admin/assets/js/transition.js',
                        'admin/assets/js/tooltip.js',
                        'admin/assets/js/gallery-conditionals.js',
                        'admin/assets/js/gallery-images.js',
                        'admin/assets/js/jquery.cookie.js'
                    ]
                }
            },
            tinymcepluginscripts: {
                options: {
                    sourceMap: 'admin/assets/js/tinymce/aiview/plugin.min.js.map',
                    sourceMappingURL: 'plugin.min.js.map',
                    sourceMapPrefix: 3
                },
                files: {
                    'admin/assets/js/tinymce/aiview/plugin.min.js': [
                        'admin/assets/js/tinymce/aiview/plugin.js'
                    ]
                }
            },
            publicscripts: {
                options: {
                    sourceMap: 'public/assets/js/ai-core.js.map',
                    sourceMappingURL: 'ai-core.js.map',
                    sourceMapPrefix: 10
                },
                files: {
                    'public/assets/js/ai-core.min.js': [
                        'public/assets/js/fit-vids.js',
                        'public/assets/js/swipebox.js',
                        'public/assets/js/waypoints.js',
                        'public/assets/js/fotorama.js',
                        'public/assets/js/scroll-nav.js',
                        'public/assets/js/wookmark.js',
                        'public/assets/js/images-loaded.js',
                        'public/assets/js/pdf-object.js',
                        'public/assets/js/slabtext.js',
                        'public/assets/js/cookie.js',
                        'public/assets/js/parallax.js',
                        'public/assets/js/photoset.js',
                        'public/assets/js/arrive-2.0.0.min.js',
                        'public/assets/js/methods.js'
                    ]
                }
            }
        },

        phplint: {
            options: {
                swapPath: '/tmp'
            },
            all: ['*.php', '**/*.php', '!node_modules/**/*.php']
        },

        cssjanus: {
            core: {
                options: {
                    swapLtrRtlInUrl: false
                },
                files: [
                    {
                        src: 'public/assets/css/ai-core.css',
                        dest: 'public/assets/css/ai-core-rtl.css'
                    }
                ]
            }
        },

        checktextdomain: {
            options: {
                text_domain: 'aesop-core',
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,3d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d',
                    ' __ngettext:1,2,3d',
                    '__ngettext_noop:1,2,3d',
                    '_c:1,2d',
                    '_nc:1,2,4c,5d'
                ]
            },
            files: {
                src: [
                    '**/*.php', // Include all files
                    '!node_modules/**', // Exclude node_modules/
                ],
                expand: true
            }
        },

        makepot: {
            target: {
                options: {
                    domainPath: '/languages',    // Where to save the POT file.
                    exclude: ['build/.*'],
                    mainFile: 'aesop-core.php',    // Main project file.
                    potFilename: 'aesop-core.pot',    // Name of the POT file.
                    potHeaders: {
                        poedit: true,                 // Includes common Poedit headers.
                        'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
                    },
                    type: 'wp-plugin',    // Type of project (wp-plugin or wp-theme).
                    updateTimestamp: true,    // Whether the POT-Creation-Date should be updated without other changes.
                    updatePoFiles: true,    // Whether to update PO files in the same directory as the POT file.
                    processPot: function (pot, options) {
                        pot.headers['report-msgid-bugs-to'] = 'http://aesopstoryengine.com/';
                        pot.headers['last-translator'] = 'WP-Translations (http://wp-translations.org/)\n';
                        pot.headers['language-team'] = 'WP-Translations  <fxb@wp-translations.org>\n';
                        pot.headers['language'] = 'en_US';
                        var translation, // Exclude meta data from pot.
                            excluded_meta = [
                                'Plugin Name of the plugin/theme',
                                'Plugin URI of the plugin/theme',
                                'Author of the plugin/theme',
                                'Author URI of the plugin/theme'
                            ];
                        for (translation in pot.translations['']) {
                            if ('undefined' !== typeof pot.translations[''][translation].comments.extracted) {
                                if (excluded_meta.indexOf(pot.translations[''][translation].comments.extracted) >= 0) {
                                    console.log('Excluded meta: ' + pot.translations[''][translation].comments.extracted);
                                    delete pot.translations[''][translation];
                                }
                            }
                        }
                        return pot;
                    }
                }
            }
        },

        exec: {
            txpull: { // Pull Transifex translation - grunt exec:txpull
                cmd: 'tx pull -a -f --minimum-perc=10' // Change the percentage with --minimum-perc=yourvalue
            },
            txpush_s: { // Push pot to Transifex - grunt exec:txpush_s
                cmd: 'tx push -s'
            },
        },

        dirs: {
            lang: 'languages',  // It should be languages or lang
        },

        potomo: {
            dist: {
                options: {
                    poDel: false // Set to true if you want to erase the .po
                },
                files: [{
                    expand: true,
                    cwd: '<%= dirs.lang %>',
                    src: ['*.po'],
                    dest: '<%= dirs.lang %>',
                    ext: '.mo',
                    nonull: true
                }]
            }
        },
    });

    // register task
    grunt.registerTask('default', ['watch']);

    //  Checktextdomain and makepot task(s)
    grunt.registerTask('go-pot', ['checktextdomain', 'makepot', 'potomo']);

    // Makepot and push it on Transifex task(s).
    grunt.registerTask('tx-push', ['makepot', 'exec:txpush_s']);

    // Pull from Transifex and create .mo task(s).
    grunt.registerTask('tx-pull', ['exec:txpull', 'potomo']);

};
