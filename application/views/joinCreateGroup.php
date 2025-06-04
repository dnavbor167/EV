<div id="groupSelection">
	<div class="principalElementsGroups">
		<div class="joinCreateGroup">
			<a href="<?= site_url('Groups/joinGroup') ?>" >
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