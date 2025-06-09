<div id="songsList">
    <div id="buscadorSongs">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
            <path
                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
        </svg>
        <input type="search" placeholder="Buscar...">
    </div>

    <div class="song-item">
        <span id="addSong"><a href="<?= site_url('Songs/createSong') ?>">+</a></span>
    </div>

    <?php foreach ($songs as $song) { ?>
        <div class="song-item" data-id="<?= $song['cancion_id']; ?>" style="position: relative;">
            <img src="<?= $song['photo'] == 'fotoCancionPorDefecto' ? base_url('assets/img/img/fotoCancionPorDefecto.webp') : site_url('./uploads/songs_img/') . $song['photo']; ?>"
                alt="Foto por defecto">
            <div class="song-text" data-id="<?= $song['tonalidad_id']; ?>">
                <?= $song['titulo']; ?> - <strong>
                    <?= $song['nombre']; ?>
                </strong> <svg class="menu-trigger" xmlns="http://www.w3.org/2000/svg" height="24px"
                    viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                    <path
                        d="M480-160q-33 0-56.5-23.5T400-240q0-33 23.5-56.5T480-320q33 0 56.5 23.5T560-240q0 33-23.5 56.5T480-160Zm0-240q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm0-240q-33 0-56.5-23.5T400-720q0-33 23.5-56.5T480-800q33 0 56.5 23.5T560-720q0 33-23.5 56.5T480-640Z" />
                </svg>
                <div class="song-menu delete-song-menu">
                    <button class="delete-song" data-id="<?= $song['cancion_id']; ?>">
                        <?= $this->lang->line('delete'); ?>
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


<script>
    $(function () {
        $('#buscadorSongs input').on('input', function () {
            const search = $(this).val().toLowerCase();

            $('.song-item').each(function () {
                const text = $(this).text().toLocaleLowerCase();
                $(this).toggle(text.includes(search));
            });
        });

        $('.menu-trigger').on('click', function (e) {
            e.stopPropagation()

            $(this).siblings('.song-menu').show()
        })

        $(document).on('click', function () {
            $('.song-menu').hide();
        });

        $('.delete-song').on('click', function (e) {
            e.stopPropagation()
            const songId = $(this).data('id')
            const songItem = $(this).closest('.song-item');

            $.ajax({
                url: '<?= site_url('Songs/deleteSong'); ?>',
                method: 'POST',
                data: { song_id: songId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        songItem.fadeOut(300, function () {
                            $(this).remove();
                        });
                    } else {
                        console.log('error deliting')
                    }
                },
                error: function () {
                    console.log('error in ajax petition')
                }
            })
        })

        $('.song-item img, .song-item .song-text').on('click', function () {
            const songId = $(this).closest('.song-item').data('id')

            $.ajax({
                url: '<?= site_url('Songs/song'); ?>',
                method: 'POST',
                data: { song_id: songId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#principalMenu').html(response.html)
                    } else {
                        console.log('error accessing')
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('error in ajax petition')
                }
            })
        })


    })
</script>