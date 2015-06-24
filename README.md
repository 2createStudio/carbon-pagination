Carbon Pagination
=================

### About

A handy WordPress library for building all kinds of paginations. 
Provides the theme and plugin developers an easy way to build and implement highly customizable paginations, specifically tailored to their needs. 
Can be used as a WordPress plugin as well.

- - -

Usage & Examples
----------------

#### Basic Usage

The following example is the most basic way to display a posts pagination (see Configuration Options for all types of pagination), using the default options:
	
	<?php carbon_pagination('posts'); ?>

If using Carbon Pagination as a plugin, it would be best to check if the function exists:
	
	<?php 
	if ( function_exists('carbon_pagination') ) {
		carbon_pagination('posts'); 
	}
	?>

The `carbon_pagination()` function is a wrapper around the main Carbon_Pagination class. Which means you can also do the above this way:

	<?php Carbon_Pagination::display('posts'); ?>

Of course, if using Carbon Pagination as a plugin, it would be best to check if the class exists:

	<?php 
	if ( class_exists('Carbon_Pagination') ) {
		Carbon_Pagination::display('posts');
	}
	?>