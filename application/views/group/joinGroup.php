<div id="logInMain" class="createJoinGroup">
  <?php
  $attributes = array('id' => 'signIn', 'class' => 'logSigin');
  echo form_open('Groups/joinGroup', $attributes);
  ?>
  
  <p class="headerCreateJoinGrou"><?= $this->lang->line('joinGroup'); ?></p>

  <a href="<?= site_url('Groups') ?>" class="btn-back ajax-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icon-back">
      <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
      <path
        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
    </svg>
  </a>

  <div class="search-container">
    <select id="buscador" name="grupo_id" style="width: 100%;">
      <option value=""><?= $this->lang->line('selectAnOption'); ?></option>
      <?php foreach($groups as $group) {?>
        <option value="<?= $group['id'] ?>"><?= $group['name'] ?></option>
      <?php }?>
    </select>
  </div>
  <span class="error errorGroup"><?= $errorJoinSelect ?></span>

  <button id="btnCreateGroup" class="buttonOrange"><?= $this->lang->line('requestJoin'); ?></button>

  <?= form_close(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $('#buscador').select2({
    placeholder: "<?= $this->lang->line('searchGroup'); ?>",
    allowClear: true,
    width: '100%',
    allowClear: false
  });

</script>