=== Pullout Widgets ===
Contributors: Max Chirkov
Donate link: http://www.ibsteam.net/donate
Tags: pull out, pull-out, pullout, widget, widgets
Requires at least: 3.0
Tested up to: 4.1.1
Stable tag: 2.9.2

Turn regular sidebar widgets into a slick pull out widget: from left, right, top or bottom of the screen.

== Description ==

Slick and subtle way to hide widgets behind the screen that can be opened by a mouse click or hover.

[Demo Video](http://screenr.com/ii78 "Demo Video")

**Features include:**

1. Turn regular sidebar widgets into a slick PullOut.
2. Unlimited pullout widget positioning on top, right, bottom or left side.
3. Unlimited widget colors.
4. 289 slick icons for pullout tabs.
5. Multiple styles for pullout tabs: square, rounded corners, borders, combination of the above.
6. Vertical or horizontal tabs.
7. Pullout speed control.

* Author: Max Chirkov
* Author URI: [http://simplerealtytheme.com/](http://simplerealtytheme.com/ "Real Estate Themes & Plugins for WordPress")
* Copyright: Released under GNU GENERAL PUBLIC LICENSE

== Installation ==

1. Install and activate this plugin like any other plugin.
2. In the Widgets dashboard drag desired widget into the PullOut Widgets Container sidebar.
3. Expand your widget and check "Turn Pullout On" box at the bottom. Click Pullout Options button on the left and adjust the settings to your needs. Save the settings when you're done.

== Known Issues ==

1. In some themes the plugin will cause a horizontal scroll bar. To fix it, open /css/pullouts.css and comment out the first "body" rule.

== Changelog ==

**Version 2.9.2**
- Fixed: plugin stopped working due to wrongful mobile detection (apparently due to browser update). Fixed by updating MobileDetect library.

**Version 2.9.1**
- Improvement: NextGen Gallery conflicts with POW, which causing PullOut Widget appear at the bottom of the page. Adding negative priority to wp_footer hook seem to fix the problem.

**Version 2.9**
- WP 3.9 Compatibility update.

**Version 2.9**
- Re-adjusted calculations of tabs positioning to make them pixel-perfect in different browsers.
- Updated js code for compatibility with latest jQuery 2.0.3 and jQuery UI 1.10.3.

**Version 2.8**
- Improved detection if widgets have IDs, which supposed to be created via register_sidebar() function. If ID doesn't exist, PullOut Widgets adds an inner DIV wrapper for widgets with correct IDs.
- Fixed: phone detection wasn't working correctly for deactivating the plugin on phones.
- Improved: On/Off switch for mobile devices is now can be set in wp-config.php file by adding define('POW_OFF', false); or other preferred value (phone/tablet).

**Version 2.7**
- Removed console.log() form the JS code, which is not supported by IE7.
- Improved: page loading speed of the administrative Widgets dashboard.
- Improved: removed dependency on jQuery.browser since it's no longer exist in jQuery 1.9+. Thanks Michele Beltrame for the heads up.
- Improved: CSS for IE7 has its own hack without affecting other browsers.

**Version 2.6**
- Fixed: compatibility issue with WP3.5.
- Fixed: cookie wasn't read correctly.
- New: POW_OFF setting in pullouts.php - allows to turn off the plugin for mobile devices (phones, tablets or all mobile devices). By default turns off plugin for phones only.

**Version 2.5**
- Fixed: tab icons didn't display in IE and Opera.
- Fixed: widgets stopped working in IE7/8. Some dimension getters were returning NuN, which weren't correctly validated.

**Version 2.4**

- Fixed: pullout widget wouldn't open second time when triggered in IE8/7 due to an older version of JS interpreter, which doesn't support indexOf() function.

**Version 2.3**

- Fixed: prevented animation queue build-up when triggering tabs during closing of the widgets.

**Version 2.2**

- Fixed: pullout ID wasn't saved in pullout JS vars when used with ATW plugin.
- Fixed: pullout JS vars were output multiple times on the page.

**Version 2.1**

- Improvement: in some themes JS parameters of pullouts were not included into the footer. Moving wp_localize_script() function form footer solves this issue. This also eliminates dependency on wp_footer() completely.
- Improvement: IE9 support for vertical tabs.
- Fixed: Widgets with vertical tabs were invisible in Opera browsers.
- Fixed: Minor PHP notices.

**Version 2.0**

- New: Auto-pullout timer.
- New: Auto-pullout after visiting number of pages.
- New: Auto-pullout triggered by appearance of specified element on the page.
- New: 32 sliding/easing effects.
- New: Custom styles:
-- background color;
-- border color;
-- text color;
-- link color;
-- tab offset along the side of the widget;
- New: Customizable sliding/pullout speed.
- New: Customizable open/close tab labels.
- Updated widget settings dialog with all options organized into an accordion.

**Version 1.3**

- Fixed: color picker wasn't initiating when clicking on the color field on newly dragged into the sidebar widgets. This wasn't happening with the widgets which settings were saved at least once.

**Version 1.2**

- Added on-the-fly wrapper for widgets if their original IDs are not in the theme's markup.
- Eliminated the wp_footer() dependency.
- Added default positioning of the widget in case it's not specified.

**Version 1.1**

- BugFix: Icons weren't displaying in the pullout widgets options dialog.

**Version 1.0**

- Initial release.