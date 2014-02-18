=== Aesop Story Engine ===
Contributors: nphaskins
Author URI:  http://nickhaskins.com
Plugin URI: http://aesopstories.com/story-engine
Donate link: https://github.com/bearded-avenger/aesop-core
Tags: aesop, story, business, education, parallax, interactive, shortcode, gallery, grid gallery, thumbnail gallery, 
Requires at least: 3.8
Tested up to: 3.9
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Suite of components that enables the creation of interactive storytelling themes for WordPress.

== Description ==

The Aesop Story Engine is a suite of open-sourced tools and components that empower developers and writers to build feature-rich, interactive, long-form storytelling themes for WordPress. At the heart of ASE are the suite of storytelling components, which are created on the fly while crafting posts within WordPress.

[http://aesopstories.com/story-engine](http://aesopstories.com/story-engine)

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
The ASE Gallery component allows you to create and manage unlimited story galleries. Each gallery can be displayed as a grid, a thumbnail gallery, stacked, or sequencial type gallery, all with caption support.

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


= Theme Implementation =

It’s important to know that the plugin only produces very basic CSS for the components. The theme is responsible for making the components appear different ways. For this reason, the Timeline and Chapter components may not function as intended. Refer to your themes documentation to see if it fully supports Aesop.

Theme authors and developers will find documentation covering everything from the markup that is generated, to actions, filters, and instructions for full Aesop integration.

[http://developers.aesopstories.com](http://developers.aesopstories.com)

= Developers =
This story engine was in beta for over 4 months, and every attempt has been made to ensure that 1.0 is as stable as can be. No breaking changes will be made until the next major version, which at the moment isn’t even a speckle in my daddies eye. All components are pluggable, and there are ample filters and actions to manipulate just about everything you can imagine. Refer to the documentation below for more.

[http://developers.aesopstories.com](http://developers.aesopstories.com)

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
[http://developers.aesopstories.com](http://developers.aesopstories.com)

== Screenshots ==

1. The component generator triggered within the edit post screen.
2. Story Engine components and their descriptions

== Upgrade Notice ==

= 1.0 =
* Initial Release


== Changelog ==

= 1.0 =
* Initial Release