jQuery(document).ready(function($) {

	var modal = $('#aesop-generator-wrap');

	// start new
	$('.aesop-add-story-component').click(function(e){
		e.preventDefault();

		if ( typeof window.aiactive !== 'undefined' ) {
	      alert('Nesting components within the visual interface is not supported.');
	    } else if ( typeof window.ailocked !== 'undefined' ) {
	      alert('Please click on the editor and set your cursor location first.');
	    } else {
	      jQuery('body').toggleClass('modal-open');
	      jQuery(modal).toggleClass('aesop-generator-open');
	    }

	});

	var settingsHeight = function(){
		var height  = $(window).height() - 60;
		var width = $(window).width();

		if ( width < 782 ) {
			var genLeftHeight = $('.aesop-generator-left').height();
			var buttonHeight = $('.aesop-buttoninsert-wrap').height();
		} else {
			var genLeftHeight = '';
			var buttonHeight = '';
		}
		$('#aesop-generator-settings-outer').css({'height':height + genLeftHeight + buttonHeight});

		if ( height < 700 && width > 782 ) {
			$('.aesop-generator-left').addClass('aesop-generator-small-height');
		} else {
			$('.aesop-generator-left').removeClass('aesop-generator-small-height');
		}
	}

	var destroyModal = function(){
    if ( typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor ) {
      var editing = tinyMCE.activeEditor.dom.select('#aesop-generator-editing');
      if(editing != ''){
        editing[0].removeAttribute('id');
      }
    }
		$(modal).removeClass('aesop-generator-open');
		$('body').removeClass('modal-open');
    $('body').removeClass('modal-updating');
	}
	settingsHeight();

	$(window).resize(function(){
		settingsHeight();
	});
	  	// close modals on escape
	$(document).keyup(function(e) {

		if (e.keyCode == 27) {
			destroyModal();
		}
	});

	$('.aesop-close-modal').click(function(e){
		e.preventDefault();
		destroyModal();
	});

	$('.post-type-ai_galleries .insert-media').html('<span class="dashicons dashicons-images-alt2"></span> Add Gallery');

	// end new

	$('.aesop-generator').dropkick({
		change: function () {

    		var queried_shortcode = $('#aesop-generator-select').find(':selected').val();
			$('#aesop-generator-settings').html(aesopshortcodes[queried_shortcode]);

			// conditionally load the map marker shortcode
			// since 1.3
			$('.aesop-map-sticky #aesop-generator-attr-sticky').on('change',function(){
				var selectedValue = $(this).val();

				if( 'off' == selectedValue ) {
					$('#aesop-generator-wrap li.map_marker').fadeOut();

				} else {
					$('#aesop-generator-wrap li.map_marker').fadeIn().css('display','inline-block');
				}

			});

			////
			// conditional loading
			////

			/*
			var hiddenClass			= $('aesop-option-hidden'),
				openClass			= $('aesop-option-open'),
				hiddenQuoteOpts 	= $('.aesop-quote-speed, .aesop-quote-offset, .aesop-quote-direction'),
				hiddenParallaxOpts 	= $('.aesop-parallax-floatermedia, .aesop-parallax-floaterposition, .aesop-parallax-floateroffset, .aesop-parallax-floaterdirection'),
				hiddenVideoOpts 	= $('.aesop-video-hosted, .aesop-video-loop, .aesop-video-autoplay, .aesop-video-controls, .aesop-video-viewstart, .aesop-video-viewend');

			// quote component
			$('.aesop-quote-parallax #aesop-generator-attr-parallax').on('change',function(){
				var selectedValue = $(this).val();

				if( 'on' === selectedValue ) {
					$(hiddenQuoteOpts).removeClass('aesop-option-hidden').addClass('aesop-option-open');
					$.cookie('aesop-quote-parallax-options', 'visible', { expires: 7 });
				} else {
					$(hiddenQuoteOpts).removeClass('aesop-option-open').addClass('aesop-option-hidden');
					$.cookie('aesop-quote-parallax-options', 'hidden', { expires: 7 });
				}

			});

			// parallax component
			$('.aesop-parallax-floater #aesop-generator-attr-floater').on('change',function(){
				var selectedValue = $(this).val();

				if( 'on' === selectedValue ) {
					$(hiddenParallaxOpts).addClass('aesop-option-open');
					$.cookie('aesop-parallax-options', 'visible', { expires: 7 });
				} else {
					$(hiddenParallaxOpts).removeClass('aesop-option-open').addClass('aesop-option-hidden');
					$.cookie('aesop-parallax-options', 'hidden', { expires: 7 });
				}

			});

			// video component
			$('.aesop-video-src #aesop-generator-attr-src').on('change',function(){
				var selectedValue = $(this).val();

				if( 'self' === selectedValue ) {
					$(hiddenVideoOpts).addClass('aesop-option-open');
					$('.aesop-video-id').removeClass('aesop-option-open').addClass('aesop-option-hidden');
					$.cookie('aesop-video-options', 'visible', { expires: 7 });
				} else {
					$(hiddenVideoOpts).removeClass('aesop-option-open').addClass('aesop-option-hidden');
					$('.aesop-video-id').addClass('aesop-option-open');
					$.cookie('aesop-video-options', 'hidden', { expires: 7 });
				}

			});

			////
			// set cookies for remembered states
			// @todo - need to account for multiple components in editor
			////

			// set quote cookie
			if ( 'visible' == $.cookie('aesop-quote-parallax-options') ) {
				$(hiddenQuoteOpts).addClass('aesop-option-open');
			} else if ( 'hidden' == $.cookie('aesop-quote-parallax-options') ) {
				$(hiddenQuoteOpts).addClass('aesop-option-hidden');
			}

			// set paralalx cookie
			if ( 'visible' == $.cookie('aesop-parallax-options') ) {
				$(hiddenParallaxOpts).addClass('aesop-option-open');
			} else if ( 'hidden' == $.cookie('aesop-parallax-options') ) {
				$(hiddenParallaxOpts).addClass('aesop-option-hidden');
			}

			// set paralalx cookie
			if ( 'visible' == $.cookie('aesop-video-options') ) {
				$(hiddenVideoOpts).addClass('aesop-option-open');
			} else if ( 'hidden' == $.cookie('aesop-video-options') ) {
				$(hiddenVideoOpts).addClass('aesop-option-hidden');
			}
			*/
        }
	});



	// Insert shortcode
	$('#aesop-generator-insert,.aesop-generator').live('click', function() {

		$('.aesop-generator-empty').hide();
		var queried_shortcode = $('.aesop-generator').find(':selected').val();
		var aesop_compatibility_mode_prefix = $('#aesop-compatibility-mode-prefix').val();
		$('#aesop-generator-result').val('[' + aesop_compatibility_mode_prefix + queried_shortcode);
		$('#aesop-generator-settings .aesop-generator-attr').each(function() {
			if ( $(this).val() !== '' ) {
				$('#aesop-generator-result').val( $('#aesop-generator-result').val() + ' ' + $(this).attr('name') + '="' + $(this).val() + '"' );
			}
		});
		$('#aesop-generator-result').val($('#aesop-generator-result').val() + ']');

		// wrap shortcode
		if ( $('#aesop-generator-content').val() != 'false' ) {
			$('#aesop-generator-result').val($('#aesop-generator-result').val() + $('#aesop-generator-content').val() + '[/' + aesop_compatibility_mode_prefix + queried_shortcode + ']');
		}

    if ( typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor ) {
      var editing = tinyMCE.activeEditor.dom.select('#aesop-generator-editing');
      $(editing).replaceWith('<p></p>');
    }

		window.send_to_editor(jQuery('#aesop-generator-result').val());

		// start new
		destroyModal();
		// end new

		return false;

	});


});

// media uploader
var file_frame;
var className;

jQuery(document).on('click', '#aesop-upload-img', function( e ){

    e.preventDefault();

    className = e.currentTarget.parentElement.className;

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      	file_frame.open();
      	return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      	title: jQuery( this ).data( 'uploader_title' ),
      	button: {
        	text: jQuery( this ).data( 'uploader_button_text' ),
      	},
      	multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      var attachment = file_frame.state().get('selection').first().toJSON();
      jQuery('.' + className + ' .aesop-generator-attr-media_upload').val(attachment.url);
    });

    // Finally, open the modal
    file_frame.open();
});
/**
 * DropKick
 *
 * Highly customizable <select> lists
 * https://github.com/JamieLottering/DropKick
 *
 * &copy; 2011 Jamie Lottering <http://github.com/JamieLottering>
 *                        <http://twitter.com/JamieLottering>
 * 
 */
(function ($, window, document) {

  var ie6 = false;

  // Help prevent flashes of unstyled content
  if ($.browser.msie && $.browser.version.substr(0, 1) < 7) {
    ie6 = true;
  } else {
    document.documentElement.className = document.documentElement.className + ' dk_fouc';
  }
  
  var
    // Public methods exposed to $.fn.dropkick()
    methods = {},

    // Cache every <select> element that gets dropkicked
    lists   = [],

    // Convenience keys for keyboard navigation
    keyMap = {
      'left'  : 37,
      'up'    : 38,
      'right' : 39,
      'down'  : 40,
      'enter' : 13
    },

    // HTML template for the dropdowns
    dropdownTemplate = [
      '<div class="dk_container" id="dk_container_{{ id }}" tabindex="{{ tabindex }}">',
        '<a class="dk_toggle">',
          '<span class="dk_label">{{ label }}</span>',
        '</a>',
        '<div class="dk_options">',
          '<ul class="dk_options_inner">',
          '</ul>',
        '</div>',
      '</div>'
    ].join(''),

    // HTML template for dropdown options
    optionTemplate = '<li class="{{ current }} {{ classvalue }}"><a data-dk-dropdown-value="{{ value }}">{{ text }}</a></li>',

    // Some nice default values
    defaults = {
      startSpeed : 1000,  // I recommend a high value here, I feel it makes the changes less noticeable to the user
      theme  : false,
      change : false
    },

    // Make sure we only bind keydown on the document once
    keysBound = false
  ;

  // Called by using $('foo').dropkick();
  methods.init = function (settings) {
    settings = $.extend({}, defaults, settings);

    return this.each(function () {
      var
        // The current <select> element
        $select = $(this),

        // Store a reference to the originally selected <option> element
        $original = $select.find(':selected').first(),

        // Save all of the <option> elements
        $options = $select.find('option'),

        // We store lots of great stuff using jQuery data
        data = $select.data('dropkick') || {},

        // This gets applied to the 'dk_container' element
        id = $select.attr('id') || $select.attr('name'),

        // This gets updated to be equal to the longest <option> element
        width  = settings.width || $select.outerWidth(),

        // Check if we have a tabindex set or not
        tabindex  = $select.attr('tabindex') ? $select.attr('tabindex') : '',

        // The completed dk_container element
        $dk = false,

        theme
      ;

      // Dont do anything if we've already setup dropkick on this element
      if (data.id) {
        return $select;
      } else {
        data.settings  = settings;
        data.tabindex  = tabindex;
        data.id        = id;
        data.$original = $original;
        data.$select   = $select;
        data.value     = _notBlank($select.val()) || _notBlank($original.attr('value'));
        data.label     = $original.text();
        data.options   = $options;
      }

      // Build the dropdown HTML
      $dk = _build(dropdownTemplate, data);

      // Make the dropdown fixed width if desired
      $dk.find('.dk_toggle').css({
        'width' : width + 'px'
      });

      // Hide the <select> list and place our new one in front of it
      $select.before($dk);

      // Update the reference to $dk
      $dk = $('#dk_container_' + id).fadeIn(settings.startSpeed);

      // Save the current theme
      theme = settings.theme ? settings.theme : 'default';
      $dk.addClass('dk_theme_' + theme);
      data.theme = theme;

      // Save the updated $dk reference into our data object
      data.$dk = $dk;

      // Save the dropkick data onto the <select> element
      $select.data('dropkick', data);

      // Do the same for the dropdown, but add a few helpers
      $dk.data('dropkick', data);

      lists[lists.length] = $select;

      // Focus events
      $dk.bind('focus.dropkick', function (e) {
        $dk.addClass('dk_focus');
      }).bind('blur.dropkick', function (e) {
        $dk.removeClass('dk_open dk_focus');
      });

      setTimeout(function () {
        $select.hide();
      }, 0);
    });
  };

  // Allows dynamic theme changes
  methods.theme = function (newTheme) {
    var
      $select   = $(this),
      list      = $select.data('dropkick'),
      $dk       = list.$dk,
      oldtheme  = 'dk_theme_' + list.theme
    ;

    $dk.removeClass(oldtheme).addClass('dk_theme_' + newTheme);

    list.theme = newTheme;
  };

  // Reset all <selects and dropdowns in our lists array
  methods.reset = function () {
    for (var i = 0, l = lists.length; i < l; i++) {
      var
        listData  = lists[i].data('dropkick'),
        $dk       = listData.$dk,
        $current  = $dk.find('li').first()
      ;

      $dk.find('.dk_label').text(listData.label);
      $dk.find('.dk_options_inner').animate({ scrollTop: 0 }, 0);

      _setCurrent($current, $dk);
      _updateFields($current, $dk, true);
    }
  };

  // Expose the plugin
  $.fn.dropkick = function (method) {
    if (!ie6) {
      if (methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      } else if (typeof method === 'object' || ! method) {
        return methods.init.apply(this, arguments);
      }
    }
  };

  // private
  function _handleKeyBoardNav(e, $dk) {
    var
      code     = e.keyCode,
      data     = $dk.data('dropkick'),
      options  = $dk.find('.dk_options'),
      open     = $dk.hasClass('dk_open'),
      current  = $dk.find('.dk_option_current'),
      first    = options.find('li').first(),
      last     = options.find('li').last(),
      next,
      prev
    ;

    switch (code) {
      case keyMap.enter:
        if (open) {
          _updateFields(current.find('a'), $dk);
          _closeDropdown($dk);
        } else {
          _openDropdown($dk);
        }
        e.preventDefault();
      break;

      case keyMap.up:
        prev = current.prev('li');
        if (open) {
          if (prev.length) {
            _setCurrent(prev, $dk);
          } else {
            _setCurrent(last, $dk);
          }
        } else {
          _openDropdown($dk);
        }
        e.preventDefault();
      break;

      case keyMap.down:
        if (open) {
          next = current.next('li').first();
          if (next.length) {
            _setCurrent(next, $dk);
          } else {
            _setCurrent(first, $dk);
          }
        } else {
          _openDropdown($dk);
        }
        e.preventDefault();
      break;

      default:
      break;
    }
  }

  // Update the <select> value, and the dropdown label
  function _updateFields(option, $dk, reset) {
    var value, label, data;

    value = option.attr('data-dk-dropdown-value');
    label = option.text();
    data  = $dk.data('dropkick');

    $select = data.$select;
    $select.val(value);

    $dk.find('.dk_label').text(label);

    reset = reset || false;

    if (data.settings.change && !reset) {
      data.settings.change.call($select, value, label);
    }
  }

  // Set the currently selected option
  function _setCurrent($current, $dk) {
    $dk.find('.dk_option_current').removeClass('dk_option_current');
    $current.addClass('dk_option_current');

    _setScrollPos($dk, $current);
  }

  function _setScrollPos($dk, anchor) {
    var height = anchor.prevAll('li').outerHeight() * anchor.prevAll('li').length;
    $dk.find('.dk_options_inner').animate({ scrollTop: height + 'px' }, 0);
  }

  // Close a dropdown
  function _closeDropdown($dk) {
    $dk.removeClass('dk_open');
  }

  // Open a dropdown
  function _openDropdown($dk) {
    var data = $dk.data('dropkick');
    $dk.find('.dk_options').css({ top : $dk.find('.dk_toggle').outerHeight() - 1 });
    $dk.toggleClass('dk_open');

  }

  /**
   * Turn the dropdownTemplate into a jQuery object and fill in the variables.
   */
  function _build (tpl, view) {
    var
      // Template for the dropdown
      template  = tpl,
      // Holder of the dropdowns options
      options   = [],
      $dk
    ;

    template = template.replace('{{ id }}', view.id);
    template = template.replace('{{ label }}', view.label);
    template = template.replace('{{ tabindex }}', view.tabindex);

    if (view.options && view.options.length) {
      for (var i = 0, l = view.options.length; i < l; i++) {
        var
          $option   = $(view.options[i]),
          current   = 'dk_option_current',
          oTemplate = optionTemplate
        ;

         oTemplate = oTemplate.replace('{{ classvalue }}', $option.val());
        oTemplate = oTemplate.replace('{{ value }}', $option.val());
        oTemplate = oTemplate.replace('{{ current }}', (_notBlank($option.val()) === view.value) ? current : '');
        oTemplate = oTemplate.replace('{{ text }}', $option.text());

        options[options.length] = oTemplate;
      }
    }

    $dk = $(template);
    $dk.find('.dk_options_inner').html(options.join(''));

    return $dk;
  }

  function _notBlank(text) {
    return ($.trim(text).length > 0) ? text : false;
  }

  $(function () {

    // Handle click events on the dropdown toggler
    $('.dk_toggle').live('click', function (e) {
      var $dk  = $(this).parents('.dk_container').first();

      _openDropdown($dk);

      if ("ontouchstart" in window) {
        $dk.addClass('dk_touch');
        $dk.find('.dk_options_inner').addClass('scrollable vertical');
      }

      e.preventDefault();
      return false;
    });

    // Handle click events on individual dropdown options
    $('.dk_options a').live(($.browser.msie ? 'mousedown' : 'click'), function (e) {
      var
        $option = $(this),
        $dk     = $option.parents('.dk_container').first(),
        data    = $dk.data('dropkick')
      ;
    
      _closeDropdown($dk);
      _updateFields($option, $dk);
      _setCurrent($option.parent(), $dk);
    
      e.preventDefault();
      return false;
    });

    // Setup keyboard nav
    $(document).bind('keydown.dk_nav', function (e) {
      var
        // Look for an open dropdown...
        $open    = $('.dk_container.dk_open'),

        // Look for a focused dropdown
        $focused = $('.dk_container.dk_focus'),

        // Will be either $open, $focused, or null
        $dk = null
      ;

      // If we have an open dropdown, key events should get sent to that one
      if ($open.length) {
        $dk = $open;
      } else if ($focused.length && !$open.length) {
        // But if we have no open dropdowns, use the focused dropdown instead
        $dk = $focused;
      }

      if ($dk) {
        _handleKeyBoardNav(e, $dk);
      }
    });
  });
})(jQuery, window, document);
