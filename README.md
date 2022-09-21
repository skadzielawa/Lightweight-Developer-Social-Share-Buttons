# Lightweight Developer Social Share Buttons
Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. 

Use it to share current post/page on:
* Twitter
* Facebook
* LinkedIn

## Usage
The plugin adds a shortcode:
```
[ldssb facebook="true" twitter="true" linkedin="true"]
```

To use the shortcode within the template, i.e. in the `sidebar.php` or `single.php`, you can use the following code:
```
<?php echo do_shortcode( '[ldssb facebook="true" twitter="true" linkedin="true"]' ); ?>
```

### Custom buttons order
You can configure the order of the buttons by changing the shortcode parameters order.

### Disable plugin CSS
You can upload the custom icons in the plugin settings.

### Can I use SVG icons?
Yes, you can! By default WordPress has SVG support blocked for security reasons. You can install a plugin to enable it (i.e. Safe SVG by 10up).

#### How to change the icon size, or layout of the icons to vertical?
Use CSS ;)
