<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="<?= base_url('assets/js/jq/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/jq/jquery.animate-colors-min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/js/ajaxRequest.js'); ?>"></script>

    <!-- For table to accept or not accept users in the group -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
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
                        <li><a href="<?= $is_home ?>"><?= strtoupper($this->lang->line('home')); ?></a></li>
                        <li class="requires-login"><a href="#" class="ajax-link"><?= strtoupper($this->lang->line('eventsName')); ?></a></li>
                        <?php if ($this->session->userdata('groups') && $this->session->userdata('rol') == 'admin') { ?>
                        <li class="requires-login"><a href="#" class="ajax-link"><?= strtoupper($this->lang->line('createEvents')); ?></a></li>
                        <?php } ?>
                        <li class="requires-login"><a href="#" class="ajax-link"><?= strtoupper($this->lang->line('songs')); ?></a></li>
                        <?php if ($this->session->userdata('groups') && $this->session->userdata('rol') == 'admin') { ?>
                        <li class="requires-login"><a href="#" class="ajax-link"><?= strtoupper($this->lang->line('createSongs')); ?></a></li>
                        <li class="requires-login"><a href="#" class="ajax-link"><?= strtoupper($this->lang->line('groupUsers')); ?></a></li>
                        <li class="requires-login"><a href="#" class="ajax-link"><?= strtoupper($this->lang->line('groupNewUsers')); ?></a></li>
                        <?php } ?>

                        <?php if ($this->session->userdata('is_logged_in')) { 
                            $is_logged = site_url('Auth/configuration');
                         } ?>
                        <li id="usuarioMenu"><a href="<?= $is_logged; ?>" class="ajax-link"><?= strtoupper($this->lang->line('user')); ?></a></li>
                        <li><a href="<?= site_url('Dashboard/infoWeb'); ?>" class="ajax-link"><?= strtoupper($this->lang->line('infoWeb')); ?></a></li>
                    </ul>
                </nav>
            </div>
        </div>


        <!-- Logo -->
        <div id="logoGeneral">
            <div class="logo logoHide" id="principalLogo">
                <a href="<?= $is_home ?>"><img src="<?= base_url('assets/img/icon/evLogo.svg'); ?>" alt="Icono EV" class="iconEv"></a>
            </div>
        </div>


        <!-- user/Login -->
        <div id="login">
                <div>
                    <div class="logo principalLogoHide">
                        <a href="<?= $is_home ?>"><img src="<?= base_url('assets/img/icon/evLogo.svg'); ?>" alt="Icono EV" class="iconEv"></a>
                    </div>
                    <div class="logo hide" id="titleLetter">
                        <a href="<?= $is_home ?>"><?= strtoupper($this->lang->line('title')); ?></a>
                    </div>
                </div>
            <?php if($this->session->userdata('img_user')) { ?>
                <div>
                    <!-- IDEA PARA MOSTRAR CREAR GRUPOS, CUANDO PINCHE ARRIBA EN LA FOTO DEL GRUPO, QUE SALGA EL DESPLEGABLE PARA: CONFIGURATION Y CREATE A GROUP Y JOIN A GROUP -->
                    <img id="configGroupImg" class="userImage" src="<?= $this->session->has_userdata('groups') ? base_url('uploads/group_img/') . $this->session->userdata('groups')[$this->session->userdata('actual_group')]['img'] : base_url('assets/img/img/default_group.webp') ?>" alt="user image">
                    <?php $imgUser = $this->session->userdata('img_user') == 'default_img' ? base_url('assets/img/img/default_img.webp') : base_url('uploads/user_img/') . $this->session->userdata('img_user'); ?>
                    <img id="confiUserImg" class="userImage" src="<?= $imgUser ?>" alt="user image">
                </div>
                
            <?php } else { ?>
                <a href="<?= $is_logged; ?>" id="not_login">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path
                            d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                    </svg>
                </a>
            <?php } ?>
        </div>

        <div id="configUser">
            <p>
                <a href="<?= site_url('Auth/configuration'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                    <?= $this->lang->line('config'); ?>
                </a>
            </p>
            <p>
                <a class="beCareful" href="<?= site_url('Auth/logOut'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                    <?= $this->lang->line('logOut'); ?>
                </a>
            </p>
        </div>

        <div id="configGroup">
            <?php if ($this->session->userdata('groups') && $this->session->userdata('rol') == 'admin') { ?>
            <p>
                <a href="<?= site_url('Auth/configuration'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg>
                    <?= $this->lang->line('config'); ?>
                </a>
            </p>
            <?php } ?>
            <p>
                <a href="<?= site_url('Groups/createGroup'); ?>">
                    <?= $this->lang->line('createGroup'); ?>
                </a>
            </p>
            <p>
                <a href="<?= site_url('Groups/joinGroup'); ?>">
                    <?= $this->lang->line('joinGroup'); ?>
                </a>
            </p>
            <?php if ($this->session->userdata('groups')) { ?>
            <p>
                <a id="exitGroupMenu" class="beCareful" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg>
                    <?= $this->lang->line('exitActualGroup'); ?>
                </a>
            </p>
            <?php } ?>
        </div>
    </header>

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
                <a href="<?= site_url('Auth/signIn') ?>" class="btn-custom success">
                    <?= $this->lang->line('signIn'); ?>
                </a>
                <a href="<?= site_url('Auth/login') ?>" class="btn-custom primary">
                    <?= $this->lang->line('logIn'); ?>
                </a>
            </div>
        </div>
    </div>

    <div id="succesSignIn" class="custom-modal">
        <div class="custom-modal-content-signIn">
        <span class="custom-close-signIn">&times;</span>
            <h3>
                <?= $this->lang->line('warningModalTitle'); ?>
            </h3>
            <p>
                <?= $this->session->flashdata('successSignIn') ?>
            </p>
        </div>
    </div>

    <div id="globalModal" class="custom-modal">
        <div class="custom-modal-content-global">
        <span class="custom-close-global">&times;</span>
            <h3>
                <?= $this->lang->line('warningModalTitle'); ?>
            </h3>
            <p>
                <?= $this->session->flashdata('globalModal') ?>
            </p>
        </div>
    </div>

    <!-- Salirse de un grupo -->
    <div id="exitGroup" class="custom-modal">
        <div class="custom-modal-content-global">
        <span class="custom-close-global">&times;</span>
            <h3>
                <?= $this->lang->line('warningModalTitle'); ?>
            </h3>
            <p>
                <?= $this->lang->line('messageExitGroup'); ?>
            </p>

            <div style="text-align: right;">
                <a id="btnDeleteUserGroup" href="<?= site_url('Groups/exitActualGroup') ?>" class="btn-custom danger">
                    <?= $this->lang->line('exit'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal por si no está en ningún grupo  -->
    <div id="joinCreateModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <h3>
                <?= $this->lang->line('warningModalTitle'); ?>
            </h3>
            <p>
                <?= $this->lang->line('joinCreateGroup'); ?>
            </p>
        </div>
    </div>

    <!--Hacemos el main o cuerpo-->
    <main id="principalMenu">