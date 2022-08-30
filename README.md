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
<?php echo do_shortcode( '[ldssb facebook="true" twitter="true" linkedin="true" disable-css="false" icons-style=""]' ); ?>
```

### Custom buttons order
You can configure the order of the buttons by changing the shortcode parameters order.

You can change the default icons set to other using `icons-style="square"` or `icons-style="rouded"` attribute.

### Disable plugin CSS
You can write your styling for the social icons. To disable plugin's CSS use `disable-css="true"` as the shortcode parameter.

### Icons
The plugin uses the free SVG social icons from [Nucleo Icons](https://nucleoapp.com/). They are royalty free for use in both personal and commercial projects.

### Icons style
There are three included icons style added to the plugin:
* default
* square
* rounded

#### How to change icons completely:
There are filters added for the icons. You can grab any SVG icon code and optimize it, i.e. using [SVGOMG](https://jakearchibald.github.io/svgomg/), then in the functions.php of your theme, you can add:


##### Facebook
```
function ldssb_custom_icon_facebook() {
    return '<svg class="ldssb__icon" (...) /></svg>'; // Place your SVG code here
}
add_filter( 'ldssb_icon_facebook', 'ldssb_custom_icon_facebook' );
```


##### Twitter
```
function ldssb_custom_icon_twitter() {
    return '<svg class="ldssb__icon" (...) /></svg>'; // Place your SVG code here
}
add_filter( 'ldssb_icon_twitter', 'ldssb_custom_icon_twitter' );
```

##### Linkedin
```
function ldssb_custom_icon_linkedin() {
    return '<svg class="ldssb__icon" (...) /></svg>'; // Place your SVG code here
}
add_filter( 'ldssb_icon_linkedin', 'ldssb_custom_icon_linkedin' );
```

#### Can I use other image types as icons (like png)?
You, you can. Then instead of the <svg> code you need to return full <img> tag i.e.
```
function ldssb_custom_icon_facebook() {
    return '<img src="' . esc_url( get_stylesheet_directory_uri() ) . '/images/facebook.png" alt="">'; // Update the icon path based on your current theme
}
add_filter( 'ldssb_icon_facebook', 'ldssb_custom_icon_facebook' );
```


