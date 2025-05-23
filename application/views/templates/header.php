<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <script src="<?= base_url('assets/js/jq/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/jq/jquery.animate-colors-min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/script.js'); ?>"></script>
</head>

<body>
    <!--Hacemos el header (cabecera con menú)-->
    <header>
        <!--Menu-->
        <div>
            <div id="menu-desplegable">
                <img src="<?= base_url('assets/img/icon/menuAbierto.svg'); ?>" alt="Menu Abierto" id="openMenu">
                <nav>
                    <div>
                        <span id="closeMenu"> <img src="<?= base_url('assets/img/icon/menuCerrado.svg'); ?>" alt="Menu Cerrado">
                            MENU
                        </span>
                    </div>
                    <ul>
                        <?php 
                        $is_home = current_url() == site_url('DashBoard') ? '#' : site_url('Dashboard'); 
                        $is_logued = $this->session->userdata('is_logged_in') ? '#': site_url('Dashboard/login');
                        ?>
                        <li><a href="<?= $is_home ?>"><?= strtoupper($this->lang->line('home')); ?></a></li>
                        <li class="requires-login"><a href="#"><?= strtoupper($this->lang->line('eventsName')); ?></a></li>
                        <li class="requires-login"><a href="#"><?= strtoupper($this->lang->line('createEvents')); ?></a></li>
                        <li class="requires-login"><a href="#"><?= strtoupper($this->lang->line('createSongs')); ?></a></li>
                        <li class="requires-login"><a href="#"><?= strtoupper($this->lang->line('songs')); ?></a></li>

                        <li id="usuarioMenu"><a href="<?= $is_logued; ?>"><?= strtoupper($this->lang->line('user')); ?></a></li>
                        <li class="requires-login"><a href="#"><?= strtoupper($this->lang->line('infoWeb')); ?></a></li>
                    </ul>
                </nav>
            </div>
        </div>


        <!-- Logo -->
        <div id="logo">
            <img src="<?= base_url('assets/img/icon/evLogo.svg'); ?>" alt="Icono EV" class="iconEv">
        </div>

        <!-- user/Login -->
        <div id="login">
            <a href="<?= $is_logued; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path
                        d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                </svg>
            </a>
        </div>
    </header>


    <!--Hacemos el main o cuerpo-->
    <main id="principalMenu">

        <!-- Modal personalizado -->
        <div id="loginModal" class="custom-modal">
            <div class="custom-modal-content">
                <span class="custom-close">&times;</span>
                <h3>
                    <?= $this->lang->line('warningModalTitle'); ?>
                </h3>
                <p>
                    <?= $this->lang->line('warningModalText'); ?>
                </p>
                <div style="text-align: right;">
                    <a href="<?= base_url('registro') ?>" class="btn-custom success">
                        <?= $this->lang->line('signIn'); ?>
                    </a>
                    <a href="<?= base_url('Dashboard/login') ?>" class="btn-custom primary">
                        <?= $this->lang->line('logIn'); ?>
                    </a>
                </div>
            </div>
        </div>