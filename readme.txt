=== Carbon Pagination ===
Contributors: 2create, tyxla
Tags: pagination, paging, pagenavi, wp-pagenavi, page, comments, loop, pages, prev, next, first, last, carbon, admin, developer, configuration, extend, advanced
Requires at least: 3.8
Tested up to: 4.3.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A basic plugin for pagination with advanced capabilities for extending.

== Description ==

A handy WordPress library for building all kinds of paginations. 

Provides the theme and plugin developers an easy way to build and implement highly customizable paginations, specifically tailored to their needs. 

This plugin supports 4 types of pagination (you can easily extend the library if you need to create a new type of pagination):

#### Posts

The most common pagination type. Used for paginating through post listings in non-singular context - usually on the posts page, on all types of archives and on search results. This pagination uses the current global `$wp_query`, which means you can use it together with your custom query loops as well.

#### Post

Used for paginating through posts in singular context. Usually used on single posts - `single.php`, but can be used to paginate through entries of any registered post type (including built-in ones like `page`). Uses the global `$post` to determine the current post and paginates through all of the rest posts of the same post type. You can filter the query that retrieves all posts by using the `carbon_pagination_post_pagination_query` filter - please refer to the **Actions & Filters** section for more information.

#### Comments

Used for comments pagination on a given post. Usually used on `single.php` when comments pagination is enabled in **Settings -> Discussion**, but can be used on posts in non-singular context as well. Of course you would have to do the following to be able to list comments in non-singular loops:

	global $withcomments;
	$withcomments = true;

This pagination type supports a comments pagination on the comments of a post of any registered post type.

#### Custom

Used for creating custom flexible paginations. You can specify the total number of pages and the current page by yourself. Also, you'd have to specify the query var that is used to build the pagination links (by default `page` is used).

If you don't specify a current page and total number of pages, this pagination type can be used for content pagination on a single post of any post type (including `page`). Content can be paginated by using the default WordPress <!--nextpage--> quicktag.

If you need a more complex custom pagination, you'd probably want to extend this pagination type - it is being represented by the `Carbon_Pagination_Custom` class.

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

= 1.1 =
Introducing `carbon_pagination_render_item_html` filter hook.
Introducing `carbon_pagination_before_render_item` action hook.
Introducing `carbon_pagination_after_render_item` action hook.
Implemented `{TITLE}` token for the items within `Carbon_Pagination_Post`
Test coverage for all of the above
`Carbon_Pagination_Post` code polishing

= 1.0 =
Initial version.