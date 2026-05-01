<?php
/**
 * Pattern: FAQ Accordion
 *
 * @package Bomflor
 */
return [
    'title'       => __( 'FAQ Accordion', 'bomflor' ),
    'description' => __( 'Warm paper background. Accessible details/summary FAQ accordion.', 'bomflor' ),
    'categories'  => [ 'bomflor' ],
    'content'     => '
<section class="bf-section bf-section--warm">
  <div class="bf-container">
    <div class="bf-faq-header">
      <div class="bf-eyebrow">
        <span class="bf-eyebrow-line"></span>
        <span class="bf-eyebrow-text">Preguntas frecuentes</span>
      </div>
      <h2 class="bf-heading-display bf-faq-heading">¿Tienes dudas?</h2>
    </div>

    <div class="bf-faq-list">
      <details class="bf-faq-item">
        <summary>
          ¿En cuánto tiempo entregan?
          <span class="bf-faq-chevron"><i data-lucide="chevron-down" width="18" height="18"></i></span>
        </summary>
        <div class="bf-faq-item__answer">
          Realizamos entregas en 2 horas en toda la ciudad de Quito. Para pedidos fuera de la ciudad comunícate por WhatsApp para coordinar.
        </div>
      </details>

      <details class="bf-faq-item">
        <summary>
          ¿Puedo personalizar el arreglo?
          <span class="bf-faq-chevron"><i data-lucide="chevron-down" width="18" height="18"></i></span>
        </summary>
        <div class="bf-faq-item__answer">
          Sí. Puedes indicar colores, flores preferidas, tamaño y presupuesto. Escríbenos por WhatsApp y con gusto te asesoramos.
        </div>
      </details>

      <details class="bf-faq-item">
        <summary>
          ¿Cuáles son los métodos de pago?
          <span class="bf-faq-chevron"><i data-lucide="chevron-down" width="18" height="18"></i></span>
        </summary>
        <div class="bf-faq-item__answer">
          Aceptamos tarjetas de crédito y débito, transferencia bancaria, Deuna, y pago en efectivo contra entrega.
        </div>
      </details>

      <details class="bf-faq-item">
        <summary>
          ¿Trabajan los domingos y feriados?
          <span class="bf-faq-chevron"><i data-lucide="chevron-down" width="18" height="18"></i></span>
        </summary>
        <div class="bf-faq-item__answer">
          Sí. Atendemos lunes a sábado de 8h a 20h y domingos de 9h a 17h. En fechas especiales (San Valentín, Día de la Madre) ampliamos nuestro horario.
        </div>
      </details>

      <details class="bf-faq-item">
        <summary>
          ¿Incluyen tarjeta con mensaje?
          <span class="bf-faq-chevron"><i data-lucide="chevron-down" width="18" height="18"></i></span>
        </summary>
        <div class="bf-faq-item__answer">
          Sí, todos los pedidos incluyen una tarjeta impresa con tu mensaje personalizado sin costo adicional.
        </div>
      </details>

      <details class="bf-faq-item">
        <summary>
          ¿Hacen entregas a domicilio fuera de Quito?
          <span class="bf-faq-chevron"><i data-lucide="chevron-down" width="18" height="18"></i></span>
        </summary>
        <div class="bf-faq-item__answer">
          Actualmente nos especializamos en entregas dentro de Quito. Para otras ciudades te recomendamos contactarnos para analizar opciones.
        </div>
      </details>
    </div>
  </div>
</section>

<style>
.bf-faq-header { margin-bottom: 2rem; }
.bf-faq-heading {}
.bf-faq-list { max-width: 780px; }
</style>
',
];
