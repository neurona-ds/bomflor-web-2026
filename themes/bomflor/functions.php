<?php
declare(strict_types=1);

// Logo admin page under Appearance
add_action('admin_menu', function (): void {
    add_theme_page('Logo del sitio', 'Logo', 'manage_options', 'bomflor-logo', function (): void {
        if (isset($_POST['bomflor_logo_nonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bomflor_logo_nonce'])), 'bomflor_save_logo')) {
            $attachment_id = isset($_POST['custom_logo']) ? absint($_POST['custom_logo']) : 0;
            if ($attachment_id) {
                set_theme_mod('custom_logo', $attachment_id);
            } else {
                remove_theme_mod('custom_logo');
            }
            echo '<div class="notice notice-success"><p>Logo actualizado.</p></div>';
        }
        $current_logo_id = get_theme_mod('custom_logo', 0);
        $current_logo_url = $current_logo_id ? wp_get_attachment_image_url($current_logo_id, 'full') : '';
        ?>
        <div class="wrap">
            <h1>Logo del sitio</h1>
            <form method="post">
                <?php wp_nonce_field('bomflor_save_logo', 'bomflor_logo_nonce'); ?>
                <input type="hidden" name="custom_logo" id="custom_logo" value="<?php echo esc_attr($current_logo_id); ?>">
                <div style="margin:20px 0">
                    <div id="logo-preview" style="margin-bottom:12px">
                        <?php if ($current_logo_url): ?>
                            <img src="<?php echo esc_url($current_logo_url); ?>" style="max-height:80px;display:block">
                        <?php endif; ?>
                    </div>
                    <button type="button" class="button" id="upload-logo-btn">Seleccionar imagen</button>
                    <?php if ($current_logo_id): ?>
                        <button type="button" class="button" id="remove-logo-btn" style="margin-left:8px">Eliminar logo</button>
                    <?php endif; ?>
                </div>
                <?php submit_button('Guardar logo'); ?>
            </form>
        </div>
        <script>
        jQuery(function($) {
            var frame;
            $('#upload-logo-btn').on('click', function() {
                if (frame) { frame.open(); return; }
                frame = wp.media({ title: 'Seleccionar logo', button: { text: 'Usar este logo' }, multiple: false });
                frame.on('select', function() {
                    var att = frame.state().get('selection').first().toJSON();
                    $('#custom_logo').val(att.id);
                    $('#logo-preview').html('<img src="' + att.url + '" style="max-height:80px;display:block">');
                });
                frame.open();
            });
            $('#remove-logo-btn').on('click', function() {
                $('#custom_logo').val('');
                $('#logo-preview').html('');
            });
        });
        </script>
        <?php
        wp_enqueue_media();
    });
});

// Theme setup
add_action('after_setup_theme', function (): void {
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', [
        'height' => 72,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ]);
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_image_size('bomflor-product', 600, 900, true);
    add_image_size('bomflor-hero', 1440, 900, true);
    add_image_size('bomflor-card', 800, 600, true);
    load_theme_textdomain('bomflor', get_template_directory() . '/languages');
});

// Enqueue assets
add_action('wp_enqueue_scripts', function (): void {
    $v = wp_get_theme()->get('Version');
    $dir = get_template_directory_uri();

    // Google Fonts — preconnect + stylesheet
    wp_enqueue_style(
        'bomflor-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Jost:wght@200;300;400&display=swap',
        [],
        null
    );

    wp_enqueue_style('bomflor-global', "$dir/assets/css/global.css", ['bomflor-google-fonts'], $v);
    wp_enqueue_style('bomflor-components', "$dir/assets/css/components.css", ['bomflor-global'], $v);

    $needs_wc_css = function_exists('is_woocommerce') && (
        is_woocommerce() || is_cart() || is_checkout() || is_account_page() || is_product() || is_search()
        || (is_singular('page') && has_shortcode(get_post_field('post_content', get_the_ID()), 'bf_register_form'))
    );
    if ($needs_wc_css) {
        wp_enqueue_style('bomflor-woocommerce', "$dir/assets/css/woocommerce.css", ['bomflor-components'], $v);
    }
    if (is_checkout()) {
        wp_enqueue_style('bomflor-checkout', "$dir/assets/css/checkout.css", ['bomflor-woocommerce'], $v);
    }

    wp_enqueue_script('bomflor-navigation', "$dir/assets/js/navigation.js", [], $v, ['strategy' => 'defer', 'in_footer' => true]);
    wp_enqueue_script('bomflor-parallax', "$dir/assets/js/parallax.js", [], $v, ['strategy' => 'defer', 'in_footer' => true]);
    wp_enqueue_script('bomflor-carousel', "$dir/assets/js/carousel.js", [], $v, ['strategy' => 'defer', 'in_footer' => true]);

    // Lucide — from unpkg CDN
    wp_enqueue_script('lucide', 'https://unpkg.com/lucide@latest/dist/umd/lucide.js', [], null, ['strategy' => 'defer', 'in_footer' => true]);
    wp_enqueue_script('bomflor-lucide-init', "$dir/assets/js/lucide-init.js", ['lucide'], $v, ['strategy' => 'defer', 'in_footer' => true]);

    if (function_exists('WC')) {
        wp_localize_script('bomflor-navigation', 'bomflorCart', [
            'count' => WC()->cart ? WC()->cart->get_cart_contents_count() : 0,
            'total' => WC()->cart ? WC()->cart->get_cart_total() : '',
            'cartUrl' => wc_get_cart_url(),
        ]);
    }

    wp_localize_script('bomflor-navigation', 'bomflorLogin', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('bf_ajax_login'),
    ]);
});

// Organization JSON-LD structured data
add_action('wp_head', function (): void {
    echo '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Florist",
  "name": "Bomflor",
  "image": "https://www.bomflor.com/wp-content/uploads/2026/04/bomflor-logo2.svg",
  "url": "https://www.bomflor.com",
  "telephone": "+593987532264",
  "priceRange": "$",
  "description": "Florister\u00eda en Quito especializada en arreglos florales para cumplea\u00f1os, aniversarios, condolencias y eventos corporativos. Entrega a domicilio el mismo d\u00eda.",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Villalengua Oe3-63 y Av. Am\u00e9rica",
    "addressLocality": "Quito",
    "addressRegion": "Pichincha",
    "addressCountry": "EC"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": -0.1807,
    "longitude": -78.4858
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      "opens": "08:00",
      "closes": "15:30"
    }
  ],
  "areaServed": {
    "@type": "City",
    "name": "Quito"
  },
  "sameAs": [
    "https://www.facebook.com/bomflor/",
    "https://www.instagram.com/bomflor/"
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "500"
  }
}
</script>' . "\n";
}, 1);

// Preconnect to Google Fonts + unpkg for faster external resource resolution
add_action('wp_head', function (): void {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1);

// Register block patterns
add_action('init', function (): void {
    register_block_pattern_category('bomflor', ['label' => __('Bomflor', 'bomflor')]);
    $patterns = ['hero', 'ticker', 'category-grid', 'product-featured', 'artist-strip', 'parallax-quote', 'delivery-features', 'testimonials', 'testimonials-page', 'cta-banner', 'faq-accordion'];
    foreach ($patterns as $p) {
        $file = get_template_directory() . "/patterns/{$p}.php";
        if (file_exists($file)) {
            register_block_pattern("bomflor/{$p}", require $file);
        }
    }
});

// Security hardening
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
add_filter('xmlrpc_enabled', '__return_false');
add_filter('wp_lazy_loading_enabled', '__return_true');
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Remove "Categoría:", "Archivos:", etc. prefixes from archive titles
add_filter('get_the_archive_title_prefix', '__return_empty_string');

if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

add_action('send_headers', function (): void {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
});

// Restrict REST API for anonymous users (WC routes exempt)
add_filter('rest_authentication_errors', function ($result) {
    if (!empty($result))
        return $result;
    if (!is_user_logged_in()) {
        $route = $GLOBALS['wp']->query_vars['rest_route'] ?? '';
        if (
            !str_starts_with($route, '/wc/') &&
            !str_starts_with($route, '/wp/v2/types') &&
            !str_starts_with($route, '/wp/v2/taxonomies')
        ) {
            return new WP_Error('rest_not_logged_in', 'Authentication required.', ['status' => 401]);
        }
    }
    return $result;
});

// ═══════════════════════════════════════════════════════════════
// CHECKOUT — Custom fields & delivery logic
// Ported from dt-the7-child; active theme is bomflor.
// ═══════════════════════════════════════════════════════════════

// ─── Remove "(optional)" label text from all checkout fields ────
add_filter('woocommerce_form_field', function (string $field, string $key, array $args, $value): string {
    if (is_checkout() && !is_wc_endpoint_url()) {
        $optional = '&nbsp;<span class="optional">(' . esc_html__('optional', 'woocommerce') . ')</span>';
        $field = str_replace($optional, '', $field);
    }
    return $field;
}, 10, 4);

// ─── Translate "Billing details" heading to Spanish ─────────────
add_filter('gettext', function (string $translated, string $text, string $domain): string {
    if (in_array($domain, ['woocommerce', 'the7mk2'], true)) {
        if ($text === 'Billing details' || $text === 'Billing &amp; Shipping') {
            return 'Datos de Facturación';
        }
    }
    return $translated;
}, 20, 3);

// ─── Alert email on pending / cancelled orders ──────────────────
add_action('woocommerce_new_order', function (int $order_id): void {
    $order = wc_get_order($order_id);
    if (!$order)
        return;
    if (!in_array($order->get_status(), ['pending', 'cancelled'], true))
        return;

    wp_mail(
        'ventas@bomflor.com',
        'ALERTA... Nueva orden pendiente de pago! ' . $order->get_status(),
        'Gabriel, tienes una nueva orden con estado: ' . $order->get_status() . '. Order ID: ' . $order_id
    );
});

// ─── Sector de Entrega (wp_sectoresquito) — shipping fee ────────
add_action('woocommerce_cart_calculate_fees', function (WC_Cart $cart): void {
    if (!$_POST || (is_admin() && !wp_doing_ajax()))
        return;

    $post_data = [];
    if (isset($_POST['post_data'])) {
        parse_str(wp_unslash($_POST['post_data']), $post_data);
    } else {
        $post_data = $_POST;
    }

    $sector = isset($post_data['wp_sectoresquito']) ? sanitize_text_field($post_data['wp_sectoresquito']) : '';
    if (empty($sector) || $sector === 'blank')
        return;

    $fees = [
        'San Antonio mitad del mundo' => 13,
        'la Pampa' => 11,
        'Pomasqui' => 9,
        'Pusuqui' => 8,
        'Marianitas' => 11,
        'Zabala' => 12,
        'Calderon' => 10,
        'Carapungo' => 8,
        'Carcelen Bajo' => 8,
        'Llano grande' => 10,
        'El Condado' => 5,
        'Carcelén' => 7,
        'Ponceano' => 6,
        'Cotocollao' => 5,
        'Comité del Pueblo' => 7,
        'San Carlos' => 5,
        'Paques del recuerdo' => 6,
        'Zambiza' => 9,
        'Solca' => 6,
        'Real Audiencia' => 5,
        'San Fernando' => 5,
        'Pinar Alto' => 4,
        'La Concepción' => 3,
        'Kennedy' => 4,
        'Monteolivo' => 4,
        'Funeraria nacional, Necropoli, Exequiales Iees' => 4,
        'Nayon' => 6,
        'Tanda' => 7,
        'Miravalle 2' => 5,
        'Miravalle 4' => 5,
        'Rancho San Francisco' => 5,
        'Cumbaya' => 7,
        'Lumbisi' => 8,
        'La Viña' => 8,
        'La Morita' => 10,
        'La Ceramica' => 10,
        'Tumbaco' => 9,
        'Chiviqui' => 11,
        'Puembo' => 13,
        'Arrayanes' => 15,
        'Tababela' => 18,
        'San Isidro del Inca' => 5,
        'La Luz' => 3,
        'Jipijapa' => 3,
        'Rumipamba' => 3,
        'Iñaquito' => 3,
        'Las casas' => 3,
        'Mariscal sucre norte' => 4,
        'La Carolina' => 3,
        'Granda Centeno' => 3,
        'Funeraria los Lirios, La Paz' => 3,
        'El Bosque' => 3,
        'Quito Tenis' => 3,
        'Iñaquito Alto' => 5,
        'Hospital Metropolitano' => 4,
        'San Gabriel' => 3,
        'Miraflores' => 5,
        'Gonzales Suarez' => 4,
        'Bosmediano' => 4,
        'La Mariscal' => 4,
        'La Floresta' => 5,
        'La Vicentina' => 6,
        'Funeraria Casa Giron' => 4,
        'El Batan' => 4,
        'Universiada UIDE' => 8,
        'El Peaje puente 1 y 2' => 9,
        'La Armenia' => 10,
        'Monjas' => 8,
        'La Recoleta' => 6,
        'Conocoto' => 11,
        'San Rafael' => 12,
        'Capelo' => 13,
        'Espe' => 14,
        'Sangolqui' => 15,
        'Selva Alegre' => 17,
        'Camposanto Jardines de Valle' => 17,
        'San Juan' => 5,
        'Itchimbía' => 6,
        'Centro Histórico' => 5,
        'La Villaflora' => 7,
        'La Libertad' => 6,
        'Panecillo' => 7,
        'Chimbacalle' => 7,
        'La Magdalena' => 7,
        'Chilibulo' => 8,
        'La Ferroviaria' => 8,
        'San Bartolo' => 8,
        'La Mena' => 9,
        'Solanda' => 9,
        'La Argelia' => 10,
        'Chillogallo' => 10,
        'Quitumbe' => 13,
        'La Ecuatoriana' => 14,
        'Guamaní' => 14,
        'El Recreo' => 7,
        'Turubamba' => 14,
        'Cementerio Jardines Santa Rosa' => 18,
    ];

    if (isset($fees[$sector])) {
        $cart->add_fee('Envío — ' . $sector, $fees[$sector]);
    }
});

// ─── Cart page: informational shipping row ────────────────────────
add_action('woocommerce_cart_totals_before_order_total', function (): void {
    if (!is_cart())
        return;
    ?>
    <tr class="bf-shipping-note">
        <th><?php esc_html_e('Envío', 'bomflor'); ?></th>
        <td><span class="bf-shipping-note__text">Se selecciona en el Checkout</span></td>
    </tr>
    <?php
});

// ─── Delivery fields card (rendered after billing card) ──────────
add_action('woocommerce_checkout_after_customer_details', function (): void {
    $checkout = WC()->checkout();

    echo '<div class="bomflor-delivery-fields">';
    echo '<h3><i data-lucide="truck"></i> ' . esc_html__('Datos de Entrega', 'bomflor') . '</h3>';

    // Sector — changing this select triggers a live cart update (see JS below)
    woocommerce_form_field('wp_sectoresquito', [
        'type' => 'select',
        'class' => ['form-row-wide'],
        'label' => __('Sector de Entrega', 'bomflor'),
        'required' => true,
        'options' => [
            '' => 'Seleccione sector (si no lo encuentra contáctenos al ' . bf_get_whatsapp_display() . ')',
            'San Antonio mitad del mundo' => 'San Antonio mitad del mundo $13',
            'la Pampa' => 'la Pampa $11',
            'Pomasqui' => 'Pomasqui $9',
            'Pusuqui' => 'Pusuqui $8',
            'Marianitas' => 'Marianitas $11',
            'Zabala' => 'Zabala $12',
            'Calderon' => 'Calderon $10',
            'Carapungo' => 'Carapungo $8',
            'Carcelen Bajo' => 'Carcelen Bajo $8',
            'Llano grande' => 'Llano grande $10',
            'El Condado' => 'El Condado $5',
            'Carcelén' => 'Carcelén $7',
            'Ponceano' => 'Ponceano $6',
            'Cotocollao' => 'Cotocollao $5',
            'Comité del Pueblo' => 'Comité del Pueblo $7',
            'San Carlos' => 'San Carlos $5',
            'Paques del recuerdo' => 'Paques del recuerdo $6',
            'Zambiza' => 'Zambiza $9',
            'Solca' => 'Solca $6',
            'Real Audiencia' => 'Real Audiencia $5',
            'San Fernando' => 'San Fernando $5',
            'Pinar Alto' => 'Pinar Alto $4',
            'La Concepción' => 'La Concepción $3',
            'Kennedy' => 'Kennedy $4',
            'Monteolivo' => 'Monteolivo $4',
            'Funeraria nacional, Necropoli, Exequiales Iees' => 'Funeraria nacional, Necropoli, Exequiales Iees $4',
            'Nayon' => 'Nayon $6',
            'Tanda' => 'Tanda $7',
            'Miravalle 2' => 'Miravalle 2 $5',
            'Miravalle 4' => 'Miravalle 4 $5',
            'Rancho San Francisco' => 'Rancho San Francisco $5',
            'Cumbaya' => 'Cumbaya $7',
            'Lumbisi' => 'Lumbisi $8',
            'La Viña' => 'La Viña $8',
            'La Morita' => 'La Morita $10',
            'La Ceramica' => 'La Ceramica $10',
            'Tumbaco' => 'Tumbaco $9',
            'Chiviqui' => 'Chiviqui $11',
            'Puembo' => 'Puembo $13',
            'Arrayanes' => 'Arrayanes $15',
            'Tababela' => 'Tababela $18',
            'San Isidro del Inca' => 'San Isidro del Inca $5',
            'La Luz' => 'La Luz $3',
            'Jipijapa' => 'Jipijapa $3',
            'Rumipamba' => 'Rumipamba $3',
            'Iñaquito' => 'Iñaquito $3',
            'Las casas' => 'Las casas $3',
            'Mariscal sucre norte' => 'Mariscal sucre norte $4',
            'La Carolina' => 'La Carolina $3',
            'Granda Centeno' => 'Granda Centeno $3',
            'Funeraria los Lirios, La Paz' => 'Funeraria los Lirios, La Paz $3',
            'El Bosque' => 'El Bosque $3',
            'Quito Tenis' => 'Quito Tenis $3',
            'Iñaquito Alto' => 'Iñaquito Alto $5',
            'Hospital Metropolitano' => 'Hospital Metropolitano $4',
            'San Gabriel' => 'San Gabriel $3',
            'Miraflores' => 'Miraflores $5',
            'Gonzales Suarez' => 'Gonzales Suarez $4',
            'Bosmediano' => 'Bosmediano $4',
            'La Mariscal' => 'La Mariscal (Zona Rosa) $4',
            'La Floresta' => 'La Floresta $5',
            'La Vicentina' => 'La Vicentina $6',
            'Funeraria Casa Giron' => 'Funeraria Casa Giron $4',
            'El Batan' => 'El Batan $4',
            'Universiada UIDE' => 'Universiada UIDE $8',
            'El Peaje puente 1 y 2' => 'El Peaje puente 1 y 2 $9',
            'La Armenia' => 'La Armenia $10',
            'Monjas' => 'Monjas $8',
            'La Recoleta' => 'La Recoleta $6',
            'Conocoto' => 'Conocoto $11',
            'San Rafael' => 'San Rafael $12',
            'Capelo' => 'Capelo $13',
            'Espe' => 'Espe $14',
            'Sangolqui' => 'Sangolqui $15',
            'Selva Alegre' => 'Selva Alegre $17',
            'Camposanto Jardines de Valle' => 'Camposanto Jardines de Valle $17',
            'San Juan' => 'San Juan $5',
            'Itchimbía' => 'Itchimbía $6',
            'Centro Histórico' => 'Centro Histórico $5',
            'La Villaflora' => 'La Villaflora $7',
            'La Libertad' => 'La Libertad $6',
            'Panecillo' => 'Panecillo $7',
            'Chimbacalle' => 'Chimbacalle $7',
            'La Magdalena' => 'La Magdalena $7',
            'Chilibulo' => 'Chilibulo $8',
            'La Ferroviaria' => 'La Ferroviaria $8',
            'San Bartolo' => 'San Bartolo $8',
            'La Mena' => 'La Mena $9',
            'Solanda' => 'Solanda $9',
            'La Argelia' => 'La Argelia $10',
            'Chillogallo' => 'Chillogallo $10',
            'Quitumbe' => 'Quitumbe $13',
            'La Ecuatoriana' => 'La Ecuatoriana $14',
            'Guamaní' => 'Guamaní $14',
            'El Recreo' => 'El Recreo $7',
            'Turubamba' => 'Turubamba $14',
            'Cementerio Jardines Santa Rosa' => 'Cementerio Jardines Santa Rosa $18',
        ],
    ], $checkout->get_value('wp_sectoresquito'));

    woocommerce_form_field('bomflor_delivery_address', [
        'type' => 'text',
        'class' => ['form-row-wide'],
        'label' => __('Dirección exacta de entrega', 'bomflor'),
        'placeholder' => __('Calles, numeración, referencia...', 'bomflor'),
        'required' => true,
    ], $checkout->get_value('bomflor_delivery_address'));

    woocommerce_form_field('bomflor_recipient_name', [
        'type' => 'text',
        'class' => ['form-row-first'],
        'label' => __('Para quién van las flores', 'bomflor'),
        'placeholder' => __('Nombre completo de quien recibe', 'bomflor'),
        'required' => true,
    ], $checkout->get_value('bomflor_recipient_name'));

    woocommerce_form_field('bomflor_recipient_phone', [
        'type' => 'tel',
        'class' => ['form-row-last'],
        'label' => __('Celular quien recibe', 'bomflor'),
        'placeholder' => '0999 000 000',
        'required' => true,
    ], $checkout->get_value('bomflor_recipient_phone'));

    woocommerce_form_field('bomflor_delivery_date', [
        'type' => 'date',
        'class' => ['form-row-first'],
        'label' => __('Fecha de Entrega', 'bomflor'),
        'required' => true,
    ], $checkout->get_value('bomflor_delivery_date'));

    woocommerce_form_field('bomflor_delivery_time', [
        'type' => 'select',
        'class' => ['form-row-last'],
        'label' => __('Horario de Entrega', 'bomflor'),
        'required' => true,
        'options' => [
            '' => __('Seleccione horario', 'bomflor'),
            '08:00-12:00' => '08:00 – 12:00',
            '12:00-16:00' => '12:00 – 16:00',
            '16:00-20:00' => '16:00 – 20:00',
        ],
    ], $checkout->get_value('bomflor_delivery_time'));

    woocommerce_form_field('bomflor_observations', [
        'type' => 'textarea',
        'class' => ['form-row-wide'],
        'label' => __('Observaciones', 'bomflor'),
        'placeholder' => __('Instrucciones especiales para el repartidor…', 'bomflor'),
        'required' => false,
    ], $checkout->get_value('bomflor_observations'));

    woocommerce_form_field('bomflor_card_message', [
        'type' => 'textarea',
        'class' => ['form-row-wide'],
        'label' => __('Mensaje para la Tarjeta Impresa', 'bomflor'),
        'placeholder' => __('Escribe aquí el mensaje que irá en la tarjeta…', 'bomflor'),
        'required' => false,
    ], $checkout->get_value('bomflor_card_message'));

    echo '</div>';
});

// ─── JS: trigger live cart update when sector changes and inject icons ────────────
add_action('wp_footer', function (): void {
    if (!is_checkout())
        return;
    ?>
    <script>
        (function ($) {
            $(function () {
                $('#wp_sectoresquito').on('change', function () {
                    $('body').trigger('update_checkout');
                });

                // Inject Lucide icon into WooCommerce billing heading
                if ($('.woocommerce-billing-fields > h3').length && !$('.woocommerce-billing-fields > h3 i').length) {
                    $('.woocommerce-billing-fields > h3').prepend('<i data-lucide="receipt"></i> ');
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }

                // Re-initialize icons when WooCommerce updates the checkout via AJAX
                $(document.body).on('updated_checkout', function () {
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });

                // Proxy custom coupon field to native hidden WooCommerce coupon form
                $(document.body).on('click', '#bf_apply_coupon', function (e) {
                    e.preventDefault();
                    var code = $('#bf_coupon_code').val();
                    var $form = $('form.checkout_coupon');
                    if (code && $form.length) {
                        $form.find('input[name="coupon_code"]').val(code);
                        $form.submit();
                    }
                });

                // Allow hitting Enter in the custom coupon field
                $(document.body).on('keypress', '#bf_coupon_code', function (e) {
                    if (e.which == 13) {
                        e.preventDefault();
                        $('#bf_apply_coupon').click();
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
});

// ─── Custom Coupon Field in Sidebar ──────────────────────────────
add_action('woocommerce_review_order_after_cart_contents', function (): void {
    echo '<tr class="bf-coupon-row"><td colspan="2" style="padding: 1.5rem 0 0.5rem; border-bottom: 1px solid rgba(255,255,255,.08);">';
    echo '<p style="margin: 0 0 0.5rem; font-size: .65rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(240,237,230,.45); font-family: var(--wp--preset--font-family--ui); display:flex; align-items:center; gap:.4rem;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29a1 1 0 0 0 1.42 0l6.58-6.58a1 1 0 0 0 0-1.42L12 2Z"/><path d="M7 7h.01"/></svg>Cupón de descuento</p>';
    echo '<div class="bf-custom-coupon-wrapper">';
    echo '<input type="text" id="bf_coupon_code" placeholder="Ingresa tu código aquí" class="input-text" />';
    echo '<button type="button" id="bf_apply_coupon" class="button">APLICAR</button>';
    echo '</div>';
    echo '</td></tr>';
});

// ─── Add Product Thumbnails to Checkout ───────────────────────────
add_filter('woocommerce_checkout_cart_item_quantity', '__return_empty_string');

add_filter('woocommerce_cart_item_name', function (string $name, array $cart_item, string $cart_item_key): string {
    if (!is_checkout())
        return $name;

    $product = $cart_item['data'];
    $thumbnail = $product->get_image([60, 60]);
    $qty = $cart_item['quantity'];

    $html = '<div class="bf-checkout-item-name">';
    $html .= '<div class="bf-checkout-item-thumb">' . $thumbnail . '<span class="bf-qty-badge">' . esc_html($qty) . '</span></div>';
    $html .= '<div class="bf-checkout-item-title">' . $name . '</div>';
    $html .= '</div>';

    return $html;
}, 10, 3);

// ─── Add Secure Checkout Badge under Place Order button ─────────
add_action('woocommerce_review_order_after_submit', function (): void {
    echo '<div class="bf-secure-checkout-badge">';
    echo '<h4><i data-lucide="lock"></i> Pago Seguro - Encriptado SSL</h4>';
    echo '<p>Sus datos personales y financieros están protegidos durante cada transacción.</p>';
    echo '</div>';
});

// ─── Suppress woo-delivery plugin's own time field (we use bomflor_delivery_time instead) ──
add_filter('option_coderockz_woo_delivery_time_settings', function ($settings) {
    if (is_array($settings)) {
        $settings['enable_delivery_time'] = false;
        $settings['delivery_time_mandatory'] = false;
    }
    return $settings;
});

// ─── Validation ─────────────────────────────────────────────────
add_action('woocommerce_checkout_process', function (): void {
    $sector = isset($_POST['wp_sectoresquito']) ? sanitize_text_field(wp_unslash($_POST['wp_sectoresquito'])) : '';
    if (empty($sector) || $sector === 'blank') {
        wc_add_notice(__('Por favor, elige un sector de entrega.', 'bomflor'), 'error');
    }
    if (empty($_POST['bomflor_delivery_address'])) {
        wc_add_notice(__('Ingresa la dirección exacta de entrega.', 'bomflor'), 'error');
    }
    if (empty($_POST['bomflor_recipient_name'])) {
        wc_add_notice(__('Ingresa el nombre de quien recibe las flores.', 'bomflor'), 'error');
    }
    if (empty($_POST['bomflor_recipient_phone'])) {
        wc_add_notice(__('Ingresa el celular de quien recibe.', 'bomflor'), 'error');
    }
    if (empty($_POST['bomflor_delivery_date'])) {
        wc_add_notice(__('Selecciona la fecha de entrega.', 'bomflor'), 'error');
    }
    if (empty($_POST['bomflor_delivery_time'])) {
        wc_add_notice(__('Selecciona el horario de entrega.', 'bomflor'), 'error');
    }
});

// ─── Save all delivery fields to order meta ──────────────────────
add_action('woocommerce_checkout_update_order_meta', function (int $order_id): void {
    if (!empty($_POST['wp_sectoresquito'])) {
        update_post_meta($order_id, 'wp_sectoresquito', sanitize_text_field(wp_unslash($_POST['wp_sectoresquito'])));
    }
    $text_fields = ['bomflor_delivery_address', 'bomflor_recipient_name', 'bomflor_recipient_phone', 'bomflor_delivery_date', 'bomflor_delivery_time'];
    foreach ($text_fields as $field) {
        if (!empty($_POST[$field])) {
            update_post_meta($order_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
    $textarea_fields = ['bomflor_observations', 'bomflor_card_message'];
    foreach ($textarea_fields as $field) {
        if (!empty($_POST[$field])) {
            update_post_meta($order_id, $field, sanitize_textarea_field(wp_unslash($_POST[$field])));
        }
    }
});

// ─── Display delivery data as own card after the billing block ──
add_filter('render_block', function (string $html, array $block): string {
    if ($block['blockName'] !== 'woocommerce/order-confirmation-billing-wrapper') {
        return $html;
    }
    if (!is_wc_endpoint_url('order-received')) {
        return $html;
    }

    $order_key = isset($_GET['key']) ? sanitize_text_field(wp_unslash($_GET['key'])) : '';
    if (!$order_key) {
        return $html;
    }
    $order_id = wc_get_order_id_by_order_key($order_key);
    if (!$order_id) {
        return $html;
    }
    $order = wc_get_order($order_id);
    if (!$order) {
        return $html;
    }

    $labels = [
        'wp_sectoresquito'       => 'Sector de Entrega',
        'bomflor_delivery_address' => 'Dirección Exacta de Entrega',
        'bomflor_recipient_name' => 'Para quién van las flores',
        'bomflor_recipient_phone' => 'Celular quien recibe',
        'bomflor_delivery_date'  => 'Fecha de Entrega',
        'bomflor_delivery_time'  => 'Horario de Entrega',
        'bomflor_observations'   => 'Observaciones',
        'bomflor_card_message'   => 'Mensaje para la Tarjeta',
    ];

    $rows = '';
    foreach ($labels as $key => $label) {
        $value = $order->get_meta($key);
        if ($value && $value !== 'blank') {
            $rows .= '<tr><th>' . esc_html($label) . '</th><td>' . esc_html($value) . '</td></tr>';
        }
    }

    if (!$rows) {
        return $html;
    }

    $card  = '<div class="wc-block-order-confirmation-delivery-wrapper">';
    $card .= '<h2>' . esc_html__('Datos de Entrega', 'bomflor') . '</h2>';
    $card .= '<table class="woocommerce-table shop_table"><tbody>' . $rows . '</tbody></table>';
    $card .= '</div>';

    return $card . $html;
}, 10, 2);

// ─── Display delivery data in WP admin order view ───────────────
add_action('woocommerce_admin_order_data_after_shipping_address', function (WC_Order $order): void {
    $labels = [
        'wp_sectoresquito' => 'Sector de Entrega',
        'bomflor_delivery_address' => 'Dirección Exacta de Entrega',
        'bomflor_recipient_name' => 'Para quién van las flores',
        'bomflor_recipient_phone' => 'Celular quien recibe',
        'bomflor_delivery_date' => 'Fecha de Entrega',
        'bomflor_delivery_time' => 'Horario de Entrega',
        'bomflor_observations' => 'Observaciones',
        'bomflor_card_message' => 'Mensaje para la Tarjeta',
    ];
    foreach ($labels as $key => $label) {
        $value = $order->get_meta($key);
        if ($value && $value !== 'blank') {
            echo '<p><strong>' . esc_html($label) . ':</strong> ' . esc_html($value) . '</p>';
        }
    }
}, 10, 1);

// ─── Include delivery data in WooCommerce order emails ───────────
add_filter('woocommerce_email_order_meta_fields', function (array $fields, bool $sent_to_admin, WC_Order $order): array {
    $delivery_fields = [
        'wp_sectoresquito' => 'Sector de Entrega',
        'bomflor_delivery_address' => 'Dirección Exacta de Entrega',
        'bomflor_recipient_name' => 'Para quién van las flores',
        'bomflor_recipient_phone' => 'Celular quien recibe',
        'bomflor_delivery_date' => 'Fecha de Entrega',
        'bomflor_delivery_time' => 'Horario de Entrega',
        'bomflor_observations' => 'Observaciones',
        'bomflor_card_message' => 'Mensaje para la Tarjeta',
    ];
    foreach ($delivery_fields as $key => $label) {
        $value = $order->get_meta($key);
        if ($value && $value !== 'blank') {
            $fields[$key] = ['label' => __($label, 'bomflor'), 'value' => $value];
        }
    }
    return $fields;
}, 10, 3);

// Shop archive: product grid via classic WC loop (replaces broken all-products React block)
add_shortcode('bf_product_grid', function (): string {
    global $wp_query;

    $on_archive = function_exists('is_shop') && (is_shop() || is_product_category() || is_product_tag());

    if (!$wp_query->have_posts()) {
        $close = $on_archive ? '</div>' : ''; // close bf-shop-wrap opened by render_block filter
        return '<p class="bf-no-products">' . esc_html__('No se encontraron productos.', 'bomflor') . '</p>' . $close;
    }

    ob_start();
    echo '<div class="woocommerce">';
    woocommerce_product_loop_start();
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        wc_get_template_part('content', 'product');
    }
    woocommerce_product_loop_end();
    wp_reset_postdata();
    woocommerce_pagination();
    echo '</div>';
    $output = ob_get_clean();

    // Close bf-shop-wrap that was opened by the render_block filter below
    if ($on_archive) {
        $output .= '</div>';
    }

    return $output;
});

// Archive block templates: WooCommerce strips wp:group wrapper divs, leaving blocks
// as direct children of .wp-site-blocks with no padding or layout structure.
// This filter re-injects the necessary structural wrappers around the rendered blocks.
//
// Pages with breadcrumbs after title (shop + category): open band before title, close after breadcrumbs.
// Tag/brand pages: no breadcrumbs block — self-close the band around the title only.
add_filter('render_block', function (string $html, array $block): string {
    if (!function_exists('is_shop') || !is_woocommerce() || is_product()) {
        return $html;
    }

    // Pages whose templates include woocommerce/breadcrumbs after the title
    $has_breadcrumbs = is_shop() || is_product_category();

    switch ($block['blockName']) {
        case 'core/query-title':
            if ($has_breadcrumbs) {
                // Band stays open — closed by woocommerce/breadcrumbs below
                return '<div class="bf-archive-head-band"><div class="bf-archive-head-inner">' . $html;
            }
            // Tag/brand pages: self-contained band around title only
            return '<div class="bf-archive-head-band"><div class="bf-archive-head-inner">' . $html . '</div></div>';

        case 'woocommerce/breadcrumbs':
            if ($has_breadcrumbs) {
                return $html . '</div></div>'; // close bf-archive-head-inner + bf-archive-head-band
            }
            break;

        case 'woocommerce/product-results-count':
            if ($has_breadcrumbs) { // same pages that have the [bf_product_grid] shortcode
                return '<div class="bf-shop-wrap"><div class="bf-shop-toolbar">' . $html;
            }
            break;

        case 'woocommerce/catalog-sorting':
            if ($has_breadcrumbs) {
                return $html . '</div>'; // close bf-shop-toolbar; bf-shop-wrap closed by [bf_product_grid]
            }
            break;
    }

    return $html;
}, 10, 2);

// Shop archive: category filter pills shortcode
add_shortcode('bf_category_pills', function (): string {
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => 0,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ]);

    if (is_wp_error($categories) || empty($categories))
        return '';

    $active_slug = is_product_category() ? (get_queried_object()->slug ?? '') : '';
    $on_shop     = function_exists('is_shop') && is_shop();

    $icons = [
        'flores' => '🌸',
        'rosas' => '🌹',
        'orquideas' => '🌺',
        'girasoles' => '🌻',
        'flower-boxes' => '📦',
        'arreglos' => '💐',
        'cumpleanos' => '🎂',
        'aniversarios' => '💑',
        'condolencias' => '🕊️',
        'bodas' => '💐',
        'corporativos' => '🏢',
        'navidad' => '🎄',
    ];

    $html = '<div class="bf-category-pills"><div class="bf-category-pills__inner">';

    $all_active = $on_shop ? ' bf-pill--active' : '';
    $html .= '<a href="' . esc_url(wc_get_page_permalink('shop')) . '" class="bf-pill' . $all_active . '">'
        . '<span class="bf-pill__icon">💐</span>'
        . '<span>Ver todos</span>'
        . '</a>';

    foreach ($categories as $cat) {
        if ($cat->slug === 'uncategorized')
            continue;
        $url = get_term_link($cat);
        $active = ($cat->slug === $active_slug) ? ' bf-pill--active' : '';
        $icon = $icons[$cat->slug] ?? '🌿';

        $html .= '<a href="' . esc_url($url) . '" class="bf-pill' . $active . '">'
            . '<span class="bf-pill__icon">' . $icon . '</span>'
            . '<span>' . esc_html($cat->name) . '</span>'
            . '</a>';
    }

    $html .= '</div></div>';
    return $html;
});

// WhatsApp Global Configuration
function bf_get_whatsapp_number(): string {
    return '593987532264';
}

function bf_get_whatsapp_display(): string {
    return '098 753 2264';
}

function bf_get_whatsapp_link(): string {
    return 'https://wa.me/' . bf_get_whatsapp_number();
}

// Inject whatsapp link into {{WHATSAPP_LINK}} token used in html templates and patterns
add_filter('render_block', function (string $block_content, array $block): string {
    if (!str_contains($block_content, '{{WHATSAPP_LINK}}')) {
        return $block_content;
    }
    return str_replace('{{WHATSAPP_LINK}}', esc_url(bf_get_whatsapp_link()), $block_content);
}, 10, 2);

// Inject site logo into {{SITE_LOGO}} token used in wp:html header/footer blocks
add_filter('render_block', function (string $block_content, array $block): string {
    if (!str_contains($block_content, '{{SITE_LOGO}}')) {
        return $block_content;
    }
    $logo = get_custom_logo();
    if (!$logo) {
        $logo = '<a href="' . esc_url(home_url('/')) . '" class="bf-nav__logo-fallback">'
            . esc_html(get_bloginfo('name'))
            . '</a>';
    }
    return str_replace('{{SITE_LOGO}}', $logo, $block_content);
}, 10, 2);

// Helper to parse wp_navigation blocks into simple HTML
function bf_render_block_nav_items($blocks)
{
    $html = '';
    foreach ($blocks as $block) {
        if ($block['blockName'] === 'core/navigation-link' && !empty($block['attrs']['url'])) {
            $url = esc_url($block['attrs']['url']);
            $label = esc_html($block['attrs']['label'] ?? '');
            $html .= '<li><a href="' . $url . '">' . $label . '</a></li>';
        } elseif ($block['blockName'] === 'core/navigation-submenu' && !empty($block['attrs']['url'])) {
            $url = esc_url($block['attrs']['url']);
            $label = esc_html($block['attrs']['label'] ?? '');
            $html .= '<li class="has-submenu"><a href="' . $url . '">' . $label . '</a>';
            if (!empty($block['innerBlocks'])) {
                $html .= '<ul class="submenu">';
                $html .= bf_render_block_nav_items($block['innerBlocks']);
                $html .= '</ul>';
            }
            $html .= '</li>';
        }
    }
    return $html;
}

// Inject primary navigation into {{PRIMARY_NAV}} token used in header
add_filter('render_block', function (string $block_content, array $block): string {
    if (!str_contains($block_content, '{{PRIMARY_NAV}}')) {
        return $block_content;
    }

    $nav = '';

    // First try to load the "PRINCIPAL" block navigation from the Site Editor
    $nav_posts = get_posts([
        'post_type' => 'wp_navigation',
        'title' => 'PRINCIPAL',
        'post_status' => 'publish',
        'numberposts' => 1
    ]);

    if (!empty($nav_posts)) {
        $blocks = parse_blocks($nav_posts[0]->post_content);
        $nav = '<ul id="menu-principal-desktop" class="bf-nav__links">';
        $nav .= bf_render_block_nav_items($blocks);
        $nav .= '</ul>';
    } else {
        // Fallback to classic menu
        $nav = wp_nav_menu([
            'menu' => 'principal-desktop',
            'menu_class' => 'bf-nav__links',
            'container' => false,
            'echo' => false,
            'fallback_cb' => false,
        ]);
    }

    return str_replace('{{PRIMARY_NAV}}', $nav ?: '', $block_content);
}, 10, 2);

// Inject mobile navigation into {{MOBILE_NAV}} token used in header drawer
add_filter('render_block', function (string $block_content, array $block): string {
    if (!str_contains($block_content, '{{MOBILE_NAV}}')) {
        return $block_content;
    }

    $menu = '';

    // First try to load the "PRINCIPAL MÓVIL" block navigation from the Site Editor
    $nav_posts = get_posts([
        'post_type' => 'wp_navigation',
        'title' => 'PRINCIPAL MÓVIL',
        'post_status' => 'publish',
        'numberposts' => 1
    ]);

    if (!empty($nav_posts)) {
        $blocks = parse_blocks($nav_posts[0]->post_content);
        $menu = '<ul class="bf-nav__drawer-links" role="list">';
        $menu .= bf_render_block_nav_items($blocks);
        $menu .= '</ul>';
    } else {
        // Fallback to classic menu
        $menu = wp_nav_menu([
            'menu' => 'principal-mobile',
            'menu_class' => 'bf-nav__drawer-links',
            'container' => false,
            'items_wrap' => '<ul class="%2$s" role="list">%3$s</ul>',
            'echo' => false,
            'fallback_cb' => false,
        ]);
    }

    return str_replace('{{MOBILE_NAV}}', $menu ?: '', $block_content);
}, 10, 2);

// AJAX login handler (no-priv = unauthenticated users)
add_action('wp_ajax_nopriv_bf_ajax_login', function (): void {
    check_ajax_referer('bf_ajax_login', 'nonce');

    // ob_start/end_clean guards against WC session hooks outputting during wp_login action
    ob_start();
    $user = wp_signon([
        'user_login'    => sanitize_user(wp_unslash($_POST['log'] ?? '')),
        'user_password' => wp_unslash($_POST['pwd'] ?? ''),
        'remember'      => !empty($_POST['rememberme']),
    ], is_ssl());
    ob_end_clean();

    if (is_wp_error($user)) {
        wp_send_json_error(['message' => wp_strip_all_tags($user->get_error_message())]);
    }

    wp_send_json_success(['redirect' => esc_url_raw(wp_unslash($_POST['redirect_to'] ?? home_url('/')))]);
});

// Inject account panel into {{ACCOUNT_PANEL}} token used in header
add_filter('render_block', function (string $block_content, array $block): string {
    if (!str_contains($block_content, '{{ACCOUNT_PANEL}}')) {
        return $block_content;
    }

    $current_url  = esc_url(home_url(add_query_arg(null, null)));
    $login_url    = esc_url(wp_login_url($current_url));
    $lost_pw_url  = esc_url(wp_lostpassword_url($current_url));
    $register_url = esc_url(wp_registration_url());

    if (is_user_logged_in()) {
        $user         = wp_get_current_user();
        $display_name = esc_html($user->display_name ?: $user->user_login);
        $account_url  = esc_url(wc_get_page_permalink('myaccount'));
        $orders_url   = esc_url(wc_get_account_endpoint_url('orders'));
        $address_url  = esc_url(wc_get_account_endpoint_url('edit-address'));
        $profile_url  = esc_url(wc_get_account_endpoint_url('edit-account'));
        $logout_url   = esc_url(wp_logout_url(home_url('/')));

        $panel = '
<div class="bf-account-panel" id="bf-account-panel" role="dialog" aria-label="Mi cuenta" aria-hidden="true">
  <div class="bf-account-panel__header">
    <span class="bf-account-panel__title">Mi Cuenta</span>
    <button class="bf-account-panel__close" id="bf-account-close" aria-label="Cerrar">
      <i data-lucide="x" width="18" height="18"></i>
    </button>
  </div>
  <div class="bf-account-panel__body">
    <div class="bf-account-panel__greeting">
      <i data-lucide="circle-check" width="24" height="24"></i>
      <p>Hola, <strong>' . $display_name . '</strong></p>
    </div>
    <nav class="bf-account-panel__links">
      <a href="' . $account_url . '"><i data-lucide="user" width="15" height="15"></i> Mi Cuenta</a>
      <a href="' . $orders_url . '"><i data-lucide="package" width="15" height="15"></i> Mis Pedidos</a>
      <a href="' . $address_url . '"><i data-lucide="map-pin" width="15" height="15"></i> Mis Direcciones</a>
      <a href="' . $profile_url . '"><i data-lucide="settings" width="15" height="15"></i> Editar Perfil</a>
    </nav>
    <a href="' . $logout_url . '" class="bf-account-panel__logout">
      <i data-lucide="log-out" width="14" height="14"></i> Cerrar Sesión
    </a>
  </div>
</div>
<div class="bf-account-overlay" id="bf-account-overlay"></div>';
    } else {
        $login_nonce = wp_create_nonce('woocommerce-login');

        $panel = '
<div class="bf-account-panel" id="bf-account-panel" role="dialog" aria-label="Mi cuenta" aria-hidden="true">
  <div class="bf-account-panel__header">
    <span class="bf-account-panel__title">Mi Cuenta</span>
    <button class="bf-account-panel__close" id="bf-account-close" aria-label="Cerrar">
      <i data-lucide="x" width="18" height="18"></i>
    </button>
  </div>
  <div class="bf-account-panel__body">

    <form id="bf-login-form" class="bf-auth-form" novalidate>
      <input type="hidden" name="redirect_to" value="' . $current_url . '">
      <div class="bf-login-error" id="bf-login-error" hidden></div>
      <div class="bf-form-field">
        <label for="bf-login-username">Correo o usuario</label>
        <input type="text" id="bf-login-username" name="log" autocomplete="username" required>
      </div>
      <div class="bf-form-field">
        <label for="bf-login-password">Contraseña</label>
        <div class="bf-pw-wrap">
          <input type="password" id="bf-login-password" name="pwd" autocomplete="current-password" required>
          <button type="button" class="bf-pw-toggle" aria-label="Mostrar contraseña">
            <i data-lucide="eye" width="15" height="15"></i>
          </button>
        </div>
      </div>
      <div class="bf-form-remember">
        <label><input type="checkbox" name="rememberme" value="forever"> Recordarme</label>
        <a href="' . $lost_pw_url . '">¿Olvidaste tu contraseña?</a>
      </div>
      <button type="submit" class="bf-btn-submit" id="bf-login-submit">Iniciar Sesión</button>
    </form>

    <div class="bf-account-panel__register-cta">
      <i data-lucide="user-plus" width="28" height="28"></i>
      <p>¿No tienes cuenta aún?</p>
      <a href="' . $register_url . '" class="bf-account-panel__register-link">Crear una cuenta</a>
    </div>

  </div>
</div>
<div class="bf-account-overlay" id="bf-account-overlay"></div>';
    }

    return str_replace('{{ACCOUNT_PANEL}}', $panel, $block_content);
}, 10, 2);

// ─── Resolve {{PRIVACY_URL}} token in footer ─────────────────────
add_filter('render_block', function (string $block_content, array $block): string {
    if (!str_contains($block_content, '{{PRIVACY_URL}}')) {
        return $block_content;
    }
    return str_replace('{{PRIVACY_URL}}', esc_url(get_privacy_policy_url()), $block_content);
}, 10, 2);

// ─── Route wp_registration_url() to the custom register page ───
// Searches post_content for [bf_register_form] — works regardless of how
// the template is assigned (explicit meta or auto-matched by slug).
add_filter('register_url', function (string $fallback): string {
    $cached = wp_cache_get('bf_register_page_url');
    if (false !== $cached) {
        return $cached ?: $fallback;
    }
    global $wpdb;
    $page_id = (int) $wpdb->get_var(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_type   = 'page'
           AND post_status = 'publish'
           AND post_content LIKE '%bf_register_form%'
         LIMIT 1"
    );
    $url = $page_id ? (string) get_permalink($page_id) : '';
    wp_cache_set('bf_register_page_url', $url);
    return $url ?: $fallback;
});

// ─── Redirect wp-login.php?action=register to the custom page ───
add_action('login_init', function (): void {
    if (isset($_GET['action']) && $_GET['action'] === 'register') {
        $url = apply_filters('register_url', '');
        if ($url) {
            wp_safe_redirect($url, 301);
            exit;
        }
    }
});

// ─── Strip <br /> tags that wpautop injects inside the register form ─────────
// wpautop converts single newlines between inline elements (<label>, <input>, <span>)
// to <br /> even inside block-level divs. This late filter runs after wpautop (p10)
// and removes them from the register card HTML only.
add_filter('the_content', function (string $content): string {
    if (strpos($content, 'bf-form-field') === false && strpos($content, 'bf-register-card') === false) {
        return $content;
    }
    // Remove <br /> appearing right after </label> (before the input)
    $content = preg_replace('#(</label>)\s*<br\s*/?>\s*#i', '$1', $content);
    // Remove <br /> between sibling <span> elements (eyebrow)
    $content = preg_replace('#(</span>)\s*<br\s*/?>\s*(?=<span)#i', '$1', $content);
    return $content;
}, 99);

// ─── Registration page shortcode ────────────────────────────
add_shortcode('bf_register_form', function (): string {
    if (!function_exists('WC')) {
        return '';
    }

    if (is_user_logged_in()) {
        return '<div class="bf-register-card"><p class="bf-register-card__logged-in bf-text-muted">'
            . sprintf(
                /* translators: %s: my account URL */
                __('Ya tienes una cuenta activa. <a href="%s">Ir a mi cuenta →</a>', 'bomflor'),
                esc_url(wc_get_page_permalink('myaccount'))
            )
            . '</p></div>';
    }

    $current_url   = esc_url(get_permalink());
    $login_url     = esc_url(wc_get_page_permalink('myaccount'));
    $auto_username = 'yes' === get_option('woocommerce_registration_generate_username');
    $auto_password = 'yes' === get_option('woocommerce_registration_generate_password');

    ob_start();
    ?>
    <div class="bf-register-card">

        <div class="bf-eyebrow">
            <span class="bf-eyebrow-line"></span>
            <span class="bf-eyebrow-text"><?php esc_html_e('Nueva cuenta', 'bomflor'); ?></span>
        </div>

        <h1 class="bf-heading-display bf-register-card__heading"><?php esc_html_e('Crea tu cuenta', 'bomflor'); ?></h1>
        <p class="bf-register-card__subtitle bf-text-muted"><?php esc_html_e('Accede a tus pedidos, guarda tus datos y recibe novedades de Bomflor.', 'bomflor'); ?></p>

        <?php wc_print_notices(); ?>

        <form method="post" class="bf-auth-form bf-register-form" action="<?php echo esc_url($current_url); ?>">
            <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>

            <?php do_action('woocommerce_register_form_start'); ?>

            <?php if (!$auto_username): ?>
            <div class="bf-form-field">
                <label for="reg_username"><?php esc_html_e('Nombre de usuario', 'bomflor'); ?> <abbr class="required" title="<?php esc_attr_e('requerido', 'bomflor'); ?>">*</abbr></label>
                <input type="text" id="reg_username" name="username" autocomplete="username" required value="<?php echo esc_attr(wp_unslash($_POST['username'] ?? '')); ?>">
            </div>
            <?php endif; ?>

            <div class="bf-register-form__row">
                <div class="bf-form-field">
                    <label for="reg_billing_first_name"><?php esc_html_e('Nombre', 'bomflor'); ?></label>
                    <input type="text" id="reg_billing_first_name" name="billing_first_name" autocomplete="given-name" value="<?php echo esc_attr(wp_unslash($_POST['billing_first_name'] ?? '')); ?>">
                </div>
                <div class="bf-form-field">
                    <label for="reg_billing_last_name"><?php esc_html_e('Apellido', 'bomflor'); ?></label>
                    <input type="text" id="reg_billing_last_name" name="billing_last_name" autocomplete="family-name" value="<?php echo esc_attr(wp_unslash($_POST['billing_last_name'] ?? '')); ?>">
                </div>
            </div>

            <div class="bf-form-field">
                <label for="reg_email"><?php esc_html_e('Correo electrónico', 'bomflor'); ?> <abbr class="required" title="<?php esc_attr_e('requerido', 'bomflor'); ?>">*</abbr></label>
                <input type="email" id="reg_email" name="email" autocomplete="email" required value="<?php echo esc_attr(wp_unslash($_POST['email'] ?? '')); ?>">
            </div>

            <?php if (!$auto_password): ?>
            <div class="bf-form-field">
                <label for="reg_password"><?php esc_html_e('Contraseña', 'bomflor'); ?> <abbr class="required" title="<?php esc_attr_e('requerido', 'bomflor'); ?>">*</abbr></label>
                <div class="bf-pw-wrap">
                    <input type="password" id="reg_password" name="password" autocomplete="new-password" required>
                    <button type="button" class="bf-pw-toggle" aria-label="<?php esc_attr_e('Mostrar contraseña', 'bomflor'); ?>"><i data-lucide="eye" width="15" height="15"></i></button>
                </div>
            </div>
            <?php else: ?>
            <p class="bf-register-auto-password bf-text-muted">
                <i data-lucide="mail" width="14" height="14" style="flex-shrink:0"></i>
                <?php esc_html_e('Te enviaremos tu contraseña por correo electrónico.', 'bomflor'); ?>
            </p>
            <?php endif; ?>

            <?php do_action('woocommerce_register_form'); ?>

            <button type="submit" name="register" value="Register" class="bf-btn-submit">
                <?php esc_html_e('Crear mi cuenta', 'bomflor'); ?>
            </button>

            <?php do_action('woocommerce_register_form_end'); ?>

        </form>

        <div class="bf-register-card__footer">
            <p><?php esc_html_e('¿Ya tienes cuenta?', 'bomflor'); ?></p>
            <a href="<?php echo esc_url($login_url); ?>" class="bf-account-panel__register-link"><?php esc_html_e('Iniciar sesión', 'bomflor'); ?></a>
        </div>

    </div>
    <?php
    // Compact tag-to-tag whitespace so wpautop (called by core/shortcode block) doesn't
    // insert <br /> between inline elements like </label> and <input>.
    $html = ob_get_clean();
    $html = preg_replace('/>\s+</s', '><', $html);
    return $html;
});

/* ─── Product card: show category between title and price ─── */
add_action('woocommerce_after_shop_loop_item_title', function () {
    $terms = get_the_terms(get_the_ID(), 'product_cat');
    if (empty($terms) || is_wp_error($terms)) {
        return;
    }
    $term = reset($terms);
    echo '<span class="bf-loop-product-cat">' . esc_html($term->name) . '</span>';
}, 8);
