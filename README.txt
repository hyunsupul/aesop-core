=== Aesop Story Engine ===
Contributors: nphaskins, mauryaratan, Tmeister, etcio
Author URI:  http://nickhaskins.com
Plugin URI: http://aesopstoryengine.com
Donate link: http://aesopstoryengine.com/donate
Tags: aesop, story, business, education, parallax, interactive, shortcode, gallery, grid gallery, thumbnail gallery,
Requires at least: 3.8
Tested up to: 4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Suite of components that enables the creation of interactive longform stories in WordPress.

== Description ==

The Aesop Story Engine is a suite of open-sourced tools and components that empower developers and writers to build feature-rich, interactive, long-form storytelling themes for WordPress. At the heart of ASE are the suite of storytelling components, which are created on the fly while crafting posts within WordPress.

[http://aesopstoryengine.com](http://aesopstoryengine.com)

[youtube http://www.youtube.com/watch?v=84BFGxkHby0]

**Try Aesop for Free**
[http://tryaesop.com](http://tryaesop.com)

Utilizing these components, writers can can take their work to the next level, and developers can utilize the core storytelling engine to build feature-rich, visually compelling WordPress themes. Here’s a demo theme incorporating these story components.
[http://playground.aesopstories.com](http://playground.aesopstories.com)

**Audio**
Display an audio player with support for MP3 that can be optionally hidden. This is great for showcasing audio interviews.

**Video**
Showcase a fullscreen video with support for Kickstarter, Viddler, YouTube, Vimeo, Daily Motion, and Blip.TV with support for captions and alignment.

**Content**
The content component is a multi-purpose component that can display a background image, background color, or can split the content into multiple magazine type columns.

**Character**
Display a character avatar, title, and small bio to help readers be reminded of key story characters.

**Galleries**
The ASE Gallery component allows you to create and manage unlimited story galleries. Each gallery can be displayed as a grid, a thumbnail gallery, stacked, or sequential type gallery, all with caption support.

**Chapter Headings**
Creates scroll-to points with large full-screen images as headings.

**Image**
The image component displays an image and caption, with optional lightbox. Also allows you to align the image, as well as offset the image so it hangs outside of the content column.

**Locations**
This component allows you to create a map for your story. You can add markers to the map with custom messages, and even have the map scroll to points as you scroll through the story.

**Parallax**
A fullwidth image component with caption and lightbox. As you scroll, the image moves slightly to provide a parallax effect. Includes optional floater parallax item to use for multiple levels of parallax engagement.

**Quote**
Show a fullwidth quote with large text, or a standard pull-quote. Control the color and background of the quote component, add parallax effects, and more.

**Timeline**
Create a story with a timeline that sticks to the bottom. The timeline works a bit like chapters.

**Collections**
The 13th component is meant to be used on a page of your site, and allows you to display stories from a specific collection (category).

**Document Viewer**
This component allows you to upload a PDF or image, that is shown to the user once they click the component.

Here’s a demo theme incorporating these story components.
[http://playground.aesopstories.com](http://playground.aesopstories.com)

Here’s a real story.
[http://aesopstoryseri.es/the-quiet-day/](http://aesopstoryseri.es/the-quiet-day/)

Here’s documentation on the Story Engine.
[http://aesopstoryengine.com/help](http://aesopstoryengine.com/help)


= Theme Implementation =

It’s important to know that the plugin only produces very basic CSS for the components. The theme is responsible for making the components appear different ways. For this reason, the Timeline and Chapter components may not function as intended. Refer to your themes documentation to see if it fully supports Aesop.

Theme authors and developers will find documentation covering everything from the markup that is generated, to actions, filters, and instructions for full Aesop integration.

[http://aesopstoryengine.com/developers](http://aesopstoryengine.com/developers)

** Update 7.31.14 **
Aesop Story Engine 1.0.9 now features full theme compatibility with a simple code snippet that will load styles based on the components that you decide. While a dedicated theme is required to run components full-width, this will at least load all of the additional styles to give a basic design. Simply remove the component that you do not want to load additional styles for.

`add_theme_support("aesop-component-styles", array("parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline") );`

We recommend placing this in a WordPress themes functions.php, or use a plugin like [Code Snippets](https://wordpress.org/plugins/code-snippets/) and put it there.

= Developers =
All components are pluggable, and there are ample filters and actions to manipulate just about everything you can imagine. Refer to the documentation below for more.

[http://aesopstoryengine.com/developers](http://aesopstoryengine.com/developers)

If you think something is missing, we want to hear from you. Post your request and bugs on [Github](https://github.com/bearded-avenger/aesop-core).

= Languages =
Aesop Story Engine is currently available in 30 languages. We work closely with the folks over at WP Translations, and it's because of them that these translations are available.

* Български (Bulgarian)
* čeština‎ (Czech)
* 中文 (Chinese (China)) 
* Dansk (Danish) 
* Nederlands (Dutch) 
* English (US) 
* Suomi (Finnish)
* Français (French (France))
* Deutsch (German)
* Ελληνικά (Greek)
* עִבְרִית (Hebrew)
* Magyar (Hungarian)
* Italiano (Italian)
* 日本語 (Japanese)
* ភាសាខ្មែរ (Khmer)
* 한국어 (Korean)
* Bokmål (Norwegian)
* فارسی (Persian)
* Polski (Polish)
* Português do Brasil (Portuguese (Brazil))
* Română (Romanian)
* Русский (Russian)
* Српски језик (Serbian)
* Slovenčina (Slovak)
* slovenščina (Slovenian)
* Español (Spanish (Argentina))
* Español (Spanish (Spain))
* ไทย (Thai)
* Türkçe (Turkish)
* Tiếng Việt (Vietnamese)

== Installation ==

= Uploading in WordPress Dashboard =

1. Navigate to 'Add New' in the plugins dashboard
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
Various theme shops in the industry are actively creating Aesop Themes, in addition to the official Aesop themes located at http [http://aesopstoryengine.com/library](http://aesopstoryengine.com/library)

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

= 1.6.1 =
* FIX - Patched XSS vulnerability with not properly escaping add_query_arg(). Only an attacker with admin priveledged would have been able to take advantage of this vulnerability.

= 1.6 =
* FIX - PHP notice being triggered from not padding in an ID for current_user_can('edit_post')
* FIX - Better detection of Lasso being activated due to autoloaders in Lasso
* FIX - Fixed the quote cite markup being escaped, thus not being styled correctly
* FIX - Height not triggering correctly on Parallax component if Parallax is set to off
* TWEAK - Height of the parallax component now respects height of image if parallax is set to off
* TWEAK - Improved the responsive nature of the stacked gallery component
* TWEAK - All actions now have $atts and $unique attributes added for fine grain control over adding things to specific components
* TRANSLATIONS - Added Bulgarian, China, Danish, Dutch, Finissh, German, Greek, Hungarian, Khmer, Korean, Norwegian, Persian, Slovak, Slovenian, Spanish Argentina, Spanish Spain, Thai, Vietnames - Aesop is now available in 29 languates thanks to WP Translations!

= 1.5.2 =
* FIX - Fixed an issue with the Photoset gallery breaking with the last update
* FIX - Added a capability check so admin_notices aren't shown to non-admins

= 1.5.1 =
* FIX - Massive codebase overhaul bringing Aesop Story Engine close to WordPress VIP plugin standards
* FIX - Combed through the codebase and removed all unused vars and updated php docs per Scrutinizer
* FIX - Undefined $classes variable in Quote component
* FIX - Fixed an issue with the Parallax component where the height would sometimes not be calculated correctly
* FIX - Added additional logic to the Mapbox upgrade process sent with 1.5 to check for an empty value to ensure better upgrade notifications
* FIX - Fixed the welcome page on plugin activation not firing correctly
* ADDED - Added headings to the aesop_component_media_filter

= 1.5 =
* NEW - Welcome screen on plugin activation
* NEW - New "Type" option for Quote Component which allows the quote to be displayed as a standard pull quote
* FIX - Blank map tiles with new Mapbox IDs. Mapbox changed things and now requires a public key for the map tiles. We're using our public key, but have introduced a filter should you need to change this. On this update, we've changed our mapbox id, and have written an upgrade script that will ensure you have a smooth transition in this update
* FIX - The document component css class has been renamed! This was inevitable. It was mis-labeled as docmument component from day one, so we've fixed it to the proper spelling, of "document" component

= 1.4.2 =
* NEW - Compatibility with Lasso - our soon to be released front-end editor add-on
* NEW - Now available in 14 languages - props wp-translations.org
* FIX - Numerous i18n fixes - props wp-translations.org
* FIX - Fixed improper audio title formatting
* FIX - Fixed audio component attributes filter name
* FIX - Fixed an error within the Gallery admin affecting PHP 5.4
* FIX - Fixed bug with TinyMCE load dependency
* TWEAK - Better compatibility with the Aesop Lazy Loader add-on
* TWEAK - Prevent "Upgrade Galleries" notice from showing if you've already upgraded galleries
* TWEAK - The Parallax component has gotten a significant overhaul. The most important being that the height attribute is no longer used. Instead, the height of the parallax component is not only fluid and responsive, but it's automatically calculated based on the height of the image that you upload. In this regard it should always be sized perfectly. It's best to use an image at least 800px tall. In addition, the parallax image width is now respected, which means there's no more clipping on left and right. Although we hate to remove the "fixed height" option, and although we realize this might be seen as a jarrying change, we hope you'll enjoy this significant but necessary improvement.

= 1.4.1 =
* FIXED - Yandex in Fotorama : A few updates back we attempted to block Fotorama from inserting its Yandex tracker. Since we noticed that this sometimes fails to block, we've modified their source code and have removed it completely. It's also worth noting that they've gotten a lot of heat from this, and have since removed it all together from their script. This should no longer be an issue, and we apologize for any inconviences that we may have inadvertantly caused.

= 1.4 =
* NEW - Redesigned gallery admin - makes creating and managing galleries easier than ever before
* NEW - Chapter component slideout - fully compatible with all WordPress themes ( with extended css support snippet ).
* NEW - Chapter component placeholders now show Chapter titles in the editor - props @crowjonah
* NEW - Map markers (used with Sticky Maps) now shows Marker textin the placeholder in the editor - propes @crowjonah
* FIXED - Bug with maps not correctly displaying in admin in Firefox
* FIXED - Sticky map styles bleeding out of single posts
* FIXED - Image upload bug when using multiple image fields (only affects 3rd party plugins)
* FIXED - Transparent issue with YouTube video player in IE 11 - props @artjosimon
* FIXED - Stacked Parallax gallery bug
* NOTE - With the new Galleries in 1.4, the metabox library has been removed from Aesop Story Engine, saving space and reducing the size of the code base. This will only affect 3rd party developers who are relying on our library. Visit Github repo for more details on fixes.

= 1.3.2 =
* FIXED - Code showing in Chapter Component
* FIXED - Parallax floater markup
* FIXED - Sequence gallery images not showing

= 1.3.1 =
* HOTFIX - Fix syntax not supported by PHP older than 5.4

= 1.3 =
* NEW - Freshly designed user interface with light color scheme to match WordPress design patterns
* NEW - Map component admin with ability to click the map to add markers instead of manually adding GPS coordinates
* NEW - Map component "sticky" mode that changes map markers as you scroll down the story
* NEW - Map component tile filter aesop_map_tile_provider that allow you to specify a different tile provider per post (or globally) [ref](https://github.com/bearded-avenger/aesop-core/pull/172#issuecomment-63518448)
* NEW - Components can now be cloned
* NEW - New filter aesop_quote_component_unit to change unit size of blockquote
* FIXED - All variables now properly escaped within components
* FIXED - The "used in" column of the Galleries edit screen
* FIXED - Additional spaces being added on the front end after saving components
* FIXED - Timeline scrollnav build failing on certain occassions
* FIXED - Some parts of the component placeholder highlighting after clicking the edit button
* FIXED - JS error that shows if the visual editor is turned off in options (props @wavetree)
* FIXED - Self hosted videos not stretching to 100% width
* FIXED - Zero height on an aligned video component
* FIXED - Only show grid caption markup if captions present (props @artjomsimon)
* TWEAK - Related videos at the end of YouTube videos now off by default (props @artjomsimon)
* TWEAK - Improved video markup
* UPDATED - Fotorama, fitvids, scrollnav, and images loaded to their respective current versions

= 1.2.1 ==
* FIXED - lightbox gallery images not opening in grid gallery
* FIXED - warnings with custom meta boxes if wp-admin is set to SSL
* UPDATED - custom meta boxes to 1.2
* NOTE - The next update we will be moving from Custom Meta Boxes by Humanmade to CMB2 by WebDev Studios.

= 1.2 =
* FIXED - Width on videos so that they remain responsive
* FIXED - Undefined variable in thumbnail gallery
* FIXED - Gallery images not respecting sizes
* FIXED - Issue of overlapping placeholders when updating a component thats next to another component - #138 on GH
* ADDED - New action "aesop_gallery_type" so 3rd party components can add new gallery types
* ADDED - New filter aesop_generator_loads_on which accepts an array of admin pages to load the generator
* TWEAK - Cleaned up the gallery creation process including removing core options from the gallery settings modal that Aesop doesn't use, along with only running our modifications on Aesop Galleries
* TWEAK - Added additional checks to ensure $post is set before loading map components

= 1.1 =
* NEW - Complete compatibilty with WordPress 4.0
* NEW - New user interface
* NEW - Components are now editable
* NEW - API for creating addons to sell or give away
* NEW - RTL support
* ADDED - Filters for Audio and Video component waypoints
* ADDED - Filters for timeline and location offsets
* ADDED - Filter to let Map component run on pages
* ADDED - Gallery Component: added to the component generator with a dropdown to select gallery to insert
* ADDED - Gallery Component: added captions to grid gallery items if a caption is set
* ADDED - Content Component: added Floater Position option for parallax floater
* TWEAK - Content Component: parallax code optimized and offsets automatically calculated
* TWEAK - Map Component: automatically fall back to the first marker entered if the starting coordinate is missing and warn the user
* TWEAK - Collection Component: mo longer have to input collection ID they are now automatically fed into a dropdown tand selectable by name
* TWEAK - Parallax Component: floater item offset now automatically calculated - this means offset and speed options no longer necessary and have been removed
* TWEAK - Parallax Component: optimizations and performance enhancements
* TWEAK - Gallery Component: performance optimizations
* TWEAK - Cleaned up user interface for creating Galleries in admin
* TWEAK - Audio/Video Component: waypoint filters now targets individual components
* TWEAK - Timeline Component: redesigned to perform well wihin 98% of WordPress themes
* FIXED - Better support for Aesop Lazy Loader
* FIXED - Video icon
* FIXED - Quote Component: parallax floater options fixed (could not move up or down so two options are now left and right)
* FIXED - Map Component:  warn users if no markers are set
* FIXED - Map Component:  fixed empty bubbles appearing on markers with no text set

= 1.0.9 =
* FIXED - Various generator fixes for WordPress 4.0
* FIXED - Fixed not being able to use multiple collections due to invalid cache (props @tmeister)
* FIXED - Fixed the default map zoom so its not so far zoomed out
* FIXED - Video option display error within generator
* FIXED - Spelling of the word Library in generator option descriptions
* NEW - New extended css option that loads additional CSS in an effort to be compatible with more themes out of the box (see docs for more)
* NEW - Updated Polish translation
* NEW - New Photoset gallery type
* NEW - Full compatibility for stacked gallery type. This was previously left up to themes.
* NEW - Content component enhancements for background image
* NEW - Galleries now have ID's that correspond to the gallery id and instance of gallery in the post
* NEW - Filter - stacked gallery styles (aesop_stacked_gallery_styles_ID-INSTANCE) see docs
* NEW - Filter - chapter component inline styles for the background image (aesop_chapter_img_styles_ID-INSTANCE) see docs
* TWEAK - Fixed the way unique ID's are applied to each component to aid in customizing with css
* TWEAK - Don't set a chapter image if one isn't set and add a class for this
* TWEAK - Float class added to character and quote components if component is aligned left or right. This *may* have a different effect on your design so please be aware of this.
* TWEAK - Content component now has wpautop filter applied which will make the text within the content component into proper paragraph elements. this *may* result in additional space in your design so please be aware of this tweak. We've also added a class to the parent component if an image is being used.

= 1.0.8 =
* NEW - option description tip bubbles
* NEW - Misc style refinements to the generator user interface
* NEW - Updated icon for Galleries tab
* NEW - Image caption is now displayed in the lightbox if set
* NEW - changed lightbox to close if background is clicked
* NEW - parallax floater option added to Content Component
* NEW - polish translation - props trzyem
* NEW - four additional hooks added to collections component - props @tmeister
* FIXED - Bug with responsive images when px width is set
* FIXED - Audio player from looping when set to off
* UPDATED - translation file with new strings
* UPDATED - Lightbox script
* CHANGED - Floater can now be parallax even with parallax bg set to off in parallax component
* CHANGED - Changed the “Upload” label to “Select Media”


= 1.0.7 =
* NEW - Parallax floater options added to Content Component
* NEW - Ability to have text positioned anywhere in Content Component
* NEW - Wistia support added to Video Component
* NEW - Option added to Audio Component to make it invisible
* NEW - Looping options enabled in Audio Component
* NEW - Serbian Translation
* FIXED - Bug with Image Component centering classes (props @mauryaratan)

= 1.0.6 =
* NEW - New function aesop_component_exists
* NEW - Added ability for Character Component to set a width
* NEW - Added ability for Audio Component to have an optional title
* NEW - Added ability for Quote Component to have a cite
* FIXED - is_ipad notice on Android and select Windows devices
* FIXED - Better checks for galleries and maps in posts
* FIXED - If Image Component is floated keep it from breaking out of .aesop-content
* FIXED - Missing viewstart and viewend options in Component Editor
* UPDATED - Metabox library

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
