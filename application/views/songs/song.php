<!-- <div id="addStructure" class="custom-modal">
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
</div> -->

<div id="cancelarAcorde" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>
        <h3>
            <?= $this->lang->line('deleteChord'); ?>
        </h3>

        <div style="text-align: right;">
            <a href="#" class="btn-custom success cancelar">
                <?= $this->lang->line('cancel'); ?>
            </a>
            <a href="#" class="btn-custom danger confirmarEliminar">
                <?= $this->lang->line('delete'); ?>
            </a>
        </div>
    </div>
</div>

<div id="toneModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>
        <h3>
            <?= $this->lang->line('tone'); ?>
        </h3>

        <div id="tonesFlex">
            <?php foreach ($tones_chords as $tone) { ?>
                <?php if ($song['tonalidad_id'] == $tone['tonalidad_id']) { ?>
                    <p data-id="<?= $tone['tonalidad_id']; ?>" style="background-color: #FF7300; color: #303030;">
                        <?= $tone['tonalidad_nombre']; ?>
                    </p>
                <?php } else { ?>
                    <p data-id="<?= $tone['tonalidad_id']; ?>">
                        <?= $tone['tonalidad_nombre']; ?>
                    </p>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

<div id="chordModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-close">&times;</span>
        <h3>
            <?= $this->lang->line('chords'); ?>
        </h3>
        <div id="chordsFlex">
            <?php foreach ($tones_chords[$song['tonalidad_id']]['acordes'] as $chords) { ?>
                <p data-id="<?= $chords['grado']; ?>">
                    <?= $chords['acorde_nombre']; ?>
                </p>
            <?php } ?>
        </div>
    </div>
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
        <div data-id="<?= $song['tonalidad_id'] ?>" id="tonoCancion">
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
        <?php foreach ($chordsAndLetters as $fila) { ?>
            <div class="impar">
                <?php foreach ($fila['acordes'] as $acorde) {
                    $nombreAcorde = null;
                    $array = $this->session->userdata('tonalidades_acordes')[$song['tonalidad_id']]['acordes'];
                    foreach ($array as $acordes) {
                        if ($acordes['grado'] == $acorde['grado']) {
                            $nombreAcorde = $acordes['acorde_nombre'];
                            break;
                        }
                    }
                    ?>
                    <span class="chord-container" data-id="<?= $acorde['grado']; ?>"
                        style="position: absolute; transform: translate(-50%, 0); left: <?= $acorde['coordenada_x']; ?>px;">
                        <span>
                            <?= $nombreAcorde ?>
                        </span>
                    </span>
                <?php } ?>
            </div>
            <div class="par" contenteditable="true">
                <?= $fila['letra']; ?>
            </div>
        <?php } ?>
        <?php if ($this->session->userdata('is_logged_in') && ($this->session->userdata('rol') == 'admin' || $this->session->userdata('rol') == 'colaborador')) { ?>
            <div class="addPart">+</div>
        <?php } ?>
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
        <a href="#" class="btn-custom success confirmarAgregar" id="guardarCancion">
            <?= $this->lang->line('saveSong'); ?>
        </a>
    </div>
<?php } ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    const acordesPorTonalidad = <?= json_encode($tones_chords, JSON_UNESCAPED_UNICODE); ?>;

    $(function () {
        //cambiamos de tono
        $('#tonoCancion').on('click', function () {
            $('#toneModal').fadeIn();

        })

        $('#tonesFlex').on('click', 'p', function () {
            $('#tonesFlex p').css('background-color', '').css('color', '');
            $(this).css('background-color', '#FF7300').css('color', '#303030');

            const nuevaTonalidad = $(this).data('id')
            const nuevaTonalidadNombre = $(this).text()

            $('#tonoCancion').attr('data-id', nuevaTonalidad)
            $('#tonoCancion span').text(nuevaTonalidadNombre)

            const acordes = acordesPorTonalidad[nuevaTonalidad]?.acordes || [];
            const $chordsFlex = $('#chordsFlex');
            $chordsFlex.empty(); // limpiar acordes anteriores

            acordes.forEach(acorde => {
                const $p = $('<p>').attr('data-id', acorde.grado).text(acorde.acorde_nombre);
                $chordsFlex.append($p);
            });

            transponerAcordes(nuevaTonalidad);
            $('#toneModal').fadeOut();
        })

        // Cerrar el modal al hacer clic en el botón de cierre
        $('.custom-close').on('click', function () {
            $('#toneModal').fadeOut();
            $('#chordModal').fadeOut();
        });

        // Cerrar el modal al hacer clic fuera del contenido
        $(window).on('click', function (e) {
            if ($(e.target).is('#toneModal')) {
                $('#toneModal').fadeOut();
            }

            if ($(e.target).is('#chordModal')) {
                $('#chordModal').fadeOut();
            }
        });

        $('#toneModal').on('change', function () {
            const tonalidadId = $(this).val()
            const acordes = acordesPorTonalidad[tonalidadId]?.acordes || []
            const chordsFlex = $('#chordsFlex')
        })


        let $currentImpar = null;
        let chordPosX = 0;

        //clicamos y nos sale una modal para poner acordes de está tonalidad
        $('#cancionLetraAcordes').on('click', '.impar', function (e) {
            e.stopPropagation()
            $currentImpar = $(this);
            $currentImpar.css('position', 'relative');

            // Calculamos la posición relativa al .impar clicado
            const offset = $(this).offset();
            chordPosX = e.pageX - offset.left;

            $('#chordModal').fadeIn();

        })

        $('#chordsFlex').off('click').on('click', 'p', function () {
            if (!$currentImpar) return;

            const acordeNombre = $(this).text();
            const acordeGrado = $(this).data('id');

            const $chord = $('<span class="chord-container" data-id="' + acordeGrado + '"><span>' + acordeNombre + '</span></span>');
            $chord.css({
                position: 'absolute',
                transform: 'translate(-50%, 0)',
                left: chordPosX + 'px',
                zIndex: 10
            });

            $currentImpar.append($chord);

            $('#chordModal').fadeOut();
            $currentImpar = null; // Reseteamos para la próxima vez
        });

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
                    $('.par').css('border', 'none');
                    const addPartDiv = $('.addPart').detach();

                    const pdf = new jsPDF('p', 'pt', 'letter');
                    const element = document.getElementById('songPdf');
                    const tonoCancion = $('#tonoCancion span').text().trim();
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

                        $('#songPdf').append(addPartDiv);
                        $('.par').css('border', 'solid 1px');
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
        $('.addPart').on('click', function (e) {
            if (e.target === this) {
                const divImpar = $('<div class="impar"></div>');
                const divPar = $('<div class="par" contenteditable="true"></div>');
                $(this).before(divImpar, divPar);
                currentParDiv = divPar;

                createdImpar = divImpar;
                createdPar = divPar;
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
        // $('#cancionLetraAcordes').on('click', 'span.structure', function (e) {
        //     e.stopPropagation();
        //     const span = $(this);
        //     currentParDiv = span.parent(); // div.par
        //     const existingText = span.text();
        //     openModal(existingText);
        // });

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

        // function openModal(text) {
        //     $('input[name="structureSong"]').val(text);
        //     $('#addStructure').fadeIn();
        // }

        // $('.custom-close, .cancelar').on('click', function (e) {
        //     e.preventDefault();
        //     $('#addStructure').fadeOut();

        //     const texto = $('input[name="structureSong"]').val().trim();
        //     if (texto === '' && createdImpar && createdPar) {
        //         createdImpar.remove();
        //         createdPar.remove();
        //     }

        //     createdImpar = null;
        //     createdPar = null;
        // });

        // $('.confirmarAgregar').on('click', function (e) {
        //     e.preventDefault();
        //     const texto = $('input[name="structureSong"]').val().trim();

        //     if (texto !== '' && currentParDiv) {
        //         currentParDiv.html('<span class="structure" contenteditable="false">' + texto + '</span>');
        //     } else if (texto === '' && createdImpar && createdPar) {
        //         createdImpar.remove();
        //         createdPar.remove();
        //     }

        //     $('#addStructure').fadeOut();
        //     createdImpar = null;
        //     createdPar = null;
        // });

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

        function transponerAcordes(nuevaTonalidadId) {
            // Obtener acordes de la nueva tonalidad
            const nuevosAcordes = acordesPorTonalidad[nuevaTonalidadId]?.acordes || [];

            // Crear un mapa grado -> nombre acorde para la nueva tonalidad
            const mapaGrados = {};
            nuevosAcordes.forEach(acorde => {
                mapaGrados[acorde.grado] = acorde.acorde_nombre;
            });

            // Recorrer todos los spans con clase chord-container dentro de #cancionLetraAcordes
            $('#cancionLetraAcordes').find('.chord-container').each(function () {
                const grado = $(this).data('id'); // obtener el grado del acorde actual
                const nuevoNombre = mapaGrados[grado];

                if (nuevoNombre) {
                    // Cambiar el texto del acorde al nuevo acorde transpuesto
                    $(this).find('span').text(nuevoNombre);
                }
            });
        }

        //insertamos los acordes y letras en la base de datos
        $('#guardarCancion').on('click', function (e) {
            e.preventDefault()

            const acordes = extraerAcordes()
            const letras = extraerLetras()
            const tonoCancion = $('#tonoCancion').data('id');

            $.ajax({
                url: '<?= site_url('Songs/insertChordsLetters') ?>',
                method: 'POST',
                data: {
                    cancion_id: <?= $song['cancion_id'] ?>,
                    nuevoTono: tonoCancion,
                    acordes: JSON.stringify(acordes),
                    letras: JSON.stringify(letras)
                },
                success: function (respuesta) {
                    console.log('Song Saved');
                },
                error: function () {
                    console.log('Error saving chords and letters');
                }
            })
            console.log(JSON.stringify(acordes) + '      ' + JSON.stringify(letras) + '      ' + cancionId)
        })

        function extraerAcordes() {
            const acordes = [];

            $('#cancionLetraAcordes .impar').each(function (lineaIndex) {
                $(this).find('.chord-container').each(function () {
                    const grado = $(this).data('id');
                    const posX = parseFloat($(this).css('left'));
                    const posY = lineaIndex;

                    acordes.push({
                        grado: grado,
                        coordenada_x: posX,
                        coordenada_y: posY
                    });
                });
            });

            return acordes;
        }

        function extraerLetras() {
            const letras = [];

            $('#cancionLetraAcordes .par').each(function (lineaIndex) {
                const letra_cancion = $(this).text().trim();
                const posY = lineaIndex;

                letras.push({
                    letra: letra_cancion,
                    coordenada_y: posY
                });
            });

            return letras;
        }

        //quitar algun acorde ya puesto
        let chordRemove = null
        $('#cancionLetraAcordes').on('click', '.chord-container', function (e) {
            e.stopPropagation()
            acordeAEliminar = $(this);
            $('#cancelarAcorde').fadeIn();
        });

        // Confirmar eliminación
        $('.confirmarEliminar').on('click', function (e) {
            e.preventDefault();
            if (acordeAEliminar) {
                acordeAEliminar.remove();
                acordeAEliminar = null;
            }
            $('#cancelarAcorde').fadeOut();
        });

        // Cancelar eliminación
        $('.cancelar').on('click', function (e) {
            e.preventDefault();
            acordeAEliminar = null;
            $('#cancelarAcorde').fadeOut();
        });

        $('.custom-modal-content').on('click', function () {
            $('#cancelarAcorde').fadeOut();
        });

        // Cerrar el modal al hacer clic fuera del contenido
        $(window).on('click', function (e) {
            if ($(e.target).is('#cancelarAcorde')) {
                $('#cancelarAcorde').fadeOut();
            }
        });
    });
</script>