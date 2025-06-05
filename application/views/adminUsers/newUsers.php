<div class="tableUsers">
	<div class="table-responsive-wrapper">
		<table id="newUsers" class="display" style="width: 100%; border: solid 1px gray;">
			<thead>
				<tr>
					<th>
						<?= $this->lang->line('nameAdmin'); ?>
					</th>
					<th>
						<?= ucfirst($this->lang->line('email')); ?>
					</th>
					<th>
						<?= $this->lang->line('statusAdmin'); ?>
					</th>
					<th>
						<?= $this->lang->line('actionsAdmin'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($newUsers as $value) {
					$id_usuario = $value['usuario_id'];
					$nombre = $value['nombre'];
					$email = $value['email'];
					$estado = $value['estado'];
					?>
					<tr id="rowNewUsers<?php echo $id_usuario ?>">
						<td class="firstRowImg">
							<img class="imgUserGroup" src="<?= base_url('uploads/user_img/') . $value['img'] ?>"
								alt="imagen de usuario del grupo">
							<?= $nombre; ?>
						</td>
						<td>
							<?= $email; ?>
						</td>
						<td>
							<?= $estado; ?>
						</td>
						<td>
							<button id="<?php echo $nombre . "-" . $id_usuario ?>" name="btnRechazar"
								class="rechazar rechazado">
								<?= $this->lang->line('declineUsers'); ?>
							</button>
							<button id="<?php echo $nombre . "-" . $id_usuario ?>" class="aceptar activo">
								<?= $this->lang->line('acceptUsers'); ?>
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
		const tabla = $('#newUsers').DataTable({
			order: [[2, 'asc']],
			columnDefs: [
				{
					targets: [0],
					orderData: [0, 1]
				}, {
					targets: [1],
					orderData: [1, 0]
				}, {
					targets: [2],
					orderData: [2, 1]
				}
			]
		});

		$(".rechazado, .activo").on("click", function (e) {
			e.preventDefault()
			let parts = this.id.split("-")
			let id = parts[1]
			let acDec = $(this).hasClass('rechazado') ? 'rechazado' : 'activo';

			$.ajax({
				url: "<?= site_url(); ?>AdminUsersGroup/acceptDeclineUsers",
				type: "POST",
				data: {
					idUser: id,
					acceptDecline: acDec
				},
				dataType: "json",
				success: function (data) {
					if (data.success) {
						if (acDec == 'rechazado') {
							// Actualizar el estado en la tabla
							$("#rowNewUsers" + id + " td:nth-child(3)").text("rechazado");
						} else {
							$("#rowNewUsers" + id).fadeOut();
						}
						tabla.row("#rowNewUsers" + id).invalidate().draw();
					}
				}
			});


		})
	})
</script>