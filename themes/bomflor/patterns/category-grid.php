<?php
/**
 * Pattern: Category Grid
 *
 * @package Bomflor
 */

$cats = get_terms( [
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
	'exclude'    => get_option( 'default_product_cat' ),
	'number'     => 4,
	'orderby'    => 'menu_order',
	'order'      => 'ASC',
] );

if ( is_wp_error( $cats ) || empty( $cats ) ) {
	return [
		'title'   => __( 'Category Grid', 'bomflor' ),
		'content' => '',
	];
}

$total_products = wp_count_posts( 'product' )->publish ?? 0;
$shop_url       = wc_get_page_permalink( 'shop' );
$all_label    = $total_products === 1 ? '1 arreglo' : $total_products . ' arreglos';

$random_products = get_posts( [
    'post_type'     => 'product',
    'post_status'   => 'publish',
    'numberposts'   => 4,
    'orderby'       => 'rand',
    'has_thumbnail' => true,
    'fields'        => 'ids',
] );

$rotating_imgs = '';
foreach ( $random_products as $idx => $pid ) {
    $img_url = get_the_post_thumbnail_url( $pid, 'medium_large' );
    if ( ! $img_url ) continue;
    $delay = $idx * 3; // 3s per image
    $first = $idx === 0 ? ' bf-rotate-img--first' : '';
    $rotating_imgs .= '<img src="' . esc_url( $img_url ) . '" alt="Ver todos los arreglos" class="bf-cat-card__image bf-rotate-img' . $first . '" style="animation-delay:' . $delay . 's" loading="' . ( $idx === 0 ? 'eager' : 'lazy' ) . '" width="800" height="600">';
}

// "Ver todos" is first and featured (spans 2 rows on desktop)
$cards = '
    <a href="' . esc_url( $shop_url ) . '" class="bf-cat-card bf-cat-card--featured bf-cat-card--all">
      ' . $rotating_imgs . '
      <div class="bf-cat-card__overlay"></div>
      <div class="bf-cat-card__content">
        <p class="bf-cat-card__count">' . esc_html( $all_label ) . '</p>
        <h3 class="bf-cat-card__name">Ver todos</h3>
      </div>
      <div class="bf-cat-card__arrow"><i data-lucide="arrow-right" width="20" height="20" color="#fff"></i></div>
    </a>';

foreach ( $cats as $cat ) {
	$url         = get_term_link( $cat );
	$name        = esc_html( $cat->name );
	$count       = (int) $cat->count;
	$count_label = $count === 1 ? '1 arreglo' : $count . ' arreglos';

	$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
	$img_tag      = '';
	if ( $thumbnail_id ) {
		$img_url = wp_get_attachment_image_url( $thumbnail_id, 'medium_large' );
		$img_tag = '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( $cat->name ) . '" class="bf-cat-card__image" loading="lazy" width="800" height="600">';
	}

	$cards .= '
    <a href="' . esc_url( $url ) . '" class="bf-cat-card">
      ' . $img_tag . '
      <div class="bf-cat-card__overlay"></div>
      <div class="bf-cat-card__content">
        <p class="bf-cat-card__count">' . esc_html( $count_label ) . '</p>
        <h3 class="bf-cat-card__name">' . $name . '</h3>
      </div>
      <div class="bf-cat-card__arrow"><i data-lucide="arrow-right" width="20" height="20" color="#fff"></i></div>
    </a>';
}

$content = '
<section class="bf-section bf-section--warm">
  <div class="bf-container">
    <div class="bf-eyebrow">
      <span class="bf-eyebrow-line"></span>
      <span class="bf-eyebrow-text">Colecciones</span>
    </div>
    <h2 class="bf-heading-display bf-cat-grid__heading">Explora por categoría</h2>
  </div>

  <div class="bf-cat-grid bf-container">
    ' . $cards . '
  </div>
</section>

<style>
.bf-cat-grid__heading {
  margin-bottom: 1.5rem;
}
.bf-cat-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1rem;
  margin-top: 1.5rem;
}
@media (min-width: 768px) {
  .bf-cat-grid {
    grid-template-columns: 2fr 1fr 1fr;
    grid-template-rows: 300px 300px;
  }
  .bf-cat-card--featured {
    grid-row: span 2;
  }
}
.bf-cat-card { min-height: 240px; }
@media (min-width: 768px) { .bf-cat-card { min-height: unset; } }
.bf-cat-card--all { background-color: #1a1a1a; }
/* Rotating images: stacked, crossfade every 3s over a 12s cycle */
.bf-rotate-img {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  opacity: 0;
  animation: bf-crossfade 12s infinite;
}
.bf-rotate-img--first { opacity: 1; }
@keyframes bf-crossfade {
  0%   { opacity: 0; }
  4%   { opacity: 1; }
  25%  { opacity: 1; }
  29%  { opacity: 0; }
  100% { opacity: 0; }
}
</style>
';

return [
	'title'       => __( 'Category Grid', 'bomflor' ),
	'description' => __( 'Masonry-style category grid — first card spans 2 rows on desktop.', 'bomflor' ),
	'categories'  => [ 'bomflor' ],
	'content'     => $content,
];
