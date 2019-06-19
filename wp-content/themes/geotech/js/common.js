$(document).ready(function() {
	//Попап менеджер FancyBox
	//Документация: http://fancybox.net/howto
	$("a.fancybox").fancybox();

	//Плавный скролл до блока .div по клику на .scroll
	//Документация: https://github.com/flesler/jquery.scrollTo
	$("a.scroll").click(function() {
		$.scrollTo($(".div"), 800, {
			offset: -90
		});
	});
	
	$('.about-slider').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        autoplay:false,
        smartSpeed:2000,
        autoplayTimeout:5000,
        dots:false,
        stopOnHover:true,
        navigationText:["",""],
        rewindNav:true,
        pagination:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
	
	$('.our-direction-slider').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        autoplay:false,
        smartSpeed:1000,
        autoplayTimeout:5000,
        dots:false,
        stopOnHover:true,
        navigationText:["",""],
        rewindNav:true,
        pagination:true,
        responsive:{
            320:{
                items:3
            },
            400:{
                items:3
            },
            580:{
                items:3
            },
            768:{
                items:4
            },
            991:{
                items:6
            },
            1360:{
                items:8
            }
        }
    });
	
	$('.galery').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        autoplay:false,
        smartSpeed:2000,
        autoplayTimeout:5000,
        dots:false,
        stopOnHover:true,
        navigationText:["",""],
        rewindNav:true,
        pagination:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });
	
	$('.top-slider').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        autoplay:true,
        smartSpeed:1000,
        autoplayTimeout:5000,
        dots:true,
        stopOnHover:true,
        navigationText:["",""],
        rewindNav:true,
        pagination:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
	
	$("a.ancLinks").click(function () { 
		var elementClick = $(this).attr("href");
		var destination = $(elementClick).offset().top;
		$('html,body').animate( { scrollTop: destination }, 1100 );
		return false;
	});
	
	$(".menu-button").click(function() {
		$("nav .first-lavel-menu").slideToggle();
	});
	
	$(".button-video").click(function() {
		$(".first-lavel").slideToggle();
	});
	
	$(".button-video").click(function() {
		$(".first-lavel").slideToggle();
	});
});