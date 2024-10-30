=== CSS Selectors ===
Contributors: giuse
Stable tag: 0.0.3
Tested up to: 6.4
Requires at least: 4.6
Tags: CSS selectors, CSS, style
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

It adds CSS selectors in the HTML where there are not.


== Description ==

It adds CSS selectors in the HTML where there are not.

Sometimes you need some custom CSS and you realise a specific element of the DOM is without any selector.
After activating this plugin you will not have anymore this problem. Every element of the DOM will have a class name that begins with css-sel-.
There are no options, just activate the plugin.

To see if it works, in the frontend right-click with your mouse and click on "Inspect" (usually F12). Then you should not see any more DOM elements without any class.

The only elements that may still miss a CSS class are those ones that are added dynamically through JavaScript. In this last case the plugin can't do anything, because it works only on the server before sending the page to the browser.

It adds no HTTP requests, and no queries to the database.


== Changelog ==

= 0.0.3 =
* Checked: WordPress 6.4

= 0.0.2 =
* Changed: class name assigned to empty elements
