# Description
Aesop Story Engine is an open-sourced suite of tools that empowers developers to build feature-rich, interactive, long-form storytelling themes for Wordpress. ASE is the same engine that drives the storytelling experience through our hosted platform.

---

### Installation 
##### Uploading in WordPress Dashboard    

1. Navigate to the 'Add New' in the plugins dashboard  
2. Navigate to the 'Upload' area  
3. Select `aesop-core.zip` from your computer  
4. Click 'Install Now'  
5. Activate the plugin in the Plugin dashboard  

##### Using FTP  

1. Download `aesop-core.zip`  
2. Extract the `aesop-core` directory to your computer  
3. Upload the `aesop-core` directory to the `/wp-content/plugins/` directory  
4. Activate the plugin in the Plugin dashboard    

---

### Story Components 
At the heart of ASE are the storytelling components. They include:  
* Audio  
* Video  
* Content  
* Character  
* Galleries  
* Chapter Headings  
* Image  
* Locations  
* Parallax  
* Quote  
* Timeline  
* Collections  
* Document Viewer  

Interactive elements are created while crafting stories, with the Story Component Creator.    
![Image](https://dl.dropboxusercontent.com/u/5594632/ase-screenshot.png)

---

### Changelog
1.0 - Alpha release

---

### TODO
* Mobile Optimization - At the moment nothing has been done for mobile. ASE adds body classes for browser type, tablet, and OS so tweaking CSS is simple. Next up, conditional script loading for mobile, as well as retina and image optimization support.  
* Parallax Floater - The floater attribute in the Parallax component isn't working right now. I was using Skrollr but did not like the way it affected scrolling on mobile. Since Skrollr was only being used for the floater, the script was removed. Seemed overkill. Next up, a custom and lightweight implementation.  

---

### Known Issues
* Locations Component - The locations map can only be used once within a story.  