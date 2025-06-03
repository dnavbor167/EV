<div id="logInMain" class="createJoinGroup">
  <?php
  $attributes = array('id' => 'signIn', 'class' => 'logSigin');
  echo form_open_multipart('Groups/createGroup', $attributes);
  ?>
  
  <p class="headerCreateJoinGrou"><?= $this->lang->line('createGroup'); ?></p>

  <a href="<?= site_url('Groups') ?>" class="btn-back ajax-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="icon-back">
      <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
      <path
        d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z" />
    </svg>
  </a>

  <input placeholder="<?= ucfirst($this->lang->line('userName')); ?>" type="text" name="userNameGroup" id="userNameGroup" value="<?= set_value('userNameGroup'); ?>">
  <span class="error errorGroup"><?= form_error('userNameGroup'); ?><?= $name_error; ?></span>
  
  <input placeholder="<?= ucfirst($this->lang->line('email')); ?>" type="email" name="groupEmail" id="groupEmail" value="<?= set_value('groupEmail'); ?>">
  <span class="error errorGroup"><?= form_error('groupEmail'); ?><?= $email_error; ?></span>
  
  <div>
    <input placeholder="<?= ucfirst($this->lang->line('password')); ?>" type="password" name="userPassword" id="userPassword">
    <div>
      <svg id="seePass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
      <svg id="dontSeePass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/></svg>
    </div>
  </div>
  <span class="error errorGroup"><?= form_error('groupPassword') ?></span>

  <label for="photo" class="photoFile"><?= $this->lang->line('inputFile') ?></label>
  <span class="error errorGroup"><?= $upload_error; ?></span>
  <input type="file" name="groupPhoto" id="photo">
  <span class="error errorGroup"><?= $photo_error ?></span>
  

  <div id="promotions-container">
    <input type="checkbox" name="groupPromotions" id="promotions" value="1" <?= set_value('groupPromotions') == 1 ? 'checked' : '' ?>>
    <label for="promotions" id="labelPromotions"><?= $this->lang->line('termsConditions'); ?></label>
  </div>
  <span class="error errorGroup"><?= form_error('groupPromotions') ?></span>

  <button id="btnCreateGroup" class="buttonOrange"><?= $this->lang->line('createAccount'); ?></button>

  <?= form_close(); ?>
</div>

<script>
  //colors when click a button
  $('.buttonOrange').on('mousedown', function() {
    $(this).css('background-color', '#C65900');
    $(this).css('color', '#303030');
  });

  $('.buttonOrange').on('mouseup mouseleave', function() {
      $(this).css('background-color', '#303030');
      $(this).css('color', '#FF7300');
  });
</script>