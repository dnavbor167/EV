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
                <img src="<?= base_url('uploads/' . $this->session->userdata('img_user')); ?>" alt="Imagen de usuario">
            </label>
            <div>
                <input type="checkbox" id="remove_image" name="remove_image" value="1">
                <label for="remove_image"><?= $this->lang->line('removeImage'); ?></label>
            </div>
        <?php } ?>

        <input type="submit" value="<?= $this->lang->line('saveChanges'); ?>" class="form-submit">

    <?= form_close(); ?>
</div>