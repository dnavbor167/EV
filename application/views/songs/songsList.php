<div id="songsList">
    <div id="buscadorSongs">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
            <path
                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
        </svg>
        <input type="search" placeholder="Buscar...">
    </div>

    <div class="song-item" data-id="1">
        <span id="addSong"><a href="<?= site_url('Songs/createSong') ?>">+</a></span>
    </div>
    <div class="song-item" data-id="2">
        <img src="<?= base_url('assets/img/img/fotoCancionPorDefecto.webp'); ?>" alt="Foto por defecto">
        <p>Holy forever - <strong>Tonalidad</strong></p>
    </div>
    <div class="song-item" data-id="3">
        <img src="<?= base_url('assets/img/img/fotoCancionPorDefecto.webp'); ?>" alt="Foto por defecto">
        <p>In name of Jesus - <strong>Tonalidad</strong></p>
    </div>
</div>


<script>
    $(function () {
        $('#buscadorSongs input').on('input', function () {
            const search = $(this).val().toLowerCase();

            $('.song-item').each(function () {
                const p = $(this).find('p');

                if (p.length) {
                    const text = p.text().toLowerCase();
                    $(this).toggle(text.includes(search));
                } else {
                    $(this).show();
                }
            });
        });

        // $('#principalMenu').on('click', '#addSong', function () {
        //     $.ajax({
        //         url: '<?= site_url('Songs/createSongView') ?>',
        //         method: 'GET',
        //         dataType: 'html',
        //         success: function (data) {
        //             $('#principalMenu').html(data);
        //             $('#buscador').select2({
        //                 placeholder: "<?= $this->lang->line('nameArtist'); ?>",
        //                 allowClear: true,
        //                 width: '100%'
        //             });
        //         },
        //         error: function () {
        //             $('#principalMenu').html('<p>Error al cargar el contenido. Intenta recargar la página.</p>');
        //         }
        //     })
        // })
    })
</script>