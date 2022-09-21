# Lightweight Developer Social Share Buttons
Social sharing buttons WordPress plugin built with performance, accessibility & privacy in mind. 

Use it to share current post/page on:
* Twitter
* Facebook
* LinkedIn

## Usage
The plugin adds a shortcode:
```
[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false"]
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
