<div id="deleteUserModal" class="custom-modal">
	<div class="custom-modal-content">
		<span class="custom-close">&times;</span>
		<h3>
			<?= $this->lang->line('warningModalTitle'); ?>
		</h3>
		<p>
			<?= $this->lang->line('askDeleteUser'); ?>
		</p>
		<div style="text-align: right;">
			<a href="#" class="btn-custom success cancelar">
				<?= $this->lang->line('cancel'); ?>
			</a>
			<a href="#" class="btn-custom danger confirmarEliminar">
				<?= $this->lang->line('delete'); ?>
			</a>
		</div>
	</div>
</div>

<div class="tableUsers">
	<div class="table-responsive-wrapper">
		<table id="usersGroup" class="display" style="width: 100%; border: solid 1px gray;">
			<thead>
				<tr>
					<th>
						<?= $this->lang->line('nameAdmin'); ?>
					</th>
					<th>
						<?= ucfirst($this->lang->line('email')); ?>
					</th>
					<th>
						<?= $this->lang->line('rolAdmin'); ?>
					</th>
					<th>
						<?= $this->lang->line('actionsAdmin'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($usersGroup as $value) {
					$id_usuario = $value['usuario_id'];
					$nombre = $value['nombre'];
					$email = $value['email'];
					$rol = $value['rol'];
					?>
					<tr id="rowusersGroup<?php echo $id_usuario ?>">
						<td class="firstRowImg">
							<img class="imgUserGroup" src="<?= base_url('uploads/user_img/') . $value['img'] ?>"
								alt="imagen de usuario del grupo">
							<p><?= $nombre; ?></p>
						</td>
						<td>
							<?= $email; ?>
						</td>
						<td>
							<select name="rol_<?= $id_usuario ?>" id="rol_<?= $id_usuario ?>" class="selectRol">
								<option value="admin" <?= ($rol == 'admin') ? 'selected' : ''; ?>>
									<?= $this->lang->line('userAdmin'); ?>
								</option>
								<option value="colaborador" <?= ($rol == 'colaborador') ? 'selected' : ''; ?>>
									<?= $this->lang->line('userColaborador'); ?>
								</option>
								<option value="normal" <?= ($rol == 'normal') ? 'selected' : ''; ?>>
									<?= $this->lang->line('userNormal'); ?>
								</option>
							</select>
						</td>
						<td>
							<button id="<?php echo $nombre . "-" . $id_usuario ?>" name="btnEliminar"
								class="rechazar eliminar">
								<?= $this->lang->line('delete'); ?>
							</button>
						</td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(function () {
		const tabla = $('#usersGroup').DataTable({
			order: [[2, 'asc']],
			columnDefs: [
				{
					targets: [2], // columna de los selects
					orderable: true,
					render: function (data, type, row, meta) {
						if (type === 'sort') {
							// Tomamos el valor seleccionado del select
							const select = $(row[2]);
							return select.find('option:selected').text().toLowerCase();
						}
						return data;
					}
				}
			]
		});

		let idUsuarioSeleccionado = null;

		// Mostrar la modal
		$(".eliminar").on("click", function (e) {
			e.preventDefault();
			let parts = this.id.split("-");
			idUsuarioSeleccionado = parts[1];

			$("#deleteUserModal").fadeIn();
		});

		// Cancelar
		$(".cancelar, .custom-close").on("click", function (e) {
			e.preventDefault();
			$("#deleteUserModal").fadeOut();
			idUsuarioSeleccionado = null;
		});

		$(window).on('click', function (e) {
			if ($(e.target).is('#deleteUserModal')) {
				$('#deleteUserModal').fadeOut();
				idUsuarioSeleccionado = null;
			}
		});

		// Confirmar eliminación
		$(".confirmarEliminar").on("click", function (e) {
			e.preventDefault();

			if (!idUsuarioSeleccionado) return;

			$.ajax({
				url: "<?= site_url(); ?>AdminUsersGroup/deleteUsersFromGroup",
				type: "POST",
				data: {
					idUser: idUsuarioSeleccionado
				},
				dataType: "json",
				success: function (data) {
					if (data.success) {
						$("#rowusersGroup" + idUsuarioSeleccionado).fadeOut();
						tabla.row("#rowusersGroup" + idUsuarioSeleccionado).invalidate().draw();
					}
					$("#deleteUserModal").fadeOut();
					idUsuarioSeleccionado = null;
				}
			});
		});

		//Actualizamos rol
		$(".selectRol").on("change", function () {
			const idCompleto = $(this).attr("id");
			const idUser = idCompleto.split("_")[1];
			const newRol = $(this).val();

			$.ajax({
				url: "<?= site_url(); ?>AdminUsersGroup/updateUserRol",
				type: "POST",
				data: {
					idUser: idUser,
					newRol: newRol
				},
				dataType: "json",
				success: function (data) {
					if (data.success) {
						// Reordenar la tabla tras la actualización
						tabla.row("#rowusersGroup" + idUser).invalidate().draw();
					} else {
						alert("No se pudo actualizar el rol.");
					}
				}
			});
		});
	})
</script>