<?php
/**
 * Pattern: Artist Strip
 *
 * @package Bomflor
 */
return [
    'title'       => __( 'Artist Strip', 'bomflor' ),
    'description' => __( 'Split layout — image left + dark ink text block right.', 'bomflor' ),
    'categories'  => [ 'bomflor' ],
    'content'     => '
<section class="bf-artist bf-section--dark">
  <div class="bf-artist__image-col">
    <div class="bf-artist__image-wrap">
      <img src="/wp-content/themes/bomflor/assets/images/gabo-artist.jpg" alt="Gabo, artista floral" class="bf-artist__image" loading="lazy" width="800" height="600">
      <div class="bf-artist__image-overlay"></div>
      <div class="bf-artist__caption">
        <p class="bf-artist__caption-name">Gabo</p>
        <p class="bf-artist__caption-role">Artista floral &amp; fundador</p>
      </div>
    </div>
  </div>

  <div class="bf-artist__text-col bf-container">
    <div class="bf-eyebrow bf-eyebrow--light">
      <span class="bf-eyebrow-line"></span>
      <span class="bf-eyebrow-text">Nuestra historia</span>
    </div>
    <h2 class="bf-heading-display bf-text-light bf-artist__title">
      Flores como forma de <em class="bf-artist__em">arte</em>
    </h2>
    <p class="bf-artist__body">
      Gabo lleva más de 24 años convirtiendo flores en experiencias. Cada arreglo es una conversación entre la naturaleza y la emoción humana. Trabajamos con flores frescas de la Sierra ecuatoriana, seleccionadas cada mañana.
    </p>
    <div class="bf-artist__socials">
      <a href="https://www.instagram.com/gabodelasflores/" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
          <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
          <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
        </svg>
      </a>
      <a href="https://www.facebook.com/bomflor/" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
        </svg>
      </a>
      <a href="https://www.youtube.com/@Gabodelasflores" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
          <path d="m10 15 5-3-5-3z" />
        </svg>
      </a>
      <a href="https://www.tiktok.com/@gabodelasflores" target="_blank" rel="noopener noreferrer" aria-label="TikTok">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5" />
        </svg>
      </a>
    </div>
  </div>
</section>

<style>
.bf-artist {
  display: grid;
  grid-template-columns: 1fr;
}
@media (min-width: 768px) {
  .bf-artist { grid-template-columns: 58% 1fr; min-height: 500px; }
}
.bf-artist__image-col { position: relative; min-height: 300px; }
@media (min-width: 768px) { .bf-artist__image-col { min-height: unset; } }
.bf-artist__image-wrap { position: absolute; inset: 0; overflow: hidden; }
.bf-artist__image { width: 100%; height: 100%; object-fit: cover; }
.bf-artist__image-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to right, transparent 60%, var(--wp--preset--color--ink) 100%);
}
.bf-artist__caption {
  position: absolute;
  top: 1.25rem;
  left: 1.25rem;
  background: rgba(248,246,241,.12);
  backdrop-filter: blur(16px);
  border-radius: var(--wp--custom--border-radius--subtle);
  padding: .75rem 1rem;
  border: 1px solid rgba(255,255,255,.12);
}
.bf-artist__caption-name {
  font-family: var(--wp--preset--font-family--display);
  font-size: 1.42rem;
  font-weight: 300;
  color: #fff;
}
.bf-artist__caption-role {
  font-size: .72rem;
  letter-spacing: .1em;
  text-transform: uppercase;
  color: rgba(255,255,255,.6);
  margin-top: .2rem;
}
.bf-artist__text-col {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.25rem;
  padding-block: 3.5rem;
}
@media (min-width: 768px) { .bf-artist__text-col { padding-block: 5.5rem; } }
.bf-artist__title {}
.bf-artist__em { color: var(--wp--preset--color--lime); font-style: italic; }
.bf-artist__body {
  font-size: .84rem;
  font-weight: 200;
  line-height: 1.7;
  color: rgba(248,246,241,.6);
  max-width: 400px;
}
.bf-artist__socials {
  display: flex;
  gap: .75rem;
}
.bf-artist__socials a {
  width: 36px;
  height: 36px;
  border: 1px solid rgba(255, 255, 255, .12);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: rgba(248, 246, 241, .6);
  transition: border-color .2s, color .2s;
}
.bf-artist__socials a:hover {
  border-color: var(--wp--preset--color--lime);
  color: var(--wp--preset--color--lime);
}
</style>
',
];
