<?php
/**
 * Plugin Name: Bomflor SEO
 * Plugin URI:  https://www.bomflor.com
 * Description: Injects LocalBusiness JSON-LD schema and BreadcrumbList structured data for Bomflor Floristería Quito.
 * Version:     1.0.0
 * Author:      Bomflor
 */

defined('ABSPATH') || exit;

/**
 * Inject LocalBusiness + BreadcrumbList JSON-LD into <head>
 */
add_action('wp_head', 'bomflor_inject_schema', 5);

function bomflor_inject_schema() {
    // LocalBusiness schema
    $local_schema = get_option('bomflor_local_schema', '');
    if ($local_schema) {
        $schema_data = json_decode($local_schema, true);
        if ($schema_data) {
            echo '<script type="application/ld+json">' . "\n";
            echo wp_json_encode($schema_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
            echo '</script>' . "\n";
        }
    }

    // BreadcrumbList schema (only if Yoast breadcrumbs not already outputting it)
    if (function_exists('yoast_breadcrumb')) {
        // Yoast handles breadcrumb schema natively when breadcrumbs-enable = true
        return;
    }

    // Fallback BreadcrumbList for non-Yoast contexts
    $items = [];
    $items[] = [
        '@type'    => 'ListItem',
        'position' => 1,
        'name'     => 'Inicio',
        'item'     => home_url('/'),
    ];

    if (is_product()) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => 'Arreglos Florales',
            'item'     => home_url('/arreglos-florales/'),
        ];
        $terms = get_the_terms(get_the_ID(), 'product_cat');
        if ($terms && !is_wp_error($terms)) {
            $cat = array_shift($terms);
            $items[] = [
                '@type'    => 'ListItem',
                'position' => 3,
                'name'     => $cat->name,
                'item'     => get_term_link($cat),
            ];
            $items[] = [
                '@type'    => 'ListItem',
                'position' => 4,
                'name'     => get_the_title(),
                'item'     => get_permalink(),
            ];
        } else {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => 3,
                'name'     => get_the_title(),
                'item'     => get_permalink(),
            ];
        }
    } elseif (is_page()) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => 2,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        ];
    }

    if (count($items) > 1) {
        $breadcrumb_schema = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($breadcrumb_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n";
        echo '</script>' . "\n";
    }
}
