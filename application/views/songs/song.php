<div id="addStructure" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>
        <h3>
            <?= $this->lang->line('addStructure'); ?>
        </h3>
        <p>
            <?= $this->lang->line('addStructureText'); ?>
        </p>

        <input type="text" name="structureSong">
        <div style="text-align: right;">
            <a href="#" class="btn-custom danger cancelar">
                <?= $this->lang->line('cancel'); ?>
            </a>
            <a href="#" class="btn-custom success confirmarAgregar">
                <?= $this->lang->line('accept'); ?>
            </a>
        </div>
    </div>
</div>

<div id="songPdf">
    <div id="headerSong">
        <div>
            <?= $song['genero']; ?>
        </div>
        <div>
            <?= $song['titulo']; ?>
        </div>
        <div>Nº
            <?= $song['numero']; ?>
        </div>
    </div>
    <div id="infoSong">
        <div data-id="<?= $song['tonalidad_id'] ?>">
            <?= $this->lang->line('tone'); ?>: <span>
                <?= $tono; ?>
            </span>
        </div>
        <div>
            <?= $this->lang->line('tempoSong'); ?>: <span>
                <?= $song['tempo']; ?>Bpm
            </span>
        </div>
        <div>
            <?= $this->lang->line('compass'); ?>: <span>
                <?= $song['compas']; ?>
            </span>
        </div>
    </div>

    <div id="cancionLetraAcordes">
        <div class="impar">ey </div>
        <div class="par"><span class="structure">Coro:</span> TÚ FUISTE EL VERBO EN EL PRINCIPIO, UNIGÉNITO DE DIOS </div>
        <div class="impar">ey </div>
        <div class="par">TÚ FUISTE EL VERBO EN EL PRINCIPIO, UNIGÉNITO DE DIOS, </div>
        <div class="impar">ey </div>
        <div class="par">TÚ FUISTE EL VERBO EN EL PRINCIPIO, UNIGÉNITO DE DIOS </div>
        <div class="impar">ey </div>
        <div class="par">CUÁN HERMOSO SU NOMBRE ES, NADA SE IGUALA A ÉL, CUÁN HERMOSO SU NOMBRE ES, </div>
    </div>

    <div id="footerSong">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                <path
                    d="M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z" />
            </svg>
        </div>

        <div id="footerSongLogo">
            <img src="<?= base_url('assets/img/icon/evLogo.svg'); ?>" alt="Icono EV" class="iconEv">
            <p>
                <?= strtoupper($this->lang->line('title')); ?>
            </p>
        </div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3">
                <path
                    d="M120-120v-200h80v120h120v80H120Zm520 0v-80h120v-120h80v200H640ZM120-640v-200h200v80H200v120h-80Zm640 0v-120H640v-80h200v200h-80Z" />
            </svg>
        </div>

    </div>
</div>

<script>
    $(function () {
        $(function () {
            let currentParDiv = null;
            let createdImpar = null;
            let createdPar = null;

            $('#cancionLetraAcordes').on('click', '.impar, .par', function (e) {
                e.stopPropagation();
            });


            // Clic directo en el fondo (sin que sea un hijo)
            $('#cancionLetraAcordes').on('click', function (e) {
                if (e.target === this) {
                    const divImpar = $('<div class="impar"></div>');
                    const divPar = $('<div class="par" contenteditable="true"></div>');
                    $('#cancionLetraAcordes').append(divImpar, divPar);
                    currentParDiv = divPar;

                    createdImpar = divImpar;
                    createdPar = divPar;
                    openModal('');
                }
            });

            // Enter en div.par crea nuevos divs e inicia modal
            $('#cancionLetraAcordes').on('keydown', '.par', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const divImpar = $('<div class="impar"></div>');
                    const divPar = $('<div class="par" contenteditable="true"></div>');
                    $(this).after(divImpar, divPar);

                    currentParDiv = divPar;
                    createdImpar = divImpar;
                    createdPar = divPar;

                    // Enfocar el nuevo div impar para empezar a escribir
                    divPar.focus();
                }
            });

            // Solo clic en el span.structure dentro de .par abre modal
            $('#cancionLetraAcordes').on('click', 'span.structure', function (e) {
                e.stopPropagation();
                const span = $(this);
                currentParDiv = span.parent(); // div.par
                const existingText = span.text();
                openModal(existingText);
            });

            //Hacemos que cuando clique en un elemento pueda editarlo de clase par
            $('#cancionLetraAcordes').on('click', '.par', function (e) {
                $(this).attr('contenteditable', 'true').focus()
            });

            $('#cancionLetraAcordes').on('dblclick', '.impar', function (e) {
                e.stopPropagation();
                const divImpar = $(this);
                const divPar = divImpar.next('.par');
                if (divPar.length) {
                    divPar.remove();
                }
                divImpar.remove();
            });

            function openModal(text) {
                $('input[name="structureSong"]').val(text);
                $('#addStructure').fadeIn();
            }

            $('.custom-close, .cancelar').on('click', function (e) {
                e.preventDefault();
                $('#addStructure').fadeOut();

                const texto = $('input[name="structureSong"]').val().trim();
                if (texto === '' && createdImpar && createdPar) {
                    createdImpar.remove();
                    createdPar.remove();
                }

                createdImpar = null;
                createdPar = null;
            });

            $('.confirmarAgregar').on('click', function (e) {
                e.preventDefault();
                const texto = $('input[name="structureSong"]').val().trim();

                if (texto !== '' && currentParDiv) {
                    currentParDiv.html('<span class="structure" contenteditable="false">' + texto + '</span>');
                } else if (texto === '' && createdImpar && createdPar) {
                    createdImpar.remove();
                    createdPar.remove();
                }

                $('#addStructure').fadeOut();
                createdImpar = null;
                createdPar = null;
            });
        });
    })

</script>