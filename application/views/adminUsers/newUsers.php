<div class="tableUsers">
	<table id="newUsers" class="display" style="width: 100%; border: solid 1px gray;">
		<thead>
			<tr>
				<th><?= $this->lang->line('nameAdmin'); ?></th>
				<th><?= ucfirst($this->lang->line('email')); ?></th>
				<th><?= $this->lang->line('statusAdmin'); ?></th>
				<th><?= $this->lang->line('actionsAdmin'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($newUsers as $value) {
				$id_empleado = $value['usuario_id'];
				$nombre = $value['nombre'];
                $email = $value['email'];
                $estado = $value['estado']
				?>
				<tr id="rowNewUsers<?php echo $id_empleado ?>">
					<td>
						<?= $nombre; ?>
					</td>
					<td>
						<?= $email; ?>
					</td>
					<td>
						<?= $estado; ?>
					</td>
					<td>
						<button id="<?php echo $nombre . "-" . $id_empleado ?>" name="btnEditar"
							class="btn btn-success btn-sm editar" data-target="#myModal"> Editar
						</button>
						<button id="<?php echo $nombre . "-" . $id_empleado ?>"
							class="btn btn-success btn-sm eliminar-empleado" data-target="#myModal"
							style="background: red;"> Eliminar </button>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<script>


</script>

<script>
	$(function () {
		$('#newUsers').DataTable({
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
	});
</script>