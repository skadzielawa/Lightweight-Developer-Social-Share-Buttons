# Lightweight Developer Social Share Buttons
Social sharing buttons WordPress plugin built with performance and privacy in mind.

## Usage
The plugin adds a shortcode:
```
[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false"]
```

### Custom buttons order
You can configure the buttons order by changing the shortcode parameters order.

### Disable plugin CSS
You can write your own styling for the social icons. To disable plugin's CSS use `disable-css="true"` as the shortcode parameter.

### Template usage
To use the shortcode within the template i.e. in the `sidebar.php` you can use following code:
```
<?php echo do_shortcode( '[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false"]' ); ?>
```

## Icons
The plugin by default uses the SVG social icons from [Nucleo Icons](https://nucleoapp.com/). They are royalty free for use in both personal and commercial projects.

### How to change Icons:
There are filters added for the icons. you can grab any SVG icon code and optimize it i.e. using [SVGOMG](https://jakearchibald.github.io/svgomg/), then in the functions.php of your theme you can add:


#### Facebook
```
function ldssb_custom_icon_facebook() {
    return '<svg class="ldssb__icon" (...) /></svg>'; // Place your SVG code here
}
add_filter( 'ldssb_icon_facebook', 'ldssb_custom_icon_facebook' );
```


#### Twitter
```
function ldssb_custom_icon_twitter() {
    return '<svg class="ldssb__icon" (...) /></svg>'; // Place your SVG code here
}
add_filter( 'ldssb_icon_twitter', 'ldssb_custom_icon_twitter' );
```

#### Linkedin
```
function ldssb_custom_icon_linkedin() {
    return '<svg class="ldssb__icon" (...) /></svg>'; // Place your SVG code here
}
add_filter( 'ldssb_icon_linkedin', 'ldssb_custom_icon_linkedin' );
```

#### Can I use another image types as icons (like png)?
You, you can. Then instead of the <svg> code you need to return full <img> tag i.e.
```
function ldssb_custom_icon_facebook() {
    return '<img src="' . esc_url( get_stylesheet_directory_uri() ) . '/images/facebook.png" alt="">'; // Update the icon path based on your current theme
}
add_filter( 'ldssb_icon_facebook', 'ldssb_custom_icon_facebook' );
```


