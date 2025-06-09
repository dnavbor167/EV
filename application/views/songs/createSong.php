<div id="logInMain">
  <?php
  $attributes = array('id' => 'signIn', 'class' => 'logSigin', 'method' => 'post');
  echo form_open_multipart('Songs/createSong', $attributes);
  ?>
  <p>
    <?= $this->lang->line('createSong'); ?>
  </p>
  <input placeholder="<?= ucfirst($this->lang->line('nameSong')); ?>" type="text" name="nameSong" id="nameSong"
    class="inputCreateSong" value="<?= set_value('nameSong'); ?>">
  <span class="error">
    <?= form_error('nameSong') ?>
  </span>


  <input placeholder="<?= ucfirst($this->lang->line('nameArtist')); ?>" type="text" name="nameArtist" id="nameArtist"
    class="inputCreateSong" value="<?= set_value('nameArtist'); ?>">
  <span class="error">
    <?= form_error('nameArtist') ?>
  </span>

  <input placeholder="<?= ucfirst($this->lang->line('compasSong')); ?>" type="text" name="compasSong" id="compasSong"
    class="inputCreateSong" value="<?= set_value('compasSong'); ?>" pattern="^\d+\/\d+$"
    title="<?= $this->lang->line('validFormatCompas'); ?>">
  <span class="error">
    <?= form_error('compasSong') ?>
  </span>

  <input placeholder="<?= ucfirst($this->lang->line('genderSong')); ?>" type="text" name="genderSong" id="genderSong"
    class="inputCreateSong" value="<?= set_value('genderSong'); ?>">
  <span class="error">
    <?= form_error('genderSong') ?>
  </span>

  <input placeholder="<?= ucfirst($this->lang->line('tempoSong')); ?>" type="number" name="tempoSong" id="tempoSong"
    class="inputCreateSong" value="<?= set_value('tempoSong'); ?>" min="0">
  <span class="error">
    <?= form_error('tempoSong') ?>
  </span>

  <input placeholder="<?= ucfirst($this->lang->line('numberSong')); ?>" type="number" name="numberSong" id="numberSong"
    class="inputCreateSong" value="<?= set_value('numberSong'); ?>" min="0">
  <span class="error">
    <?= form_error('numberSong') ?>
  </span>

  <div id="search-tone">
    <select id="buscador" name="tones_id" style="width: 100%;">
      <option value=""></option>
      <?php foreach ($tonalidades as $tonalidad) { ?>
        <option value="<?= $tonalidad['tonalidad_id'] ?>">
          <?= $tonalidad['nombre'] ?>
        </option>
      <?php } ?>
    </select>
  </div>
  <span class="error">
    <?= $error_tone ?>
  </span>

  <label for="photo" class="photoFile">
    <?= $this->lang->line('inputFile') ?>
  </label>
  <span class="error">
    <?= $upload_error; ?>
  </span>
  <input type="file" name="photo" id="photo">


  <div id="btnCrtSongContainer">
    <button id="btnCreateSong" class="buttonOrange">
      <?= $this->lang->line('createSong'); ?>
    </button>
  </div>


  <?= form_close(); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  //colors when click a button
  $('.buttonOrange').on('mousedown', function () {
    $(this).css('background-color', '#C65900');
  });

  $('.buttonOrange').on('mouseup mouseleave', function () {
    $(this).css('background-color', '#FF7300');
  });

  $('#buscador').select2({
    placeholder: "<?= $this->lang->line('tone'); ?>",
    allowClear: true,
    width: '100%'
  });
</script>