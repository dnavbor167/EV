</main>

    <!--Hacemos el footer-->
    <footer>
        <div id="evFooter">
            <img src="<?= base_url('assets/img/icon/evLogo.svg'); ?>" alt="Icono EV" id="iconEvFooter">
            <div>
                <h3><?= strtoupper($this->lang->line('eternals')); ?></h3>
                <h3 id="vibesFooter"><?= strtoupper($this->lang->line('vibes')); ?></h3>
            </div>

        </div>
        <div id="evContact">
            <h3><?= strtoupper($this->lang->line('contact')); ?></h3>
            <p>info@example.com</p>
        </div>
        <div id="socialMediaFooter">
            <svg class="icon-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
            </svg>
            <svg class="icon-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" />
            </svg>
            <svg class="icon-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
            </svg>
            <svg class="icon-menu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                <path
                    d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3 .8-3.4 5-20.3 6.9-28.1 .6-2.5 .3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z" />
            </svg>
        </div>
        <div id="homeServiceFooter">
            <p><?= strtoupper($this->lang->line('home')); ?></p>
            <p><?= strtoupper($this->lang->line('services')); ?></p>
            <p><?= strtoupper($this->lang->line('about')); ?></p>
        </div>

        <div id="subscribeFooter">
            <div id="privacyTerms">
                <p><?= strtoupper($this->lang->line('privacyPolicy')); ?></p>
                <p><?= strtoupper($this->lang->line('termsServices')); ?></p>
            </div>

            <form action="#" method="post" id="newsLetter">
                <label for="emailNews"><?= strtoupper($this->lang->line('newsLetterText')); ?></label>
                <input placeholder="<?= $this->lang->line('newsLetterPlace'); ?>" type="email" name="emailNews" id="emailNews">
                <button type="submit" id="btnNewsletter"><?= strtoupper($this->lang->line('newsLetterButton')); ?></button>
            </form>
        </div>
    </footer>

    <script>
        //Si no ha iniciado bloquear todas las funciones
        <?php if (!$this->session->userdata('is_logged_in')): ?>
			// Mostrar modal al hacer clic en enlaces que requieren login
			$('.requires-login').on('click', function (e) {
				e.preventDefault();
				$('#loginModal').fadeIn();
			});

			// Cerrar el modal al hacer clic en el botón de cierre
			$('.custom-close').on('click', function () {
				$('#loginModal').fadeOut();
			});

			// Cerrar el modal al hacer clic fuera del contenido
			$(window).on('click', function (e) {
				if ($(e.target).is('#loginModal')) {
					$('#loginModal').fadeOut();
				}
			});
		<?php endif; ?>

        $('#btnNewsletter').on('mousedown', function() {
            $(this).css('background-color', '#C65900');
        });

        $('#btnNewsletter').on('mouseup mouseleave', function() {
            $(this).css('background-color', '#FF7300');
        });
    </script>
</body>

</html>