=== Aesop Story Engine ===
Contributors: nphaskins, mauryaratan
Author URI:  http://nickhaskins.com
Plugin URI: http://aesopstoryengine.com
Donate link: http://aesopstoryengine.com
Tags: aesop, story, business, education, parallax, interactive, shortcode, gallery, grid gallery, thumbnail gallery,
Requires at least: 3.8
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Suite of components that enables the creation of interactive storytelling themes for WordPress.

== Description ==

The Aesop Story Engine is a suite of open-sourced tools and components that empower developers and writers to build feature-rich, interactive, long-form storytelling themes for WordPress. At the heart of ASE are the suite of storytelling components, which are created on the fly while crafting posts within WordPress.

[http://aesopstoryengine.com](http://aesopstoryengine.com)

[youtube http://www.youtube.com/watch?v=BndId0gvMlA]

Utilizing these components, writers can can take their work to the next level, and developers can utilize the core storytelling engine to build feature-rich, visually compelling WordPress themes. Here’s a demo theme incorporating these story components.
[http://playground.aesopstories.com](http://playground.aesopstories.com)

**Audio**
Display an audio player with support for MP3. This is great for showcasing audio interviews.

**Video**
Showcase a fullscreen video with support for Kickstarter, Viddler, YouTube, Vimeo, Daily Motion, and Blip.TV.

**Content**
The content component is a multi-purpose component that can display a background image, background color, or can split the content into multiple magazine type columns.

**Character**
Display a character avatar, title, and small bio to help readers be reminded of key story characters.

**Galleries**
The ASE Gallery component allows you to create and manage unlimited story galleries. Each gallery can be displayed as a grid, a thumbnail gallery, stacked, or sequential type gallery, all with caption support.

**Chapter Headings**
Creates scroll-to points with headings.

**Image**
The image component displays an image and caption, with optional lightbox. Also allows you to align the image, as well as offset the image so it hangs outside of the content column.

**Locations**
This component allows you to create a map for your story. You can add markers to the map with custom messages. This is a great component for showcasing a characters travels.

**Parallax**
A fullwidth image component with caption and lightbox. As you scroll, the image moves slightly to provide a parallax effect. Includes optional floater parallax item to use for multiple levels of parallax engagement.

**Quote**
Show a fullwidth quote with large text. Control the color and background of the quote component.

**Timeline**
Create a story with a timeline that sticks to the bottom. The timeline works a bit like chapters.

**Collections**
The 13th component is meant to be used on a page of your site, and allows you to display stories from a specific collection (category).

**Document Viewer**
This component allows you to upload a PDF or image, that is shown to the user once they click the component.

Here’s a demo theme incorporating these story components.
[http://playground.aesopstories.com](http://playground.aesopstories.com)

Here’s documentation on the Story Engine.
[http://aesopstoryengine.com/documentation](http://aesopstoryengine.com/documentation)


= Theme Implementation =

It’s important to know that the plugin only produces very basic CSS for the components. The theme is responsible for making the components appear different ways. For this reason, the Timeline and Chapter components may not function as intended. Refer to your themes documentation to see if it fully supports Aesop.

Theme authors and developers will find documentation covering everything from the markup that is generated, to actions, filters, and instructions for full Aesop integration.

[http://aesopstoryengine.com/developers](http://aesopstoryengine.com/developers)

= Developers =
This story engine was in beta for over 4 months, and every attempt has been made to ensure that 1.0 is as stable as can be. No breaking changes will be made until the next major version, which at the moment isn’t even a speckle in my daddies eye. All components are pluggable, and there are ample filters and actions to manipulate just about everything you can imagine. Refer to the documentation below for more.

[http://aesopstoryengine.com/developers](http://aesopstoryengine.com/developers)

If you think something is missing, we want to hear from you. Post your request and bugs on [Github](https://github.com/bearded-avenger/aesop-core).

== Installation ==

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `aesop-core.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `aesop-core.zip`
2. Extract the `aesop-core` directory to your computer
3. Upload the `aesop-core` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= Does this work with all themes? =
Most of the components will work with most themes without any issues. It’s very important to know that this plugin only applies basic styles, and to take full advantage, a theme built for Aesop is probably a good idea.

= Where can I find themes for Aesop? =
That’s something we are actively working on, now that the plugin has finally been released.

= Where can I find more information on making my theme fully compatible? =
Full documentation can be found below.
[http://aesopstoryengine.com/developers](http://aesopstoryengine.com/developers)

== Screenshots ==

1. The component generator triggered within the edit post screen.
2. Story Engine components and their descriptions
/Users/Nick/Sites/wp-aesop/wp-content/plugins/aesop-core/README.txt
== Upgrade Notice ==

= 1.0 =
* Initial Release


== Changelog ==

= 1.0.5 =
* NEW - Added new filter to adjust map meta locations in admin aesop_map_meta_location
* NEW - Added new option to audio and video components viewend="on" which stops from playing once out of view
* NEW - Added new filter to change the scroll container class for Chapter Component aesop_chapter_scroll_container
* NEW - Added new filter to change the scroll nav class for Chapter Component aesop_chapter_nav_container
* NEW - Added new filter to change the scroll container class for Timeline Component aesop_timeline_scroll_container
* NEW - Mark markers can now do some HTML
* FIXED - Bug with failing function on Android
* CHANGED - The action name for inserting the Timeline component has changed from aesop_inside_body_top to ase_theme_body_inside_top. We’ve included a deprecation notice.

= 1.0.4 =
* FIXED - insecure assets if SSL enabled in wp-admin
* FIXED - wrong audio icon
* NEW - Added option for video player to start automatically once in view
* NEW - Added framewidth and frameheight options to video player to preserve aspect ratio
* NEW - Added option to set columns in Collections Component
* NEW - Added option to set stories shown in Collections Component
* NEW - Added new “splash mode” option for Collections Component that displays collection parents
* NEW - Added theme helper shortcode [aesop_center] to be used in aesop themes where items fall outside the “content” width - props @mauryaratan
* NEW - Two new filters to control the offset scroll distance for both Timeline and Chapter components (aesop_timeline_scroll_offset) and (aesop_chapter_scroll_offset)
* NEW - Added filter to control component generator button (aesop_generator_button)
* NEW - Added filter to control gallery grid spacing (aesop_grid_gallery_spacing)
* NEW - Added filter to add custom css classes to the parent container of all components (aesop_COMPONENTNAME_component_classes)
* CHANGED - The scroll offset integers for Timeline and Chapter components were completely arbitrary. These have been set to 0, from 80, and 36.

= 1.0.3 =
* FIXED - parallax image bug in Firefox
* FIXED - added the missing “title” option for Timeline component
* FIXED - image now aligns to center if center alignment and width are set on image component
* NEW - Added option area to Theme Customizer to allow custom map tiles from Mapbox
* NEW - Added option to set the default zoom level in the Map component
* misc bug fixes

= 1.0.2 =
* FIXED - Better value saving
* FIXED - Hosted video not obeying width set
* FIXED - Stopped parallax from running on mobile
* NEW - Added option for audio player to automatically start once in view
* NEW - Added autoplay option to self hosted video component
* NEW - Added loop option to self hosted video component
* NEW - Added controls option to show/hide controls on self hosted video component
* NEW - Options panel for thumbnail galleries type that includes options to control transition, thumbnails, and autostart
* NEW - Added ability for timeline component to have a different title than what the scroll-to navigation holds
* NEW - Added ability to center align caption on image component
* NEW - Refreshed user interface with icons instead of images

= 1.0.1 =
* MOVED - We removed the “automatic remembering of page position.” It’s quite possible nobody has even noticed this feature, as it wasn’t marketed, documented, nor mentioned. We’ve moved it to an upcoming “essentials” plugin. The main reason; this is an unexpected behavior to happen on pages without story components.
* UPDATED - FitVids script with the latest fix for the “white text on Chromium 32” issue
* MOVED - The “content” width class that’s applied to the Content component, was moved from the parent div (.aesop-content-component), to the child div (.aesop-content-comp-inner), so if background images are used in Content the component still stretches 100%.
* FIXED - Fixed the width passing to content box if “content” is passed as attribute
* FIXED - Fixed map component not centering
* FIXED - Fixed incorrect quote size values
* FIXED - Removed ability to set negative Quote size values
* FIXED - Default color picker values passing to generator
* FIXED - Bug with images not working in Document viewer
* FIXED - Audio player from not recognizing audio
* NEW - Sizes “3” and “4” to the Quote component font size
* NEW - Message to empty generator settings
* NEW - Support for Instagram and Vine within Video Component

= 1.0 =
* Initial Release
