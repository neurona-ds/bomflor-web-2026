<?php
/**
 * Pattern: Parallax Quote
 *
 * @package Bomflor
 */
return [
  'title' => __('Parallax Quote', 'bomflor'),
  'description' => __('Parallax background with dark green overlay and Cormorant italic quote.', 'bomflor'),
  'categories' => ['bomflor'],
  'content' => '
<section class="bf-pquote">
  <div class="bf-pquote__bg" data-parallax data-parallax-speed="0.25" role="img" aria-label="Flores Bomflor"></div>
  <div class="bf-pquote__overlay"></div>
  <div class="bf-pquote__content bf-container">
    <blockquote class="bf-pquote__quote">
      &ldquo;Las flores son las palabras que el corazón no sabe decir.&rdquo;
    </blockquote>
    <div class="bf-pquote__attribution">
      <div class="bf-pquote__avatar" aria-hidden="true">
        <i data-lucide="flower-2" width="18" height="18"></i>
      </div>
      <div>
        <p class="bf-pquote__attr-name">Gabo</p>
        <p class="bf-pquote__attr-handle">@gabodelasflores</p>
      </div>
    </div>
  </div>
</section>

<style>
.bf-pquote {
  position: relative;
  padding-block: 6rem;
  overflow: hidden;
  display: flex;
  align-items: center;
}
.bf-pquote__bg {
  position: absolute;
  inset: -40% 0;
  background-image: url("/wp-content/themes/bomflor/assets/images/quote-bg.jpg");
  background-size: cover;
  background-position: center;
  will-change: transform;
}
.bf-pquote__overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(14,14,12,.88), rgba(61,75,17,.72));
}
.bf-pquote__content {
  position: relative;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2rem;
  text-align: center;
}
.bf-pquote__quote {
  font-family: var(--wp--preset--font-family--display);
  font-style: italic;
  font-size: clamp(1.4rem, 4vw, 2rem);
  font-weight: 300;
  color: rgba(248,246,241,.92);
  max-width: 700px;
  line-height: 1.35;
}
.bf-pquote__attribution {
  display: flex;
  align-items: center;
  gap: .75rem;
  background: rgba(248,246,241,.1);
  backdrop-filter: blur(16px);
  border-radius: var(--wp--custom--border-radius--circle);
  padding: .5rem 1rem .5rem .5rem;
  border: 1px solid rgba(255,255,255,.12);
}
.bf-pquote__avatar {
  width: 36px;
  height: 36px;
  border-radius: var(--wp--custom--border-radius--circle);
  border: 2px solid var(--wp--preset--color--lime);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--wp--preset--color--lime);
}
.bf-pquote__attr-name {
  font-size: .78rem;
  font-weight: 300;
  color: rgba(248,246,241,.9);
}
.bf-pquote__attr-handle {
  font-size: .6rem;
  color: rgba(248,246,241,.45);
  letter-spacing: .08em;
}
</style>
',
];
