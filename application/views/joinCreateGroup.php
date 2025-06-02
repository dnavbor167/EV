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

<div id="groupSelection">
	<div class="principalElementsGroups">
		<div class="joinCreateGroup">
			<a href="#">
				<?= strtoupper($this->lang->line('joinGroup')); ?>
			</a>
		</div>

	</div>
	<div class="principalElementsGroups">
		<div class="joinCreateGroup">
			<a href="<?= site_url('Groups/createGroup') ?>" class="ajax-link">
				<?= strtoupper($this->lang->line('createGroup')); ?>
			</a>
		</div>

	</div>
</div>

<script>
	//Si no está en ningún grupo bloquear todas las funciones
	<?php if (empty($this->session->userdata('groups'))): ?>
		// Mostrar modal al hacer clic en enlaces que requieren login
		$('.requires-login').on('click', function (e) {
			e.preventDefault();
			$('#joinCreateModal').fadeIn();
		});

		// Cerrar el modal al hacer clic en el botón de cierre
		$('.custom-close').on('click', function () {
			$('#joinCreateModal').fadeOut();
		});

		// Cerrar el modal al hacer clic fuera del contenido
		$(window).on('click', function (e) {
			if ($(e.target).is('#joinCreateModal')) {
				$('#joinCreateModal').fadeOut();
			}
		});
	<?php endif; ?>
</script>