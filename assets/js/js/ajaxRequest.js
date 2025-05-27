$(function() {
    $(document).on('click', '.ajax-link', function(e) {
        console.log('clickeado', this)
        e.preventDefault()
        const url = $(this).attr('href') || $(this).data('href')

        if (url == '#' || !url) {
            return
        }
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                $('#principalMenu').html(data);
            },
            error: function () {
                $('#principalMenu').html('<p>Error al cargar el contenido. Intenta recargar la página.</p>');
            }
        })
    })
})