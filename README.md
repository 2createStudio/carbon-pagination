# Carbon Pagination [![Build Status](https://travis-ci.org/2createStudio/carbon-pagination.svg?branch=master)](https://travis-ci.org/2createStudio/carbon-pagination)

### About

A handy WordPress library for building all kinds of paginations. 

Provides the theme and plugin developers an easy way to build and implement highly customizable paginations, specifically tailored to their needs. 

Can be used as a WordPress plugin as well.

- - -

Usage & Examples
----------------

#### Basic Usage

The following example is the most basic way to display a posts pagination (see **Configuration Options** for all types of pagination), using the default options:
	
	<?php carbon_pagination('posts'); ?>

If using Carbon Pagination as a plugin, it would be best to check if the function exists:
	
	<?php 
	if ( function_exists('carbon_pagination') ) {
		carbon_pagination('posts'); 
	}
	?>

The `carbon_pagination()` function is a wrapper around the main `Carbon_Pagination` class. Which means you can also do the above this way:

	<?php Carbon_Pagination::display('posts'); ?>

Of course, if using Carbon Pagination as a plugin, it would be best to check if the class exists:

	<?php 
	if ( class_exists('Carbon_Pagination') ) {
		Carbon_Pagination::display('posts');
	}
	?>

#### Specifying parameters

You can specify your preferred parameters as the second argument of `carbon_pagination()` and `Carbon_Pagination::display()`. Example:

	<?php 
	carbon_pagination('posts', array(
		'wrapper_before' => '<div class="paging">',
		'wrapper_after' => '</div>',
		'enable_first' => false,
		'enable_last' => false,
		'enable_numbers' => false,
		'number_limit' => 5,
	)); 
	?>

Below is an example, containing all possible settings that you can specify, along with their default values.

	<?php 
	carbon_pagination('posts', array(
		'wrapper_before' => '<div class="paging">',
		'wrapper_after' => '</div>',
		'pages' => array(),
		'current_page' => 1,
		'total_pages' => 1,
		'enable_prev' => true,
		'enable_next' => true,
		'enable_first' => false,
		'enable_last' => false,
		'enable_numbers' => false,
		'enable_current_page_text' => false,
		'number_limit' => -1,
		'large_page_number_limit' => 0,
		'large_page_number_interval' => 10,
		'numbers_wrapper_before' => '<ul>',
		'numbers_wrapper_after' => '</ul>',
		'prev_html' => '<a href="{URL}" class="paging-prev"></a>',
		'next_html' => '<a href="{URL}" class="paging-next"></a>',
		'first_html' => '<a href="{URL}" class="paging-first"></a>',
		'last_html' => '<a href="{URL}" class="paging-last"></a>',
		'number_html' => '<li><a href="{URL}">{PAGE_NUMBER}</a></li>',
		'current_number_html' => '<li class="current"><a href="{URL}">{PAGE_NUMBER}</a></li>',
		'limiter_html' => '<li class="paging-spacer">...</li>',
		'current_page_html' => '<span class="paging-label">Page {CURRENT_PAGE} of {TOTAL_PAGES}</span>',
		'renderer' => 'Carbon_Pagination_Renderer',
		'collection' => 'Carbon_Pagination_Collection',
	)); 
	?>

You can read more about each setting in the **Configuration Options** section.

#### Using and manipulating pagination as an object

In case you need to manipulate the pagination you can define the pagination as an object:

	$pagination = new Carbon_Pagination_Posts(array(
		'wrapper_before' => '<div class="paging">',
		'wrapper_after' => '</div>',
	));

Then you can use any of the `get`/`set` methods of the `Carbon_Pagination` class. Example:
	
	// whether the first link is enabled
	$first_link_enabled = $pagination->get_enable_first();

	// disable first page link
	$pagination->set_enable_first(false);

	// enable last page link
	$pagination->set_enable_last(true);

	// disable page number links
	$pagination->set_enable_numbers(false);

	// set the limit of page number links to 5
	$pagination->set_number_limit(5);

Finally, once you want to render your pagination, you can simply call:

	$pagination->render();

- - -

Dictionary of Terms
-------------------

Various terms that are used within this library are explained and briefly described in this section.

#### Pagination

A pagination is an entire set of functionality that builds the markup, which is used to display links to certain pages of multi-page content. These links can include (but are not limited to) *previous page*, *next page*, *first page*, *last page* or a specific page - *2nd*, *6th*, etc.

#### Wrapper

Used to display some HTML before or after a certain item. A wrapper *"before"* and a wrapper *"after"* together form an entire HTML wrap around an item. Wrappers are usually composed by one or more HTML tags. The *"before"* wrapper usually contains the opening tags and the *"after"* wrapper contains the closing tags.

#### Pages

This term can be used in various context, but in the context of Carbon Pagination it usually refers to the items that you're paginating (navigating) through. Usually, these will be numbers - from `1` to the *total number of pages*, but in some cases these can be post `ID`s or `object`s - whetever you want to paginate through.

#### Item / Pagination Item

Represents a specific fragment or piece of the pagination. Examples for different pagination items are: `prev`, `1`, `20`, `last`, `...`, `Page 1 of 20` and so on.

#### Number Page

Number page, or sometimes called only number, represents a specific type of pagination item, which is identified by a certain page number. For example Number Page `20` will be the item that will lead to the `20`th page. Number pages can be limited by the *"number limit"*, which specifies how many items will be displayed on each side of the current number page (`-1` for all, `0` for none, and a positive integer (for example `5`) for a specific number of items).

#### Large Number Page / Large Page Number

A specific type of Number Page, representing a large page number item. Large number pages are displayed in a certain interval (`10` by default), so an example set of large number pages will be: `10`, `20`, `30`, and so on. Large number pages can be limited by the *"large number page limit"*, which specifies how many large page number items will be displayed - for example `4` will display: `10`, `20`, `30`, `40`. You can also alter the interval that the large page numbers grow by - it is `10` by default, but if you change it to `5`, the large number pages would be: `5`, `10`, `15`, `20`.

#### Limiter

A specific type of pagination item, usually represented by an ellipsis *("...")*, a limiter is displayed when there are pages that will not be displayed for some reason. For example, `2`, `3`, `4`, `...`, `10`, `20`, `30` - notice the `...` limiter between the number pages and the large number pages.

#### Numbers wrapper

Represents a *"before"* or *"after"* wrapper, but when wrapping the number page items. The number page items include: the *number pages*, the *large numbers* and the corresponding *limiters*.

#### Current Page HTML

A specific type of pagination item, representing a text that indicates the *current page* among the *total number of pages*. It is usually displayed the following way: `Page 1 of 20`.

#### Collection

Class that represents a set of pagination items that will be rendered. You can completely manipulate the collection just like you can manipulate an array.

#### Renderer

Class that will render a certain collection of pagination items.

- - -

Configuration Options
---------------------

You can specify these configuration options by passing them as an associative array to the `$args` argument when calling `carbon_pagination()`, `Carbon_Pagination::display()`, or when creating a new instance of any pagination class (for a full list, please refer to `Carbon_Pagination::__construct()`).

Within some of the configurations options (the ones that are HTML) you can use tokens. These tokens will be automatically replaced with dynamic content that comes from the pagination (for example page number, page link URL, total number of pages, etc). 

For examples on how to pass these configuration options, please refer to either the **Usage & Examples** section.

The available configuration options are:

#### wrapper_before

_(string). Default: **'&lt;div class="paging"&gt;'**_.

The HTML, displayed before the entire pagination.

#### wrapper_after

_(string). Default: **'&lt;/div&gt;'**_.

The HTML, displayed after the entire pagination.

#### pages

_(array). Optional. Default: **array()**_.

Can be used to contain IDs if you want to loop through particular IDs instead of consecutive page numbers. If not defined, falls back to an array of all pages from `1` to `$total_pages`.

#### current_page

_(int). Default: **1**_.

The current page number.

#### total_pages

_(int). Default: **1**_.

The total number of available pages. Not necessary if you have specified `pages`.

#### enable_prev

_(bool). Default: **true**_.

Whether the previous page link should be displayed.

#### enable_next

_(bool). Default: **true**_.

Whether the next page link should be displayed.

#### enable_first

_(bool). Default: **false**_.

Whether the first page link should be displayed.

#### enable_last

_(bool). Default: **false**_.

Whether the last page link should be displayed.

#### enable_numbers

_(bool). Default: **false**_.

Whether the page number links should be displayed.

#### enable\_current\_page\_text

_(bool). Default: **false**_.

Whether the current page text `Page X of Y` should be displayed.

#### number_limit

_(int). Default: **-1**_.

The number of page number links that should be displayed. Using `0` means only the current page item will be displayed. Using `-1` means no limit (all page number links will be displayed).

#### large\_page\_number\_limit

_(int). Default: **0**_.

The number of larger page number links that should be displayed. Larger page numbers can be: `10`, `20`, `30`, etc. Using `0` means none (no larger page number links will be displayed).

#### large\_page\_number\_interval

_(int). Default: **10**_.

The interval between larger page number links. If set to `5`, larger page numbers will be `5`, `10`, `15`, `20`, etc.

#### numbers\_wrapper\_before

_(string). Default: **'&lt;ul&gt;'**_.

The wrapper before the page number links.

#### numbers\_wrapper\_after

_(string). Default: **'&lt;/ul&gt;'**_.

The wrapper after the page number links.

#### prev_html

_(string). Default: **'&lt;a href="{URL}" class="paging-prev"&gt;&lt;/a&gt;'**_.

The HTML of the previous page link. You can use the following tokens:

- **{URL}** - the link URL

#### next_html

_(string). Default: **'&lt;a href="{URL}" class="paging-next"&gt;&lt;/a&gt;'**_.

The HTML of the next page link. You can use the following tokens:

- **{URL}** - the link URL

#### first_html

_(string). Default: **'&lt;a href="{URL}" class="paging-first"&gt;&lt;/a&gt;'**_.

The HTML of the first page link. You can use the following tokens:

- **{URL}** - the link URL

#### last_html

_(string). Default: **'&lt;a href="{URL}" class="paging-last"&gt;&lt;/a&gt;'**_.

The HTML of the last page link. You can use the following tokens:

- **{URL}** - the link URL

#### number_html

_(string). Default: **'&lt;li&gt;&lt;a href="{URL}"&gt;{PAGE_NUMBER}&lt;/a&gt;&lt;/li&gt;'**_.

The HTML of the page number link. You can use the following tokens:

- **{URL}** - the link URL
- **{PAGE_NUMBER}** - the particular page number

#### current\_number\_html

_(string). Default: **'&lt;li class="current"&gt;&lt;a href="{URL}"&gt;{PAGE_NUMBER}&lt;/a&gt;&lt;/li&gt;'**_.

The HTML of the current page number link. You can use the following tokens:

- **{URL}** - the link URL
- **{PAGE_NUMBER}** - the particular page number

#### limiter_html

_(string). Default: **'&lt;li class="paging-spacer"&gt;...&lt;/li&gt;'**_.

The HTML of limiter between page number links.

#### current\_page\_html

_(string). Default: **'&lt;span class="paging-label"&gt;Page {CURRENT_PAGE} of {TOTAL_PAGES}&lt;/span&gt;'**_.

The current page text HTML. You can use the following tokens:

- **{CURRENT_PAGE}** - the current page number
- **{TOTAL_PAGES}** - the total number of pages

#### renderer

_(string). Default: **'Carbon\_Pagination\_Renderer'**_.

The class name of the pagination renderer object.

#### collection

_(string). Default: **'Carbon\_Pagination\_Collection'**_.

The class name of the pagination item collection object.

- - -

Extending Guidelines & Examples
-------------------------------

**TBD**
