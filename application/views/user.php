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