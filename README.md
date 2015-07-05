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
		'number_limit' => 0,
		'large_page_number_limit' => 0,
		'large_page_number_interval' => 10,
		'numbers_wrapper_before' => '<ul>',
		'numbers_wrapper_after' => '</ul>',
		'prev_html' => '<a href="{URL}" class="paging-prev"></a>',
		'next_html' => '<a href="{URL}" class="paging-next"></a>',
		'first_html' => '<a href="{URL}" class="paging-first"></a>',
		'last_html' => '<a href="{URL}" class="paging-last"></a>',
		'number_html' => '<li><a href="{URL}">{PAGE_NUMBER}</a></li>',
		'limiter_html' => '<li class="paging-spacer">...</li>',
		'current_page_html' => '<span class="paging-label">Page {CURRENT_PAGE} of {TOTAL_PAGES}</span>',
	)); 
	?>

You can read more about each setting in the **Configuration Options** section.

#### Using and manipulating pagination as an object

In case you need to manipulate the pagination you can define the pagination as an object:

	$pagination = new Carbon_Pagination_Posts(array(
		'wrapper_before' => '<div class="paging">',
		'wrapper_after' => '</div>',
	));

Then you can use any of the methods, as documented in the **Class Reference**. Example:
	
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

Configuration Options
---------------------

You can specify these configuration options by passing them as an associative array to the `$args` argument when calling `carbon_pagination()`, `Carbon_Pagination::display()`, or when creating a new instance of any pagination class (for a full list, please refer to the **Class Reference** section).

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

_(int). Default: **0**_.

The number of page number links that should be displayed. Using `0` means no limit (all page number links will be displayed).

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

#### limiter_html

_(string). Default: **'&lt;li class="paging-spacer"&gt;...&lt;/li&gt;'**_.

The HTML of limiter between page number links.

#### current\_page\_html

_(string). Default: **'&lt;span class="paging-label"&gt;Page {CURRENT_PAGE} of {TOTAL_PAGES}&lt;/span&gt;'**_.

The current page text HTML. You can use the following tokens:

- **{CURRENT_PAGE}** - the current page number
- **{TOTAL_PAGES}** - the total number of pages

- - -

Class Reference
---------------

### Carbon_Pagination

**@abstract**

The Carbon Pagination base class. Contains and manages all of the pagination settings. Abstract, can be extended by all specific pagination types.

#### $wrapper_before

**@access** _protected_

**@var** _(string). Default: **'&lt;div class="paging"&gt;'**_.

The HTML, displayed before the entire pagination.

#### $wrapper_after

**@access** _protected_

**@var** _(string). Default: **'&lt;/div&gt;'**_.

The HTML, displayed after the entire pagination.

#### $pages

**@access** _protected_

**@var** _(array). Optional. Default: **array()**_.

Can be used to contain IDs if you want to loop through particular IDs instead of consecutive page numbers. If not defined, falls back to an array of all pages from `1` to `$total_pages`.

#### $current_page

**@access** _protected_

**@var** _(int). Default: **1**_.

The current page number.

#### $total_pages

**@access** _protected_

**@var** _(int). Default: **1**_.

The total number of available pages. Not necessary if you have specified `pages`.

#### $enable_prev

**@access** _protected_

**@var** _(bool). Default: **true**_.

Whether the previous page link should be displayed.

#### $enable_next

**@access** _protected_

**@var** _(bool). Default: **true**_.

Whether the next page link should be displayed.

#### $enable_first

**@access** _protected_

**@var** _(bool). Default: **false**_.

Whether the first page link should be displayed.

#### $enable_last

**@access** _protected_

**@var** _(bool). Default: **false**_.

Whether the last page link should be displayed.

#### $enable_numbers

**@access** _protected_

**@var** _(bool). Default: **false**_.

Whether the page number links should be displayed.

#### $enable\_current\_page\_text

**@access** _protected_

**@var** _(bool). Default: **false**_.

Whether the current page text `Page X of Y` should be displayed.

#### $number_limit

**@access** _protected_

**@var** _(int). Default: **0**_.

The number of page number links that should be displayed. Using `0` means no limit (all page number links will be displayed).

#### $large\_page\_number\_limit

**@access** _protected_

**@var** _(int). Default: **0**_.

The number of larger page number links that should be displayed. Larger page numbers can be: `10`, `20`, `30`, etc. Using `0` means none (no larger page number links will be displayed).

#### $large\_page\_number\_interval

**@access** _protected_

**@var** _(int). Default: **10**_.

The interval between larger page number links. If set to `5`, larger page numbers will be `5`, `10`, `15`, `20`, etc.

#### $numbers\_wrapper\_before

**@access** _protected_

**@var** _(string). Default: **'&lt;ul&gt;'**_.

The wrapper before the page number links.

#### $numbers\_wrapper\_after

**@access** _protected_

**@var** _(string). Default: **'&lt;/ul&gt;'**_.

The wrapper after the page number links.

#### $prev_html

**@access** _protected_

**@var** _(string). Default: **'&lt;a href="{URL}" class="paging-prev"&gt;&lt;/a&gt;'**_.

The HTML of the previous page link. You can use the following tokens:

- **{URL}** - the link URL

#### $next_html

**@access** _protected_

**@var** _(string). Default: **'&lt;a href="{URL}" class="paging-next"&gt;&lt;/a&gt;'**_.

The HTML of the next page link. You can use the following tokens:

- **{URL}** - the link URL

#### $first_html

**@access** _protected_

**@var** _(string). Default: **'&lt;a href="{URL}" class="paging-first"&gt;&lt;/a&gt;'**_.

The HTML of the first page link. You can use the following tokens:

- **{URL}** - the link URL

#### $last_html

**@access** _protected_

**@var** _(string). Default: **'&lt;a href="{URL}" class="paging-last"&gt;&lt;/a&gt;'**_.

The HTML of the last page link. You can use the following tokens:

- **{URL}** - the link URL

#### $number_html

**@access** _protected_

**@var** _(string). Default: **'&lt;li&gt;&lt;a href="{URL}"&gt;{PAGE_NUMBER}&lt;/a&gt;&lt;/li&gt;'**_.

The HTML of the page number link. You can use the following tokens:

- **{URL}** - the link URL
- **{PAGE_NUMBER}** - the particular page number

#### $limiter_html

**@access** _protected_

**@var** _(string). Default: **'&lt;li class="paging-spacer"&gt;...&lt;/li&gt;'**_.

The HTML of limiter between page number links.

#### $current\_page\_html

**@access** _protected_

**@var** _(string). Default: **'&lt;span class="paging-label"&gt;Page {CURRENT_PAGE} of {TOTAL_PAGES}&lt;/span&gt;'**_.

The current page text HTML. You can use the following tokens:

- **{CURRENT_PAGE}** - the current page number
- **{TOTAL_PAGES}** - the total number of pages

#### $default_args

**@access** _public_

**@var** _(array). Default: **array()**_.

The default argument values. Can be declared in the inheriting classes. Will override the default configuration options in `Carbon_Pagination::__construct` but can be overriden by the `$args` parameter specifically.

#### __construct()

**@access** _public_

**@param** *(array) $args. Configuration options to modify the pagination settings.*

**@return** _Carbon_Pagination_

Constructor. Creates and configures a new pagination with the provided settings.

#### get\_wrapper\_before()

**@access** _public_

**@return** *(string) $wrapper_before. The pagination wrapper - before.*

Retrieve the pagination wrapper - before.

#### set\_wrapper\_before()

**@access** _public_

**@param** *(string) $wrapper_before. The new pagination wrapper - before.*

Modify the pagination wrapper - before.

#### get\_wrapper\_after()

**@access** _public_

**@return** *(string) $wrapper_after. The pagination wrapper - after.*

Retrieve the pagination wrapper - after.

#### set\_wrapper\_after()

**@access** _public_

**@param** *(string) $wrapper_after. The new pagination wrapper - after.*

Modify the pagination wrapper - after.

#### get_pages()

**@access** _public_

**@return** *(array) $pages. The pages array.*

Retrieve the pages array.

#### set_pages()

**@access** _public_

**@param** *(array) $pages. The new pages array.*

Modify the pages array.

#### get\_current\_page()

**@access** _public_

**@return** *(int) $current_page. The current page number.*

Retrieve the current page number.

#### set\_current\_page()

**@access** _public_

**@param** *(int) $current_page. The new current page number.*

Modify the current page number.

#### get\_total\_pages()

**@access** _public_

**@return** *(int) $total_pages. The total number of pages.*

Retrieve the total number of pages.

#### set\_total\_pages()

**@access** _public_

**@param** *(int) $total_pages. The new total number of pages.*

Modify the total number of pages.

#### get\_enable\_prev()

**@access** _public_

**@return** *(bool) $enable_prev. True if the previous page link should be displayed, false otherwise.*

Whether the previous page link should be displayed.

#### set\_enable\_prev()

**@access** _public_

**@param** *(bool) $enable_prev. True if the previous page link should be displayed, false otherwise.*

Specify whether the previous page link should be displayed.

#### get\_enable\_next()

**@access** _public_

**@return** *(bool) $enable_next. True if the next page link should be displayed, false otherwise.*

Whether the next page link should be displayed.

#### set\_enable\_next()

**@access** _public_

**@param** *(bool) $enable_next. True if the next page link should be displayed, false otherwise.*

Specify whether the next page link should be displayed.

#### get\_enable\_first()

**@access** _public_

**@return** *(bool) $enable_first. True if the first page link should be displayed, false otherwise.*

Whether the first page link should be displayed.

#### set\_enable\_first()

**@access** _public_

**@param** *(bool) $enable_first. True if the first page link should be displayed, false otherwise.*

Specify whether the first page link should be displayed.

#### get\_enable\_last()

**@access** _public_

**@return** *(bool) $enable_last. True if the last page link should be displayed, false otherwise.*

Whether the last page link should be displayed.

#### set\_enable\_last()

**@access** _public_

**@param** *(bool) $enable_last. True if the last page link should be displayed, false otherwise.*

Specify whether the last page link should be displayed.

#### get\_enable\_numbers()

**@access** _public_

**@return** *(bool) $enable_numbers. True if the page number links should be displayed, false otherwise.*

Whether the page number links should be displayed.

#### set\_enable\_numbers()

**@access** _public_

**@param** *(bool) $enable_numbers. True if the page number links should be displayed, false otherwise.*

Specify whether the page number links should be displayed.

#### get\_enable\_current\_page\_text()

**@access** _public_

**@return** *(bool) $enable_current_page_text. True if the current page text should be displayed, false otherwise.*

Whether the current page text should be displayed.

#### set\_enable\_current\_page\_text()

**@access** _public_

**@param** *(bool) $enable_current_page_text. True if the current page text should be displayed, false otherwise.*

Specify whether the current page text should be displayed.

#### get\_number\_limit()

**@access** _public_

**@return** *(int) $number_limit. The page number links limit.*

Retrieve the page number links limit.

#### set\_number\_limit()

**@access** _public_

**@param** *(int) $number_limit. The new page number links limit.*

Modify the page number links limit.

#### get\_large\_page\_number\_limit()

**@access** _public_

**@return** *(int) $large_page_number_limit. The large page number links limit.*

Retrieve the large page number links limit.

#### set\_large\_page\_number\_limit()

**@access** _public_

**@param** *(int) $large_page_number_limit. The new large page number links limit.*

Modify the large page number links limit.

#### get\_large\_page\_number\_interval()

**@access** _public_

**@return** *(int) $large_page_number_interval. The large page number links interval.*

Retrieve the large page number links interval.

#### set\_large\_page\_number\_interval()

**@access** _public_

**@param** *(int) $large_page_number_interval. The new large page number links interval.*

Modify the large page number links interval.

#### get\_numbers\_wrapper\_before()

**@access** _public_

**@return** *(string) $numbers_wrapper_before. The pagination numbers wrapper - before.*

Retrieve the pagination numbers wrapper - before.

#### set\_numbers\_wrapper\_before()

**@access** _public_

**@param** *(string) $numbers_wrapper_before. The new pagination numbers wrapper - before.*

Modify the pagination numbers wrapper - before.

#### get\_numbers\_wrapper\_after()

**@access** _public_

**@return** *(string) $numbers_wrapper_after. The pagination numbers wrapper - after.*

Retrieve the pagination numbers wrapper - after.

#### set\_numbers\_wrapper\_after()

**@access** _public_

**@param** *(string) $numbers_wrapper_after. The new pagination numbers wrapper - after.*

Modify the pagination numbers wrapper - after.

#### get\_prev\_html()

**@access** _public_

**@return** *(string) $prev_html. The previous page link HTML.*

Retrieve the previous page link HTML.

#### set\_prev\_html()

**@access** _public_

**@param** *(string) $prev_html. The new previous page link HTML.*

Modify the previous page link HTML.

#### get\_next\_html()

**@access** _public_

**@return** *(string) $next_html. The next page link HTML.*

Retrieve the next page link HTML.

#### set\_next\_html()

**@access** _public_

**@param** *(string) $next_html. The new next page link HTML.*

Modify the next page link HTML.

#### get\_first\_html()

**@access** _public_

**@return** *(string) $first_html. The first page link HTML.*

Retrieve the first page link HTML.

#### set\_first\_html()

**@access** _public_

**@param** *(string) $first_html. The new first page link HTML.*

Modify the first page link HTML.

#### get\_last\_html()

**@access** _public_

**@return** *(string) $last_html. The last page link HTML.*

Retrieve the last page link HTML.

#### set\_last\_html()

**@access** _public_

**@param** *(string) $last_html. The new last page link HTML.*

Modify the last page link HTML.

#### get\_number\_html()

**@access** _public_

**@return** *(string) $number_html. The HTML of a page number link.*

Retrieve the HTML of a page number link.

#### set\_number\_html()

**@access** _public_

**@param** *(string) $number_html. The new HTML of a page number link.*

Modify the HTML of a page number link.

#### get\_limiter\_html()

**@access** _public_

**@return** *(string) $limiter_html. The HTML of a limiter.*

Retrieve the HTML of a limiter.

#### set\_limiter\_html()

**@access** _public_

**@param** *(string) $limiter_html. The new HTML of a limiter.*

Modify the HTML of a limiter.

#### get\_current\_page\_html\_html()

**@access** _public_

**@return** *(string) $current_page_html_html. The HTML of the current page text.*

Retrieve the HTML of the current page text.

#### set\_current\_page\_html\_html()

**@access** _public_

**@param** *(string) $current_page_html_html. The new HTML of the current page text.*

Modify the HTML of the current page text.

#### get\_current\_url()

**@access** _public_

**@return** *(string) $url. The current page URL.*

Get the current URL, in WordPress style.

#### display()

**@static**

**@access** _public_

**@param** *(string) $pagination. The pagination type, can be one of the following:*

* **'Posts'**
* **'Post'**
* **'Comments'**
* **'Custom'**

**@param** *(array) $args. Configuration options to modify the pagination settings.*

#### render()

**@abstract**

**@access** _public_

Render the pagination.

- - - 

### Carbon\_Pagination\_Builder

The Carbon Pagination main class. Contains and manages all of the pagination settings and handles rendering. Abstract, can be extended by all specific pagination types.

**@abstract**

**@uses** *Carbon_Pagination*

#### render()

**@access** _public_

**@param** *(bool) $echo. Whether to display (true) or return (false) the HTML.*

**@return** *(string|NULL). If `$echo` is `false`, the pagination HTML, `NULL` otherwise.*

Build and render the pagination.

#### build\_current\_page\_text()

**@access** _public_

**@return** *(string) $html. The current page text HTML.*

Build the current page text. Applies the `carbon_pagination_current_page_text` filter on the output.

#### build\_prev\_page\_link()

**@access** _public_

**@return** *(string) $link. The previous page link HTML.*

Build the previous page link. Applies the `carbon_pagination_prev_page_link` filter on the output.

#### build\_next\_page\_link()

**@access** _public_

**@return** *(string) $link. The next page link HTML.*

Build the next page link. Applies the `carbon_pagination_next_page_link` filter on the output.

#### build\_first\_page\_link()

**@access** _public_

**@return** *(string) $link. The first page link HTML.*

Build the first page link. Applies the `carbon_pagination_first_page_link` filter on the output.

#### build\_last\_page\_link()

**@access** _public_

**@return** *(string) $link. The last page link HTML.*

Build the last page link. Applies the `carbon_pagination_last_page_link` filter on the output.

#### build\_page\_links()

**@access** _public_

**@return** *(string) $output. The page number links HTML.*

Build the page number links. Loops through the pages themselves, allowing them to be IDs or anything else. Applies the `carbon_pagination_page_number_link` filter on each link.

#### build_limiter()

**@access** _public_

**@return** *(string) $html. The limiter HTML.*

Build the limiter between page links. Applies the `carbon_pagination_limiter` filter on the output.

#### build\_page\_link()

**@access** _public_

**@param** *(int) $page_number. The page number.*

**@param** *(string) $html. Optional. The text of the link.*

**@return** *(string) $link. The link HTML.*

Build the link for a certain page number. Applies the `carbon_pagination_page_link` filter on the output.

#### parse_tokens()

**@access** _protected_

**@param** *(string) $string. The unparsed string.*

**@param** *(array) $tokens. An array of tokens and their values.*

**@return** *(string) $string. The parsed string.*

Parse all tokens within a string.

Tokens should be passed in the array in the following way:
`array( 'TOKENNAME' => 'tokenvalue' )`

Tokens should be used in the string in the following way:
`'lorem {TOKENNAME} ipsum'`

#### get\_page\_url()

**@abstract**

**@access** _public_

**@param** *(int) $page_number. The page number.*

**@param** *(string) $old_url. Optional. The URL to add the page number to.*

**@return** *(string) $url. The URL to the page number.*

Get the URL to a certain page.

- - - 

### Carbon\_Pagination\_Posts

Posts pagination class. Provides the pagination for non-singular post loops (index, search, archives).

#### __construct()

**@see** *Carbon_Pagination::__construct()*

**@access** _public_

**@param** *(array) $args. Configuration options to modify the pagination settings.*

**@return** *Carbon_Pagination_Posts*

Constructor. Creates and configures a new pagination with the provided settings.

In addition to `Carbon_Pagination::__construct()`, this constructor specifies the expected `$default_args`, which are:

* **current_page** - the current page, as specified in the global `$wp_query` object

* **total_pages** - the total number of pages, as specified in the global `$wp_query` object

* **prev_html** - the HTML of the link to the previous page, with `&laquo; Previous Entries` text

* **next_html** - the HTML of the link to the next page, with `Next Entries &raquo;` text

These can be overridden by the `$args` parameter of `__construct()`.

#### get\_page\_url()

**@access** _public_

**@param** *(int) $page_number. The page number.*

**@param** *(string) $old_url. Optional. The URL to add the page number to.*

**@return** *(string) $url. The URL to the page number.*

Get the URL to a certain page, by using `get_pagenum_link()`.

- - - 

### Carbon\_Pagination\_Post

Single post pagination class. Provides the pagination for the singular post.

#### __construct()

**@see** *Carbon_Pagination::__construct()*

**@access** _public_

**@param** *(array) $args. Configuration options to modify the pagination settings.*

**@return** *Carbon_Pagination_Post*

Constructor. Creates and configures a new pagination with the provided settings.

In addition to `Carbon_Pagination::__construct()`, this constructor specifies the expected `$default_args`, which are:

* **current_page** - the index of the current post, relative to the total posts in the post pagination query

* **total_pages** - the total number of post results in the post pagination query

* **prev_html** - the HTML of the link to the previous post, with `&laquo; Previous Entry` text

* **next_html** - the HTML of the link to the next post, with `Next Entry &raquo;` text

These can be overridden by the `$args` parameter of `__construct()`.

#### get\_page\_url()

**@access** _public_

**@param** *(int) $page_number. The post index in the pagination query results.*

**@param** *(string) $old_url. Optional. The URL to add the page number to.*

**@return** *(string) $url. The URL to the post.*

Get the URL to the post, corresponding to a certain index in the post pagination query results. Uses `get_permalink()`.

- - - 

### Carbon\_Pagination\_Comments

Comments pagination class. Provides the pagination for comments within a post/page.

#### __construct()

**@see** *Carbon_Pagination::__construct()*

**@access** _public_

**@param** *(array) $args. Configuration options to modify the pagination settings.*

**@return** *Carbon_Pagination_Comments*

Constructor. Creates and configures a new pagination with the provided settings.

In addition to `Carbon_Pagination::__construct()`, this constructor specifies the expected `$default_args`, which are:

* **current_page** - the current comments page, as specified in the global `$wp_query` object

* **total_pages** - the total number of comment pages, as specified in the global `$wp_query` object

* **prev_html** - the HTML of the link to the previous comments page, with `&laquo; Older Comments` text

* **next_html** - the HTML of the link to the next comments page, with `Newer Comments &raquo;` text

These can be overridden by the `$args` parameter of `__construct()`.

#### get\_page\_url()

**@access** _public_

**@param** *(int) $page_number. The comments page number.*

**@param** *(string) $old_url. Optional. The URL to add the page number to.*

**@return** *(string) $url. The URL to the comments page.*

Get the URL to a certain comments page, by using `get_comments_pagenum_link()`.

- - - 

### Carbon\_Pagination\_Custom

Custom pagination class. Allows to create and maintain a custom pagination.

#### $query_var

**@access** _protected_

**@var** _(string). Default: **'page'**_.

The query var that is used to specify the current page number.

#### __construct()

**@see** *Carbon_Pagination::__construct()*

**@access** _public_

**@param** *(array) $args. Configuration options to modify the pagination settings.*

**@return** *Carbon_Pagination_Custom*

Constructor. Creates and configures a new pagination with the provided settings.

#### get\_page\_url()

**@access** _public_

**@param** *(int) $page_number. The page number.*

**@param** *(string) $old_url. Optional. The URL to add the page number to.*

**@return** *(string) $url. The URL to the page.*

Get the URL to a certain page, by using the specified query var and `add_query_arg()` for building the URL.

#### get\_query\_var()

**@access** _public_

**@return** *(string) $query_var. The query var name.*

Retrieve the query var name.

#### set\_query\_var()

**@access** _public_

**@param** *(string) $query_var. The new query var name.*

Modify the query var name.

- - - 

### Carbon\_Pagination\_Exception

Used for pagination exceptions. Can be used to indicate that the exception comes from within the pagination code. Nothing special here.

- - -

Extending Guidelines & Examples
-------------------------------

**TBD**
