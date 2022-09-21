=== Dev Share Buttons ===
Contributors: szymonkadzielawa
Tags: social, share, facebook, twitter, linkedin, sharing, developer, buttons, lightweight, light, privacy, dsb, dev
Requires at least: 4.7
Tested up to: 6.0.2
Stable tag: 1.1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Social sharing buttons plugin built with performance, accessibility & privacy in mind. Use it to share current post/page on Twitter, Facebook & LinkedIn.

== Description ==

# Dev Share Buttons
Lightweight Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. 

Use it to share current post/page on:
* Twitter
* Facebook
* LinkedIn

## Usage
The plugin adds a shortcode:
```
[dsb facebook="true" twitter="true" linkedin="true"]
```

To use the shortcode within the template, i.e. in the `sidebar.php` or `single.php`, you can use the following code:
```
<?php echo do_shortcode( '[dsb facebook="true" twitter="true" linkedin="true"]' ); ?>
```

### Custom buttons order
You can configure the order of the buttons by changing the shortcode parameters order.

### Disable plugin CSS
There is a checkbox in the plugin settings.

### Upload custom icons
You can upload the custom icons in the plugin settings.

### Can I use SVG icons?
Yes, you can! By default WordPress has SVG support blocked for security reasons. You can install a plugin to enable it (i.e. Safe SVG by 10up).

#### How to change the icon size, or layout of the icons to vertical?
Use CSS ;)

== Changelog ==

= 1.1.0
* Added settings page, default icons removed from the plugin 

= 1.0.0 =
* The first version released