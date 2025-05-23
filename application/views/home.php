<div id="homeElements">
	<div class="principalElementsHome">
		<div class="requires-login coming-soon">
			<a href="#">
				<?= strtoupper($this->lang->line('schedule')); ?>
			</a>
		</div>

	</div>
	<div class="principalElementsHome">
		<div class="requires-login">
			<a href="#">
				<?= strtoupper($this->lang->line('mainEvent')); ?>
			</a>
		</div>

	</div>
	<div class="principalElementsHome">
		<div class="requires-login coming-soon">
			<a href="#" id="rehearsals">
				<?= strtoupper($this->lang->line('rehearsals')); ?>
			</a>
		</div>

	</div>
</div>

<script>
	$(function () {
		$('.coming-soon').on('mouseenter', function () {
			const $link = $(this).find('a')
			const text = '<?= $this->lang->line('comingSoon'); ?>...'
			let index = 0;

			$link.text('');
			const interval = setInterval(function () {
				$link.text($link.text() + text.charAt(index))
				index++;
				if (index >= text.length) {
					clearInterval(interval);
				}
			}, 100); // velocidad de la "máquina"

			// Guarda el intervalo para poder detenerlo si se sale antes de terminar
			$(this).data('typingInterval', interval)
		});

		$('.coming-soon').on('mouseleave', function () {
			const $link = $(this).find('a')
			const linkId = $link.attr('id')


			const originalText = linkId == 'rehearsals' 
				? '<?= strtoupper($this->lang->line('rehearsals')); ?>' 
				: '<?= strtoupper($this->lang->line('schedule')); ?>'

			// Detiene el intervalo si aún está escribiendo
			clearInterval($(this).data('typingInterval'));

			$link.text(originalText);
		});
	});
</script>