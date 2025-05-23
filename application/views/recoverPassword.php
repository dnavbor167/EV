<div id="logInMain">
  <?php
  $attributes = array('id' => 'loginForm', 'class' => 'logSigin', 'method' => 'post');
  echo form_open('DashBoard/recoverPassword', $attributes);
  ?>
  <p>
    <?= $this->lang->line('logIn'); ?>
  </p>
  <input placeholder="<?= ucfirst($this->lang->line('email')); ?>" type="email" name="userEmail" id="userEmail"
    value="<?= set_value('userEmail'); ?>">
  <span class="error">
    <?= form_error('userEmail') ?>
  </span>

  <button type="submit" id="btnRecoverPass">
    <?= $this->lang->line('recoverPass'); ?>
  </button>

  <a href="<?= site_url('Dashboard/login') ?>" id="backToLogin" class="btn-back">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icon-back">
      <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
      <path
        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
    </svg>
  </a>
  <?= form_close(); ?>
</div>