<?php
/**
 * Pattern: Featured Products
 *
 * @package Bomflor
 */

ob_start();

$featured_query = new WP_Query([
  'post_type' => 'product',
  'posts_per_page' => 4,
  'post_status' => 'publish',
  'meta_key' => 'total_sales',
  'orderby' => 'meta_value_num',
  'order' => 'DESC',
]);

?>
<section class="bf-section bf-section--warm">
  <div class="bf-container">
    <div class="bf-pf-header">
      <div>
        <div class="bf-eyebrow">
          <span class="bf-eyebrow-line"></span>
          <span class="bf-eyebrow-text">Más pedidos</span>
        </div>
        <h2 class="bf-heading-display bf-pf-heading">Arreglos más Vendidos</h2>
      </div>
      <a href="/flores/" class="bf-pf-more">
        Ver catálogo completo
        <i data-lucide="arrow-right" width="14" height="14"></i>
      </a>
    </div>

    <div class="bf-pf-grid">
      <?php if ($featured_query->have_posts()): ?>
        <?php while ($featured_query->have_posts()):
          $featured_query->the_post(); ?>
          <?php
          $product = wc_get_product(get_the_ID());
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'woocommerce_single')
            ?: get_the_post_thumbnail_url(get_the_ID(), 'large')
            ?: wc_placeholder_img_src('woocommerce_single');
          $name = get_the_title();
          $note = wp_strip_all_tags($product->get_short_description());
          $price = $product->get_price_html();
          $permalink = get_permalink();

          if ($product->is_on_sale()) {
            $badge = 'Oferta';
          } elseif ((time() - strtotime(get_the_date('Y-m-d'))) < 30 * DAY_IN_SECONDS) {
            $badge = 'Nuevo';
          } else {
            $badge = '';
          }
          ?>
          <div class="bf-product-card">
            <div class="bf-product-card__image-wrap">
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>"
                class="bf-product-card__image" loading="lazy" width="600" height="900">
              <?php if ($badge): ?>
                <span class="bf-product-card__badge"><?php echo esc_html($badge); ?></span>
              <?php endif; ?>
              <button class="bf-product-card__heart" aria-label="Guardar en favoritos"><i data-lucide="heart" width="14"
                  height="14"></i></button>
            </div>
            <div class="bf-product-card__body">
              <h3 class="bf-product-card__name"><?php echo esc_html($name); ?></h3>
              <?php if ($note): ?>
                <p class="bf-product-card__note"><?php echo esc_html($note); ?></p>
              <?php endif; ?>
              <p class="bf-product-card__price">
                <?php echo $price; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wc_get_price_html() is pre-sanitized. ?>
              </p>
              <a href="<?php echo esc_url($permalink); ?>" class="bf-product-card__cta">
                Ver arreglo <i data-lucide="arrow-right" width="12" height="12"></i>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<style>
  .bf-pf-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
  }

  .bf-pf-heading {}

  .bf-pf-more {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .65rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--wp--preset--color--lime-deep);
    font-weight: 300;
    transition: gap .2s;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .bf-pf-more:hover {
    gap: .6rem;
  }

  .bf-pf-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
  }

  @media (min-width: 768px) {
    .bf-pf-grid {
      grid-template-columns: repeat(4, 1fr);
      gap: 1.25rem;
    }
  }
</style>
<?php

$content = ob_get_clean();

return [
  'title' => __('Featured Products', 'bomflor'),
  'description' => __('2-col mobile / 4-col desktop product grid on warm paper background.', 'bomflor'),
  'categories' => ['bomflor'],
  'content' => $content,
];
