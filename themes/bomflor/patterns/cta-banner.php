<?php
/**
 * Pattern: CTA Banner
 *
 * @package Bomflor
 */
return [
  'title' => __('CTA Banner', 'bomflor'),
  'description' => __('Parallax background with dark overlay. Centered content + two buttons.', 'bomflor'),
  'categories' => ['bomflor'],
  'content' => '
<section class="bf-cta-banner">
  <div class="bf-cta-banner__bg" data-parallax data-parallax-speed="0.2" role="img" aria-label="Flores Bomflor"></div>
  <div class="bf-cta-banner__overlay"></div>
  <div class="bf-cta-banner__content bf-container">
    <div class="bf-eyebrow bf-eyebrow--light">
      <span class="bf-eyebrow-line"></span>
      <span class="bf-eyebrow-text">Entrega hoy</span>
      <span class="bf-eyebrow-line"></span>
    </div>
    <h2 class="bf-heading-display bf-text-light bf-cta-banner__title">
      ¿Listo para sorprender <em class="bf-cta-banner__em">a alguien especial?</em>
    </h2>
    <p class="bf-cta-banner__subtitle">
      Realizamos entregas en Quito. Pide ahora!
    </p>
    <div class="bf-cta-banner__actions">
      <a href="' . esc_url(wc_get_page_permalink('shop')) . '" class="bf-btn bf-btn-lime"> 
        <i data-lucide="flower-2" width="16" height="16"></i>
        Ver flores
      </a>
      <a href="{{WHATSAPP_LINK}}" class="bf-btn bf-btn-ghost" target="_blank" rel="noopener noreferrer">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Pedir por WhatsApp
      </a>
    </div>
  </div>
</section>

<style>
.bf-cta-banner {
  position: relative;
  padding-block: 6rem;
  overflow: hidden;
  display: flex;
  align-items: center;
}
.bf-cta-banner__bg {
  position: absolute;
  inset: -40% 0;
  background-image: url("/wp-content/themes/bomflor/assets/images/cta-bg.jpg");
  background-size: cover;
  background-position: center;
  will-change: transform;
}
.bf-cta-banner__overlay {
  position: absolute;
  inset: 0;
  background: rgba(20,20,18,.72);
}
.bf-cta-banner__content {
  position: relative;
  z-index: 2;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.25rem;
}
.bf-cta-banner__title {
  max-width: 600px;
}
.bf-cta-banner__em { color: var(--wp--preset--color--lime); font-style: italic; }
.bf-cta-banner__subtitle {
  font-size: .84rem;
  font-weight: 200;
  color: rgba(248,246,241,.65);
  max-width: 400px;
}
.bf-cta-banner__actions { display: flex; flex-wrap: wrap; gap: .75rem; justify-content: center; }
.bf-eyebrow.bf-eyebrow--light { justify-content: center; }
</style>
',
];
