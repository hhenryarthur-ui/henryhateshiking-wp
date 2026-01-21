<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * RTL support (kept)
 */
add_filter( 'locale_stylesheet_uri', function( $uri ) {
    if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
        return get_template_directory_uri() . '/rtl.css';
    }
    return $uri;
});

/**
 * Load custom overrides LAST (Customizer-style).
 * This prints a <style> tag at the very end so Elementor/Astra dynamic CSS can't override it.
 */
function hhh_print_custom_css_overrides() {
    $path = get_stylesheet_directory() . '/custom.css';

    if ( ! file_exists( $path ) ) return;

    $css = file_get_contents( $path );
    if ( ! $css ) return;

    // Basic cleanup
    $css = trim( $css );
    if ( $css === '' ) return;

    echo "\n<style id=\"hhh-custom-css-overrides\">\n" . $css . "\n</style>\n";
}

// Print late in <head>
add_action( 'wp_head', 'hhh_print_custom_css_overrides', 9999 );

// AND late in footer (in case something prints styles after wp_head)
add_action( 'wp_footer', 'hhh_print_custom_css_overrides', 9999 );
