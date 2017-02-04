=== Mobile Featured Image ===
Contributors: ryanshoover
Tags: featured image, thumbnail, mobile, srcset
Requires at least: 4.4
Tested up to: 4.7.2
Stable tag: 1.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Display a mobile featured image


== Description ==

Easily display a mobile featured image on your posts and page!

Up to 70% of website traffic today is on mobile devices. Sometimes WordPress does not quite resize the featured image in the best way. Avoid this and have full control over your featured images on any device with this plugin.

To add a mobile featured image, simply upload a new image in the meta box right below the WordPress Featured Image called *Mobile Featured Image*. The new image can be a specifically resized version of your featured image or an entirely new image targeted especially for mobile viewers.

You can add your mobile featured image without worrying about slowing down your site. The mobile image is added to the `srcset` attribute of your featured image. Vistors' browsers will automatically download the best image for the size of their screen.

This plugin works by filtering the `wp_calculate_image_srcset` function and changing the url for all screens under 980w to the mobile featured image. 980w is a reliable breakpoint between the iPhone 6+ and the iPad, two common measures for when a mobile image would be needed.

== Installation ==

1. Upload the `mobile-featured-image` folder to your /wp-content/plugins/ directory
2. Activate the plugin through the Plugins menu

== Changelog ==

= 1.0 =
Initial release