=== Lightweight Developer Social Share Buttons ===
Contributors: szymonkadzielawa
Tags: social, share, facebook, twitter, linkedin, sharing, developer, buttons, lightweight, light, privacy
Requires at least: 4.7
Tested up to: 6.0.2
Stable tag: 1.1.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Social sharing buttons plugin built with performance, accessibility & privacy in mind. Use it to share current post/page on Twitter, Facebook & LinkedIn.

== Description ==

=== Lightweight Developer Social Share Buttons ===
Contributors: szymonkadzielawa
Tags: social, share, facebook, twitter, linkedin, sharing, developer, buttons, lightweight, light, privacy
Requires at least: 4.7
Tested up to: 6.0.1
Stable tag: trunk
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Social sharing buttons plugin built with performance, accessibility & privacy in mind. Use it to share current post/page on Twitter, Facebook & LinkedIn.

== Description ==

# Lightweight Developer Social Share Buttons
Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. 

Use it to share current post/page on:
* Twitter
* Facebook
* LinkedIn

## Usage
The plugin adds a shortcode:
```
[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false" icons-style=""]
```

To use the shortcode within the template, i.e. in the `sidebar.php` or `single.php`, you can use the following code:
```
<?php echo do_shortcode( '[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false"]' ); ?>
```

### Custom buttons order
You can configure the order of the buttons by changing the shortcode parameters order.

### Disable plugin CSS
You can write your styling for the social icons. To disable plugin's CSS use `disable-css="true"` as the shortcode parameter.

#### How to change the icon size, or layout of the icons to vertical?
Use CSS ;)

== Changelog ==

= 1.0.0 =
* The first version released

= 1.1.0
* Sticking to the Plugin Review 