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

<div id="bocadillo-modal" class="bocadillo hidden">
    <div class="bocadillo-content">
    </div>
    <div class="bocadillo-arrow"></div>
</div>


<div id="songPdf">
    <div id="headerSong">
        <div>
            <?= $song['genero']; ?>
        </div>
        <div id="tituloCancion">
            <?= $song['titulo']; ?>
        </div>
        <div>Nº
            <?= $song['numero']; ?>
        </div>
    </div>
    <div id="infoSong">
        <div data-id="<?= $song['tonalidad_id'] ?>">
            <?= $this->lang->line('tone'); ?>: <span id="tonoCancion">
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
        <div class="par"><span class="structure">Coro:</span> TÚ FUISTE EL VERBO EN EL PRINCIPIO, UNIGÉNITO DE DIOS
        </div>
        <div class="impar">ey </div>
        <div class="par">TÚ FUISTE EL VERBO EN EL PRINCIPIO, UNIGÉNITO DE DIOS, </div>
        <div class="impar">ey </div>
        <div class="par">TÚ FUISTE EL VERBO EN EL PRINCIPIO, UNIGÉNITO DE DIOS </div>
        <div class="impar">ey </div>
        <div class="par">CUÁN HERMOSO SU NOMBRE ES, NADA SE IGUALA A ÉL, CUÁN HERMOSO SU NOMBRE ES, </div>
    </div>

    <div id="footerSong">
        <div>
            <svg id="downloadPdf" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                fill="#e3e3e3">
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
            <svg id="fullScreen" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                fill="#e3e3e3">
                <path
                    d="M120-120v-200h80v120h120v80H120Zm520 0v-80h120v-120h80v200H640ZM120-640v-200h200v80H200v120h-80Zm640 0v-120H640v-80h200v200h-80Z" />
            </svg>
        </div>

    </div>
</div>

<?php if ($this->session->userdata('is_logged_in') && ($this->session->userdata('rol') == 'admin' || $this->session->userdata('rol') == 'colaborador')) { ?>
    <div id="containerGuardarCancion">
        <a href="#" class="btn-custom success confirmarAgregar" id="guardarCanción">
            <?= $this->lang->line('saveSong'); ?>
        </a>
    </div>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>


    $(function () {
        //clicamos y nos sale una modal para poner acordes de está tonalidad
        $('.impar').on('click', function (e) {
            const modal = $('#bocadillo-modal');
            e.stopPropagation()
            const $this = $(this);
            $this.css('position', 'relative'); // Asegura que el contenedor sea relativo

            // Calculamos la posición relativa al .impar clicado
            const offset = $this.offset();
            const x = e.pageX - offset.left;
            const clickX = e.pageX;
            const clickY = e.pageY;

            modal.css({ visibility: 'hidden', display: 'block' });

            const modalHeight = modal.outerHeight();
            const arrowHeight = 10;
            let topPos = clickY - modalHeight - arrowHeight;
            const leftPos = clickX - modal.outerWidth() / 2;

            if (topPos < 0) {
                topPos = clickY + arrowHeight;
                modal.addClass('arrow-down');
            } else {
                modal.removeClass('arrow-down');
            }

            modal.css({
                position: 'absolute',
                top: topPos - 110 + 'px',
                left: leftPos + 'px',
                visibility: 'visible',
                display: 'block'
            }).removeClass('hidden');

            // Guardamos datos para usar después si quieres aplicar cambios
            window.posicionClick = { x: clickX, y: clickY };
            window.elementoClicado = $this;

            //LATER
            // const $ok = $('<span class="ok-container"><span>OK</span></span>');
            // $ok.css({
            //     position: 'absolute',
            //     transform: 'translate(-50%, 0)',
            //     left: x + 'px',
            //     zIndex: 10
            // });

            // $ok.find('span').css({
            //     background: 'green',
            //     color: 'white',
            //     padding: '2px 6px',
            //     borderRadius: '4px',
            //     fontSize: '12px',
            //     whiteSpace: 'nowrap'
            // });

            // $this.append($ok);

        })

        //Ocultar modal bocadillo$(document).on('click', function (e) {
        $(document).on('click', function (e) {
            console.log('hola')
            if (!$(e.target).closest('#bocadillo-modal, .impar').length) {
                console.log('aqui')
                $('#bocadillo-modal').addClass('hidden');
            }
        })


        //fullScreen
        let isFullscreen = false;

        $('#fullScreen').on('click', function () {
            const $songPdf = $('#songPdf');

            if (!isFullscreen) {
                $songPdf.addClass('fullscreen-active');
                $('body').css('overflow', 'hidden');

                $(this).find('path').attr('d', 'M120-280v-80h200v200h-80v-120H120Zm520 120v-200h200v80H720v120h-80ZM120-680v-80h120v-120h80v200H120Zm520-200h80v120h120v80H640v-200Z');
            } else {
                $songPdf.removeClass('fullscreen-active');
                $('body').css('overflow', '');

                $(this).find('path').attr('d', 'M120-120v-200h80v120h120v80H120Zm520 0v-80h120v-120h80v200H640ZM120-640v-200h200v80H200v120h-80Zm640 0v-120H640v-80h200v200h-80Z');
            }

            isFullscreen = !isFullscreen;
        });

        <?php if ($plan_actual != 1) { ?>
            //Para poder descargar en pdf
            const { jsPDF } = window.jspdf;

            $('#downloadPdf').on('click', function () {
                if (!isFullscreen) {
                    console.log('hola')
                    const pdf = new jsPDF('p', 'pt', 'letter');
                    const element = document.getElementById('songPdf');
                    const tonoCancion = document.getElementById('tonoCancion').textContent.trim();
                    const nombreCancion = document.getElementById('tituloCancion').textContent.trim();

                    html2canvas(element, { scale: 2 }).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const pageWidth = pdf.internal.pageSize.getWidth();
                        const pageHeight = pdf.internal.pageSize.getHeight();
                        const imgWidth = pageWidth; // ancho imagen igual al ancho de la página PDF
                        const imgHeight = canvas.height * imgWidth / canvas.width;
                        let heightLeft = imgHeight;
                        let position = 0;

                        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;

                        while (heightLeft > 0) {
                            position = heightLeft - imgHeight;
                            pdf.addPage();
                            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                            heightLeft -= pageHeight;
                        }

                        pdf.save(`${nombreCancion}-${tonoCancion}.pdf`);
                    });
                }
            })

        <?php } ?>

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

        //actualizamos el last_activity
        setInterval(function () {
            $.ajax({
                url: '<?= site_url('Songs/keep_alive'); ?>',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('error in ajax petition')
                }
            })
        }, 300000)
    });


</script>