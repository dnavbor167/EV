$(function () {
    let lastScrollTop = 0

    //Menú desplegable
    let menuVisible;
    function toggleMenu(open) {
        if (window.innerWidth < 1024) {
            if (open) {
                $("div#menu-desplegable nav").slideDown('fast')
                $("#login, #principalLogo").fadeOut("fast")
            } else {
                $("div#menu-desplegable nav").slideUp('fast');
                $("#login, #principalLogo").fadeIn("fast");
            }
        }
    }

    $('#menu-desplegable nav li').on('click', function () {
        if (window.innerWidth < 1024) {
            toggleMenu(false);
            menuVisible = false;
        }
    });

    $('#openMenu').click(function () {
        toggleMenu(true);
        menuVisible = true
    });

    $('#closeMenu').click(function () {
        toggleMenu(false);
        menuVisible = false
    });

    $("div#menu-desplegable nav").on("click", function (e) {
        e.stopPropagation();
    });

    $(window).on('click', function (e) {
        if ($(window).width() < 950 &&
            menuVisible &&
            !$(e.target).closest('#menu-desplegable nav, #openMenu, #closeMenu').length) {
            toggleMenu(false);
            menuVisible = false;
        }
    });


    $(window).on("resize scroll", function () {
        if (window.innerWidth < 1024) {
            if (menuVisible) {
                $("div#menu-desplegable nav").hide()
                $("#login").toggle()
                $(".logo").toggle()
                menuVisible = false
            }

            // Detectar dirección del scroll
            const currentScroll = $(this).scrollTop()
            if (currentScroll > 108) {
                if (currentScroll > lastScrollTop) {
                    $("header").fadeOut("fast")
                } else {
                    $("header").fadeIn("fast")
                }
            } else {
                $("header").fadeIn("fast")
            }
            lastScrollTop = currentScroll
        }
    })

    //hover from the principal event
    function bindHoverOrTouchHome() {
        $(document).off('mouseenter mouseleave mousedown mouseup', '.principalElementsHome:nth-child(2) div, .principalElementsGroups div');

        if (window.innerWidth >= 1024) {
            $(document).on('mouseenter', '.principalElementsHome:nth-child(2) div, .principalElementsGroups div', function () {
                $(this).css('transform', 'scale(1.2)');
            }).on('mouseleave', '.principalElementsHome:nth-child(2) div, .principalElementsGroups div', function () {
                $(this).css('transform', 'scale(1)');
            })
        } else {
            $(document).on('mousedown', '.principalElementsHome:nth-child(2) div, .principalElementsGroups div', function () {
                $(this).css('transform', 'scale(1.2)');
            }).on('mouseup', '.principalElementsHome:nth-child(2) div, .principalElementsGroups div', function () {
                $(this).css('transform', 'scale(1)');
            })
        }
    }
    bindHoverOrTouchHome()
    $(window).on('resize', function () {
        bindHoverOrTouchHome()
        if (window.innerWidth >= 1024) {
            $('#menu-desplegable nav').show();
        } else {
            $('#menu-desplegable nav').hide(); // Para evitar que quede abierto al pasar de desktop a móvil
        }
    })

    //logIn margin
    $('#logInMain form input').each(function () {
        const errorSpan = $(this).next('span.error');
        if (errorSpan.length && errorSpan.text().trim().length > 0) {
            $(this).css('margin-bottom', '0');
            errorSpan.css({
                'display': 'block',
                'margin-bottom': '1rem',
                'color': 'red',
                'font-size': '.8rem',
                'width': '10rem'
            });
        } else {
            $(this).css('margin-bottom', '1.5rem');
            errorSpan.css('display', 'none');
        }
    });

    //Ver contraseña, Ocultar contraseá
    $(document).on('click', '#seePass', function () {
        $(this).hide()
        $(this).next().show()
        $('#userPassword').attr('type', 'text')
    })

    $(document).on('click', '#dontSeePass', function () {
        $(this).hide()
        $(this).prev().show()
        $('#userPassword').attr('type', 'password')
    })

    //menu hover and click options
    $('#menu-desplegable nav ul li').on('click mouseenter', function (e) {
        $(this).css('background-color', '#303030')
    }).on('mouseleave', function () {
        $(this).css('background-color', '#565656');
    });

    //Block the coming soon home (in the future will be active)
    $('.coming-soon',).on('click', function (e) {
        e.preventDefault()
    })

    //Menu until the footer
    $(window).on("scroll resize", function () {
        ajustarMenu();
    });

    $(document).ready(function () {
        ajustarMenu();
    });

    function ajustarMenu() {
        if (window.innerWidth >= 1024) {
            const headerHeight = 108;
            const menu = $("#menu-desplegable nav");
            const footer = $("footer");

            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();

            const footerTop = footer.offset().top;
            const menuHeight = windowHeight - headerHeight;

            const maxMenuHeight = footerTop - scrollTop - headerHeight;

            if (maxMenuHeight < menuHeight) {
                menu.css({
                    position: "fixed",
                    top: headerHeight + "px",
                    height: maxMenuHeight + "px",
                    overflowY: "auto"
                });
            } else {
                menu.css({
                    position: "fixed",
                    top: headerHeight + "px",
                    height: menuHeight + "px",
                    overflowY: "auto"
                });
            }
        } else {
            $("#menu-desplegable nav").removeAttr("style");
        }
    }

    //Image from form
    $(document).on('change', '#photo', function () {
        let input = this;
        let label = $('.photoFile');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                label
                    .css({
                        'background-image': 'url(' + e.target.result + ')',
                        'background-size': 'contain',
                        'background-position': 'center center',
                        'background-repeat': 'no-repeat',
                        'border': 'none'
                    })
                    .addClass('has-image')
                    .text('');  // Opcional: quitar texto si quieres solo la imagen
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            label
                .css({
                    'background-image': 'none',
                    'background-size': '',
                    'background-position': '',
                    'background-repeat': '',
                    'border': 'dashed 5px #303030'
                })
                .removeClass('has-image')
                .text('Seleccionar imagen');
        }
    })

    //Cambiar css si está logueado para el header
    if (isLoggedIn) {
        $('#login').css({
            'width': '8rem',

        })

        $('#logoGeneral').css('margin-left', '2.5rem')
    }

    //si no está logueado poner un flex distinto al logo
    //esta variable está definida en el footer
    if (!isLoggedIn) {
        function ajustarFlexHeader() {
            if ($(window).width() >= 1180) {
                $('#login > div:nth-of-type(1)').css('flex', '0 0 63%');
            } else if ($(window).width() >= 1024) {
                $('#login > div:nth-of-type(1)').css('flex', '0 0 70%');
            }
        }

        // Ejecutar al cargar y al cambiar tamaño
        $(window).on('load resize', ajustarFlexHeader);
    }

    //boton back 
    //colors when click a button
    $(document).on('mousedown mouseenter', '.icon-back, #btnRecoverPass', function () {
        if ($(this).hasClass('icon-back')) {
            $(this).css('fill', '#C65900');
        } else {
            $(this).css('background-color', '#C65900');
        }
    });

    $(document).on('mouseup mouseleave', '.icon-back, #btnRecoverPass', function () {
        if ($(this).hasClass('icon-back')) {
            $(this).css('fill', '#FF7300');
        } else {
            $(this).css('background-color', '#FF7300');
        }
    });

});