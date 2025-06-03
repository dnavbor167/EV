<div class="plans-container">

    <article class="plan-card plan-free" aria-label="Plan Free limitado" data-id="free">
        <h2 class="plan-header">Free (limitado)</h2>
        <div class="plan-price">Gratis <small>para siempre</small></div>
        <ul class="features-list">
            <li>1 grupo</li>
            <li>Hasta 3 miembros</li>
            <li>Hasta 5 canciones (mensuales)</li>
            <li>Sin opción de transposición automática</li>
            <li>Sin descargas en PDF</li>
        </ul>
        <button class="btn-select" aria-label="Seleccionar plan Free">Seleccionar</button>
    </article>

    <article class="plan-card plan-pro" aria-label="Plan Pro" data-id="pro">
        <h2 class="plan-header">Pro</h2>
        <div class="plan-price">9,99€ <small>al mes</small></div>
        <div class="plan-price" style="font-size:1rem; margin-bottom:10px;">o 99,99€ al año</div>
        <ul class="features-list">
            <li>1 grupo</li>
            <li>Hasta 20 miembros</li>
            <li>Hasta 20 canciones por mes</li>
            <li>Transposición automática de tonalidades</li>
            <li>Descarga de canciones en PDF</li>
            <li>Gestión de roles (admin, colaborador, normal)</li>
        </ul>
        <div class="price-details">
            0.5€ por miembro adicional<br />
            0.5€ por canción adicional
        </div>
        <button class="btn-select" aria-label="Seleccionar plan Pro">Seleccionar</button>
    </article>

    <article class="plan-card plan-premium" aria-label="Plan Premium" data-id="premium">
        <h2 class="plan-header">Premium</h2>
        <div class="plan-price">19,99€ <small>al mes</small></div>
        <div class="plan-price" style="font-size:1rem; margin-bottom:10px;">o 199,99€ al año</div>
        <ul class="features-list">
            <li>1 grupo</li>
            <li>Hasta 50 miembros</li>
            <li>Hasta 100 canciones por mes</li>
            <li>Transposición automática</li>
            <li>Descargas de canciones en PDF</li>
        </ul>
        <div class="price-details">
            0.4€ por miembro adicional<br />
            0.4€ por canción adicional
        </div>
        <button class="btn-select" aria-label="Seleccionar plan Premium">Seleccionar</button>
    </article>

</div>


<script>
    $('.plan-card, .btn-select').on('click', function () {
        const planId = $(this).closest('.plan-card').data('id')

        $.ajax({
            url: '<?= base_url("Groups/paymentsPlans/") ?>' + planId,
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                if (response.success && response.url) {
                    window.location.href = response.url;
                } else {
                    alert(response.message || '<?= $this->lang->line('errorInitPayment'); ?>');
                }
            },
            error: function () {
                alert('<?= $this->lang->line('errorConexion'); ?>');
            }
        });
    })
</script>