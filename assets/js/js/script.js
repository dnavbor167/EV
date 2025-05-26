$(function () {
    //responsive

    //Menú desplegable
    let menuVisible;
    function toggleMenu(open) {
        if ($(window).width() < 1024) {
            if (open) {
                $("div#menu-desplegable nav").slideDown('fast')
                $("#login, #principalLogo").fadeOut("fast")
            } else {
                $("div#menu-desplegable nav").slideUp('fast');
                $("#login, #principalLogo").fadeIn("fast");
            }
        }
    }

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
        if ($(window).width() < 1024 &&
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
        $(document).off('mouseenter mouseleave mousedown mouseup', '.principalElementsHome:nth-child(2) div');

        if (window.innerWidth >= 1024) {
            $(document).on('mouseenter', '.principalElementsHome:nth-child(2) div', function () {
                $(this).css('transform', 'scale(1.2)');
            }).on('mouseleave', '.principalElementsHome:nth-child(2) div', function () {
                $(this).css('transform', 'scale(1)');
            })
        } else {
            $(document).on('mousedown', '.principalElementsHome:nth-child(2) div', function () {
                $(this).css('transform', 'scale(1.2)');
            }).on('mouseup', '.principalElementsHome:nth-child(2) div', function () {
                $(this).css('transform', 'scale(1)');
            })
        }
    }
    bindHoverOrTouchHome()
    $(window).on('resize', function () {
        bindHoverOrTouchHome()
        if ($(window).width() >= 1024) {
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
    $('#menu-desplegable nav ul li').on('click, mouseenter', function () {
        $(this).css('background-color', '#303030')
    }).on('mouseleave', function () {
        $(this).css('background-color', '#565656');
    });

    //Block the coming soon home (in the future will be active)
    $('.coming-soon',).on('click', function (e) {
        e.preventDefault()
    })

    //Menu until the footer
    $(window).on("scroll resize load", function () {
        if ($(window).width() >= 1024) {
            const headerHeight = 108; // altura header fija
            const menu = $("#menu-desplegable nav");
            const footer = $("footer");

            const scrollTop = $(window).scrollTop();
            const windowHeight = $(window).height();

            const footerTop = footer.offset().top;
            const menuHeight = windowHeight - headerHeight;

            // Altura máxima que puede tener el menú sin pisar el footer
            const maxMenuHeight = footerTop - scrollTop - headerHeight;

            if (maxMenuHeight < menuHeight) {
                // Si el footer está "cerca", limitar la altura para no superponer
                menu.css({
                    position: "fixed",
                    top: headerHeight + "px",
                    height: maxMenuHeight + "px",
                    overflowY: "auto"
                });
            } else {
                // Si el footer está lejos, menú ocupa toda la altura disponible
                menu.css({
                    position: "fixed",
                    top: headerHeight + "px",
                    height: menuHeight + "px",
                    overflowY: "auto"
                });
            }
        } else {
            // Para pantallas menores a 1024, quita estilos inline para no interferir
            $("#menu-desplegable nav").removeAttr("style");
        }
    });

});