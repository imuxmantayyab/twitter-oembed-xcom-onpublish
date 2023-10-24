<?php
/**
 * Plugin Name: Twitter oEmbed-xcom On Publish
 * Plugin URI: https://example.com/plugins/the-basics/
 * Description: Handle the Twitter card using X.com with this plugin.
 * Version: 1.10.3
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: Muhammad Usman Tayyab
 * Author URI: https://author.example.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://example.com/my-plugin/
 * Text Domain: my-basics-plugin
 * Domain Path: /tocom
 */
// Add a filter to modify the content before rendering in the editor
function custom_xcom_editor_content($content) {
    // Check if the content contains the custom oEmbed placeholder
    if (strpos($content, 'https://x.com/') !== false) {
        // Replace 'https://x.com' with 'https://twitter.com' and use the Twitter oEmbed
        $content = preg_replace('#https?://x\.com/#i', 'https://twitter.com/', $content);
    }

    return $content;
}
add_filter('the_editor_content', 'custom_xcom_editor_content');

// Callback function to replace "x.com" with "twitter.com" in post content
function replaceXcomWithTwittercom($content) {
    $content = str_replace('x.com', 'twitter.com', $content);

    $urls = wp_extract_urls($content);

    foreach ($urls as $url) {

        $embed = wp_oembed_get($url);
        if ($embed) {
            $content = str_replace($url, $embed, $content);
        }
    }
    return $content;
}

// Hook to replace x.com with twitter.com in the post content
add_filter('the_content', 'replaceXcomWithTwittercom');