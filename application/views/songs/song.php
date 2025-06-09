<div id="songPdf">
    <div id="headerSong">
        <div>Adoración</div>
        <div><?= $song['titulo']; ?></div>
        <div>Nº <?= $song['numeroCancion']; ?></div>
    </div>
    <div id="infoSong">
        <div>Tono: <span><?= $tono; ?></span></div>
        <div>Tempo: <span>131Bpm</span></div>
        <div>Compás: <span>6/8</span></div>
    </div>

    <div id="cancionLetraAcordes">
        <div id="estructuraCancion"></div>
        <div id="letrasAcordes">
        </div>

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