=== Carbon Pagination ===
Contributors: tyxla
Tags: pagination, paging, page, comments, loop, pages, prev, next, first, last, carbon, admin, developer, configuration, extend, advanced
Requires at least: 3.8
Tested up to: 4.3.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A basic plugin for pagination with advanced capabilities for extending.

== Description ==

A handy WordPress library for building all kinds of paginations. 
Provides the theme and plugin developers an easy way to build and implement highly customizable paginations, specifically tailored to their needs. 
Can be used as a WordPress plugin as well.

== Installation ==

1. Install Carbon Pagination either via the WordPress.org plugin directory, or by uploading the files to your server.
1. Activate the plugin.
1. That's it. You're ready to go! Please, refer to the Configuration section for examples and usage information.

== Configuration ==

The following example is the most basic way to display a posts pagination (see **Configuration Options** for all types of pagination), using the default options:
	
`<?php carbon_pagination('posts'); ?>`

If using Carbon Pagination as a plugin, it would be best to check if the function exists:
	
`<?php 
if ( function_exists('carbon_pagination') ) {
	carbon_pagination('posts'); 
}
?>`

The `carbon_pagination()` function is a wrapper around the `Carbon_Pagination_Presenter` class, which handles pagination presentation. Which means you can also do the above this way:

`<?php Carbon_Pagination_Presenter::display('posts'); ?>`

Of course, if using Carbon Pagination as a plugin, it would be best to check if the class exists:

`<?php 
if ( class_exists('Carbon_Pagination_Presenter') ) {
	Carbon_Pagination_Presenter::display('posts');
}
?>`

For additional configuration and developer documentation, you can visit the Github repository: 

https://github.com/2createStudio/carbon-pagination

== Ideas and bug reports ==

Any ideas for new functionality that users would benefit from are welcome. 

If you have an idea for a new feature, or you want to report a bug, feel free to do it here in the Support tab, or you can do it at the Github repository of the project: 

https://github.com/2createStudio/carbon-pagination

== Changelog ==

= 1.0.1 =
Minor polishing updates.

= 1.0 =
Initial version.