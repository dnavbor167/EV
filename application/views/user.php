<div id="deleteModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-close">&times;</span>
            <h3>
                <?= $this->lang->line('warningModalTitle'); ?>
            </h3>
            <p>
                <?= $this->lang->line('askDeleteUser'); ?>
            </p>

            <div style="text-align: right;">
                <a href="#" class="btn-custom success delete-cancel">
                    <?= $this->lang->line('cancel'); ?>
                </a>
                <a href="<?= site_url('Auth/deleteUser') ?>" class="btn-custom danger">
                    <?= $this->lang->line('delete'); ?>
                </a>
            </div>
        </div>
</div>

<div class="form-container">
    <h2><?= $this->lang->line('editProfile'); ?></h2>
    <?php 
    $attributes = array('id' => 'configurationUser', 'class' => 'config', 'method' => 'post');
    echo form_open_multipart('Auth/configuration', $attributes); 
    ?>
        <div class="form-group">
            <label for="nameUserUpdate"><?= ucfirst($this->lang->line('name')); ?></label>
            <input type="text" id="nameUserUpdate" name="nameUserUpdate" class="form-input" value="<?= set_value('nameUserUpdate', $this->session->userdata('user_name')) ?>" required>
            <span class="error"><?= form_error('nameUserUpdate') ?></span>
        </div>

        <!-- Change the group -->
        <div class="form-group">
            <label for="selectAGroup"><?= ucfirst($this->lang->line('selectAGroup')); ?>:</label>
            <select id="selectAGroup" name="selectAGroup" class="form-select">
                <option value="" disabled selected><?= $this->lang->line('selectGroup') ?></option>
                <?php foreach ($this->session->userdata('groups') as $group) { ?>
                <option value="<?= $group['grupo_id']; ?>" <?= $this->session->userdata('actual_group') == $group['grupo_id'] ? 'selected' : '' ?>><?= $group['name'] ?></option>
                <?php } ?>
            </select>
            <span class="error"><?= form_error('selectAGroup') ?></span>
        </div>

        <div class="form-group" id="configurationPassUser">
            <label for="selectAGroup"><?= ucfirst($this->lang->line('password')); ?>:</label>
            <input placeholder="<?= ucfirst($this->lang->line('password')); ?>" type="password" name="userPassword" id="userPassword" class="form-input">    
            <div>
                <svg id="seePass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                <svg id="dontSeePass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"/></svg>
            </div>
        </div>

        <div class="form-group">
            <label for="language"><?= ucfirst($this->lang->line('language')); ?></label>
            <select id="language" name="language" class="form-select">
                <option value="1" <?= $this->session->userdata('language') == 1 ? 'selected' : '' ?>>🇪🇸 Español</option>
                <option value="2" <?= $this->session->userdata('language') == 2 ? 'selected' : '' ?>>🇬🇧 English</option>
            </select>
            <span class="error"><?= form_error('language') ?></span>
        </div>

        <div class="form-group">
            <label for="imagenUpdate" id="labelUpdatePhoto"><?= ucfirst($this->lang->line('profilePhoto')); ?>:</label>
            <input type="file" id="imagenUpdate" name="imagenUpdate" class="form-file" accept="image/*">
        </div>

        <?php if ($this->session->userdata('img_user')) { ?>
            <label for="imagenUpdate" class="current-image">
                <img src="<?= $imgUser; ?>" id="previewImg" alt="Imagen de usuario">
            </label>
            <div>
                <input type="checkbox" id="remove_image" name="remove_image" value="1">
                <label for="remove_image"><?= $this->lang->line('removeImage'); ?></label>
            </div>
        <?php } ?>

        <input type="submit" value="<?= $this->lang->line('saveChanges'); ?>" class="form-submit">
        <input type="submit" value="<?= $this->lang->line('deleteUser'); ?>" class="form-submit" id="deleteUser">

    <?= form_close(); ?>
</div>

<script>

    $('#imagenUpdate').on('change', function() {
        const file = this.files[0]
        if (!file) return;

        const reader = new FileReader()

        reader.onload = function(e) {
            $('#previewImg').attr('src', e.target.result);
        }

        reader.readAsDataURL(file);
    })

    $('#deleteUser').on('click', function(e) {
        e.preventDefault()
        $('#deleteModal').fadeIn();
    })

    // Cerrar el modal al hacer clic en el botón de cierre
    $('.custom-close, .delete-cancel').on('click', function () {
        $('#deleteModal').fadeOut();
    });

    // Cerrar el modal al hacer clic fuera del contenido
    $(window).on('click', function (e) {
        if ($(e.target).is('#deleteModal')) {
            $('#deleteModal').fadeOut();
        }
    });
</script>