$(function () {
    //responsive

    //Menú desplegable
    let menuVisible = false
    let lastScrollTop = 0

    $("#openMenu").on("click", function (e) {
        e.stopPropagation()
        menuVisible = !menuVisible
        $("div#menu-desplegable nav").toggle(menuVisible)
        if (menuVisible) {
            $("#login, #logo").fadeOut("fast")
        } else {
            $("#login, #logo").fadeIn("fast")
        }
    })

    $("#closeMenu").on("click", function (e) {
        e.stopPropagation();
        $("div#menu-desplegable nav").hide();
        $("#login, #logo").fadeIn("fast");
        menuVisible = false;
    })

    $("div#menu-desplegable nav").on("click", function (e) {
        e.stopPropagation();
    });

    $(window).on('click', function (e) {
        if (!$(e.target).closest('nav').length) {
            $("div#menu-desplegable nav").hide();
            $("#login, #logo").fadeIn("fast");
            menuVisible = false;
        }
    });


    $(window).on("resize scroll", function () {
        if (menuVisible) {
            $("div#menu-desplegable nav").hide()
            $("#login").toggle()
            $("#logo").toggle()
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
    })

    //hover from the principal event
    $('.principalElementsHome:nth-child(2) div').on('mouseenter', function () {
        $(this).css('transform', 'scale(1.2)');

    }).on('mouseleave', function () {
        $(this).css('transform', 'scale(1)');
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
    $('#seePass').on('click', function () {
        $(this).hide()
        $(this).next().show()
        $('#userPassword').attr('type', 'text')
    })

    $('#dontSeePass').on('click', function () {
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
});