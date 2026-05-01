<?php
/**
 * Pattern: Testimonials Page
 *
 * @package Bomflor
 */
return [
    'title'       => __( 'Testimonials Page', 'bomflor' ),
    'description' => __( 'All testimonials for the testimonios page.', 'bomflor' ),
    'categories'  => [ 'bomflor' ],
    'content'     => '
<section class="bf-section bf-section--white">
  <div class="bf-container">
    <div class="bf-testi-header">
      <div class="bf-eyebrow">
        <span class="bf-eyebrow-line"></span>
        <span class="bf-eyebrow-text">Opiniones reales</span>
      </div>
      <h2 class="bf-heading-display bf-testi-heading">Lo que dicen nuestros clientes</h2>
    </div>

    <div class="bf-testi-grid">
      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <p class="bf-testimonial-card__quote">&ldquo;Excelente servicio varios modelos de arreglos para escoger entrega a la hora solicitada el producto en excelentes condiciones precios accesibles total mente recomendado.&rdquo;</p>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Juan Carlos Erazo Varela
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <p class="bf-testimonial-card__quote">&ldquo;Excelente servicio de entrega de flores a domicilio! Muy recomendado para hacer pedidos desde el extranjero, tienen la opcion de pago con PayPal, lo que me facilito la transaccion. La felicidad de mi Mama no tiene precio!&rdquo;</p>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Mauricio Jaramillo
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <p class="bf-testimonial-card__quote">&ldquo;El servicio online es maravilloso. Yo que vivo en España hago los trámites con total comodidad. Rápido, efectivo y cercano. Se preocupan de que el cliente quede sstisfecho. Totalmente recomendable.&rdquo;</p>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Iñaki Martinez
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <div class="bf-testimonial-card__quote bf-testimonial-card__quote--long">
          <p>&ldquo;Es muy grato indicar el resultado de mi gestión al realizar las entregas de Bomflor:</p>
          <ul>
            <li>La actitud amable del Líder y de su equipo de trabajo es total</li>
            <li>Muy agradecido con la negociación justa con el valor de las entregas</li>
            <li>Pagos puntuales de las entregas</li>
            <li>Los clientes de Bomflor son selectos, lo que genera un trato amable hacia el transportista</li>
            <li>La confianza que transmite Bomflor, hace que genere un compromiso total</li>
            <li>La planificación que tiene Bomflor para las entregas, ayuda a cumplir el objetivo de una entrega inmediata</li>
            <li>Los arreglos florales de alto nivel, o sea, de calidad al ser únicos y exclusivos en sus diseños ayuda a que no se ha tenido reclamos, al contrario, recibo constantemente felicitaciones</li>
          </ul>
          <p>Definitivamente es una satisfacción trabajar con Bomflor y con sus clientes selectos&rdquo;</p>
        </div>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Santiago Villamar
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <p class="bf-testimonial-card__quote">&ldquo;Excelente servicio, entrega puntual y sus arreglos son actuales e innovadores. Recomendados&rdquo;</p>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Melissa Mera
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <p class="bf-testimonial-card__quote">&ldquo;Excelente servicio, la calidad de las flores es de primera. Responsables y puntuales a la hora de entrega acordada. Creatividad ilimitada en los arreglos. Tengo 3 años confiandoles mis fechas especiales. Altamente recomendados.&rdquo;</p>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Jennifer Borrego
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <div class="bf-testimonial-card__quote bf-testimonial-card__quote--long">
          <p>&ldquo;Vivir en el extranjero no es fácil, pero esta compañía me ha permitido mantenerme cerca de mis seres queridos incluso a la distancia! He sido cliente por más de 4 años y su servicio siempre ha sido excelente! La única recomendación es qué tal vez podrían ofrecer programas/descuentos a clientes leales de tanto tiempo ♥️&rdquo;</p>
        </div>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Nicole Araujo
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>

      <div class="bf-testimonial-card">
        <i data-lucide="quote" class="bf-testimonial-card__quote-icon" width="48" height="48"></i>
        <div class="bf-testimonial-card__stars">
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
          <i data-lucide="star" width="14" height="14"></i>
        </div>
        <div class="bf-testimonial-card__quote bf-testimonial-card__quote--long">
          <p>&ldquo;Solicité el servicio desde Estados Unidos vía WhatsApp. Fui atendida inmediatamente.</p>
          <p>El arreglo que escogí, además de ser muy bonito, fue entregado oportunamente en el lugar indicado en Quito.</p>
          <p>🌟El plus del servicio fue que hubo atención personalizada vía texto y además recibí una foto del momento que se realizó la entrega.</p>
          <p>Muchas gracias!&rdquo;</p>
        </div>
        <div class="bf-testimonial-card__author">
          <i data-lucide="user" width="14" height="14"></i>
          Joselyn Gavilanes
          <svg class="bf-google-review-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
        </div>
      </div>
    </div>

    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Florist",
      "name": "Bomflor",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "5",
        "reviewCount": "8"
      },
      "review": [
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Juan Carlos Erazo Varela"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Excelente servicio varios modelos de arreglos para escoger entrega a la hora solicitada el producto en excelentes condiciones precios accesibles total mente recomendado."
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Mauricio Jaramillo"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Excelente servicio de entrega de flores a domicilio! Muy recomendado para hacer pedidos desde el extranjero, tienen la opcion de pago con PayPal, lo que me facilito la transaccion. La felicidad de mi Mama no tiene precio!"
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Iñaki Martinez"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "El servicio online es maravilloso. Yo que vivo en España hago los trámites con total comodidad. Rápido, efectivo y cercano. Se preocupan de que el cliente quede sstisfecho. Totalmente recomendable."
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Santiago Villamar"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Es muy grato indicar el resultado de mi gestión la realizar las entregas de Bomflor: La actitud amable del Líder y de su equipo de trabajo es total. Definitivamente es una satisfacción trabajar con Bomflor y con sus clientes selectos."
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Melissa Mera"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Excelente servicio, entrega puntual y sus arreglos son actuales e innovadores. Recomendados"
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Jennifer Borrego"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Excelente servicio, la calidad de las flores es de primera. Responsables y puntuales a la hora de entrega acordada. Creatividad ilimitada en los arreglos. Tengo 3 años confiandoles mis fechas especiales. Altamente recomendados."
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Nicole Araujo"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Vivir en el extranjero no es fácil, pero esta compañía me ha permitido mantenerme cerca de mis seres queridos incluso a la distancia! He sido cliente por más de 4 años y su servicio siempre ha sido excelente! La única recomendación es qué tal vez podrían ofrecer programas/descuentos a clientes leales de tanto tiempo ♥️"
        },
        {
          "@type": "Review",
          "author": {
            "@type": "Person",
            "name": "Joselyn Gavilanes"
          },
          "reviewRating": {
            "@type": "Rating",
            "ratingValue": "5",
            "bestRating": "5"
          },
          "reviewBody": "Solicité el servicio desde Estados Unidos vía WhatsApp. Fui atendida inmediatamente. El arreglo que escogí, además de ser muy bonito, fue entregado oportunamente en el lugar indicado en Quito. 🌟El plus del servicio fue que hubo atención personalizada vía texto y además recibí una foto del momento que se realizó la entrega. Muchas gracias!"
        }
      ]
    }
    </script>
  </div>
</section>

<style>
.bf-testi-header { margin-bottom: 3.5rem; text-align: center; }
.bf-testi-header .bf-eyebrow { justify-content: center; }
.bf-testi-heading {}
.bf-testi-grid {
  column-count: 1;
  column-gap: 1.5rem;
}
@media (min-width: 768px) {
  .bf-testi-grid { column-count: 2; }
}
</style>
',
];

