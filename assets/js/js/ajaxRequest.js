$(function() {
    $('a.ajax-link').on('click', function(e) {
        e.preventDefault()
        const url = $(this).attr('href')

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