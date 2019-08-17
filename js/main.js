(function ($) {
 "use strict";
// click //
$(".click").on('click',function(){
    $(".toggole").slideToggle(500);
});
/*--------------------------
 scrollUp
---------------------------- */
	$.scrollUp({
        scrollText: '<i class="fa fa-angle-up"></i>',
        easingType: 'linear',
        scrollSpeed: 900,
        animation: 'fade'
    });

// mobail menu ///
$('.mobail-menu-active').meanmenu();

var catwrapper = $(".category-wrapper");
var heights = catwrapper.map(function ()
{
	return $(this).height();
}).get(),

maxHeight = Math.max.apply(null, heights);
catwrapper.height(maxHeight);
var prcontent = $(".category-content");
var primg = $(".category-img");
prcontent.height(maxHeight-primg.height());

var prname = $(".product-name");
var prheights = prname.map(function ()
	{
		return $(this).height();
	}).get(),

	prmaxHeight = Math.max.apply(null, prheights);
prname.height(prmaxHeight);


$('#slider-active').nivoSlider({
	directionNav: true,
	animSpeed: 2000,
	slices: 18,
	pauseTime: 5000,
	pauseOnHover: false,
	controlNav: false,
	manualAdvance: true,
	prevText: '<i class="fas fa-angle-left nivo-prev-icon"></i>',
	nextText: '<i class="fas fa-angle-right nivo-next-icon"></i>'
});

 // product-active ///
	$('.product-active').owlCarousel({
	smartSpeed:1000,
	nav:true,
	margin:1,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		450:{
			items:2
		},
		600:{
			items:3
		},
		991:{
			items:4
		},
		1000:{
			items:5
		}
}
})
 // new-product-active ///
	$('.new-product-active').owlCarousel({
	smartSpeed:1000,
	nav:true,
	margin:1,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:3
		},
		1000:{
			items:3
		}
}
})
 // tab-active ///

 // latest-deals-active ///
	$('.latest-deals-active').owlCarousel({
	smartSpeed:1000,
	margin:0,
	nav:false,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:3
		},
		1000:{
			items:1
		}
}
})
 // feautred-active ///
	$('.feautred-active').owlCarousel({
	smartSpeed:1000,
	margin:1,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:3
		},
		1000:{
			items:1
		}
}
})
 // testmonial-active ///
	$('.testmonial-active').owlCarousel({
	smartSpeed:1000,
	margin:1,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:3
		}
}
})
 // mostviewed-active///
	$('.mostviewed-active').owlCarousel({
	smartSpeed:1000,
	margin:15,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:2
		}
}
})
 // brand-active///
	$('.brand-active').owlCarousel({
	smartSpeed:1000,
	margin:15,
	nav:false,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:2
		},
		600:{
			items:4
		},
		1000:{
			items:6
		}
}
})
 // single-protfolio-active///
	$('.single-protfolio-active').owlCarousel({
	smartSpeed:1000,
	margin:0,
	nav:false,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:2
		},
		450:{
			items:3
		},
		600:{
			items:4
		},
		1000:{
			items:5
		}
}
})
 // single-product-active///
	$('.single-product-active').owlCarousel({
	smartSpeed:1000,
	margin:0,
	nav:false,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:2
		},
		450:{
			items:2
		},
		600:{
			items:3
		},
		1000:{
			items:3
		}
}
})
/*-----------------------------
			home-2 js
------------------------------*/
// home2-blog-active///
	$('.home2-blog-active').owlCarousel({
	smartSpeed:1000,
	margin:0,
	nav:true,
	autoplayTimeout:1000,
	autoplay:true,
	loop:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:3
		}
}
})
// blog-active///
	$('.blog-active').owlCarousel({
	smartSpeed:1000,
	margin:0,
	loop:true,
	nav:true,
	autoplayTimeout:1000,
	autoplay:true,
	navText:['<i class="fas fa-caret-left"></i>','<i class="fas fa-caret-right"></i>'],
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
})

 // mostviewed-active-2///
	$('.mostviewed-active-2').owlCarousel({
	smartSpeed:1000,
	margin:15,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:3
		}
}
})
 // mostviewed-active-2///
	$('.mostviewed-active-2').owlCarousel({
	smartSpeed:1000,
	margin:15,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:3
		}
}
})
 // cart-active///
	$('.cart-active').owlCarousel({
	smartSpeed:1000,
	margin:15,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:2
		},
		1000:{
			items:2
		}
}
})



var owl = $('.tab-active').owlCarousel({
	smartSpeed:1000,
	margin:1,
	nav:true,
	navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		600:{
			items:3
		},
		1000:{
			items:5
		}
}
});

$('.home2-tab-menu ul li a').click(function () {
	var matchvalue = $(this).attr('href');

    $.ajax({
        url: 'ajax/matchedit-data.php',
        data: { matchvalue: matchvalue },
        type: 'post',
		dataType: 'json'
    }).done(function(responseData) {
    	$('.tab-content div[role="tabpanel"]').removeClass('active in');
        $(responseData['tag']).addClass('active in');

        $(responseData['tag']).html('<div class="tab-active home2 left-right-angle owl-carousel"></div>');
        $(responseData['tag']+" > .tab-active").html(responseData['html']);
     	var owl = $(responseData['tag']+" > .tab-active");
            owl.owlCarousel({
                smartSpeed:1000,
				margin:1,
				nav:true,
				navText:['<i class="fas fa-angle-left"></i>','<i class="fas fa-angle-right"></i>'],
				responsive:{
					0:{
						items:1
					},
					600:{
						items:3
					},
					1000:{
						items:5
					}
			}
            });

    }).fail(function() {
        console.log('Failed');
    });
})

$('#mailsend').on('submit',function(e) {  //Don't foget to change the id form
	$.ajax({
		url:'form/mail.php', //===PHP file name====
		data:$(this).serialize(),
		type:'POST',
		success:function(data){
			// console.log(data);
			//Success Message == 'Title', 'Message body', Last one leave as it is
			swal("Təşəkkürlər!", "Mesajınız göndərildi! Tezliklə sizinlə əlaqə saxlanılacaq!", "success");
			$('#mailsend').find("input[type=text], textarea").val("");
		},
		error:function(data){
			//Error Message == 'Title', 'Message body', Last one leave as it is
			swal("Göndərilmədi...", "Bir şeylər səhv oldu :(", "error");
		}
	});
	e.preventDefault(); //This is to Avoid Page Refresh and Fire the Event "Click"
});

    $(".menu-container ul li a").hover(
        function () {
        	var catid = $(this).data('id');
            $.ajax({
                url: "ajax/category.php",
                method: "post",
                data: { id: catid },
				dataType: "json",
                success: function( data ) {
                	$(".child-menu>.megamenu-2").html(data);
                }
            });
            $(".child-menu").addClass('active');
        },
        function () {
            $(".header-bottom").removeClass('active');
        }
    );
	// $( ".header-bottom" ).mouseleave(function() {
	// 	$(".child-menu").removeClass('active');
	// });


	$(".mobile-container ul li a").on("click",
		function () {
			var catid = $(this).data('id');
			$.ajax({
				url: "ajax/category.php",
				method: "post",
				data: {id: catid},
				dataType: "json",
				success: function (data) {
					$(".child-menu>.megamenu-2").html(data);
				}
			});
			$(".child-menu").addClass('animated fadeInRight delay-4s');
			$(".el span").css({"visibility": "hidden"});

		});
    $( ".mobile-container ul li a" ).dblclick(function() {
		$(".header-bottom .mobail-menu-area .menu-header .child-menu").removeClass('fadeInRight');
		$(".header-bottom .mobail-menu-area .menu-header .child-menu").addClass('fadeOutRight');
		$(".header-bottom .mobail-menu-area .el span").css({"visibility":"visible"});


	});

    $( "#search" ).autocomplete({
        source: function( request, response ) {
            var input_txt = $('#search').val();

            $.ajax({
                url: "ajax/search.php",
                method: "post",
                data: { input: input_txt },
                success: function( data ) {
                    $('.autocomplete>#search-results').html(data);
                    $('.search-results').show();
                }
            });
        },
    });

    $( "#sSearch1" ).autocomplete({

            source: function( request, response ) {
                var input_txt = $('#sSearch1').val();
                var input_type = $('#type_id').val();
                var product1 = $('input[name=id1]').val();
                var product2 = $('input[name=id2]').val();
                var product3 = $('input[name=id3]').val();

                $.ajax({
                    url: "ajax/ajax_search.php",
                    method: "get",
                    data: { input: input_txt,type: input_type,product1: product1,product2: product2,product3: product3,form:'1' },
                    success: function( data ) {
                        $('.autocomplete>#phone-results1').html(data);
                        $('.phone-results').show();
                    }
                });
        },
    });

    $( "#sSearch2" ).autocomplete({

        source: function( request, response ) {
            var input_txt = $('#sSearch2').val();
            var input_type = $('#type_id').val();
            var product1 = $('input[name=id1]').val();
            var product2 = $('input[name=id2]').val();
            var product3 = $('input[name=id3]').val();

            $.ajax({
                url: "ajax/ajax_search.php",
                method: "get",
                data: { input: input_txt,type: input_type,product1: product1,product2: product2,product3: product3,form:'2' },
                success: function( data ) {
                    $('.autocomplete>#phone-results2').html(data)
                    $('.phone-results').show();
                }
            });
        },
    });

    $( "#sSearch3" ).autocomplete({
        source: function( request, response ) {
            var input_txt = $('#sSearch3').val();
            var input_type = $('#type_id').val();
            var product1 = $('input[name=id1]').val();
            var product2 = $('input[name=id2]').val();
            var product3 = $('input[name=id3]').val();

            $.ajax({
                url: "ajax/ajax_search.php",
                method: "get",
                data: { input: input_txt,type: input_type,product1: product1,product2: product2,product3: product3,form:'3'  },
                success: function( data ) {
                    $('.autocomplete>#phone-results3').html(data);
                    $('.phone-results').show();
                }
            });
        }
    });

    $(document).click(function(event) {
        $('.phone-results').hide();
        $('.search-results').hide();
    });


    $('#slider-range').on("click",function(){
		var amount = $('#amount').val();
		var category_id = $('input[name=category_id]').val();
        $.ajax({
            url: "ajax/category_filter.php",
            method: "get",
			dataType: "json",
            data: { amount: amount,category_id: category_id  },
            success: function( data ) {
            	$('#tab1>.row').html(data.json1);
            	$('#tab2>.row').html(data.json2);
            }
        });
	});


    $(document.getElementById('filters')).change(function(){
        var brand = $(this).data('id'),
			amount = $('#amount').val(),
			category_id = $('input[name=category_id]').val(),
            type_id = $('input[name=type_id]').val(),
            brand_id = $('#brand_id').val(brand);

        var data = {
            type_id: type_id,
            amount: amount,
            category_id: category_id
        },
            brandIds = [],
            ramIds = [];

        this.querySelectorAll('input:checked').forEach(function (input) {
        	switch (input.dataset['name']) {
                case 'brands':
                    brandIds.push(input.value);
                    break;

                case 'rams':
                    ramIds.push(input.value);
                    break;
            }
		});

        data.brands = brandIds; // yoxla
        data.rams = ramIds;

        $.ajax({
            url: "ajax/category_filter.php",
            type: "get",
            dataType: "json",
            // processData: false,
            data: data,
            success: function( data ) {
            	$('.woocommerce-pagination-area ').hide();
                $('#tab1>.row').html(data.json1);
                $('#tab2>.row').html(data.json2);
            }
        });
    });

    /*$('.ram').click(function(){
        var ram = $(this).data('id');
        $.ajax({
            url: "ajax/category_filter.php",
            method: "get",
            dataType: "json",
            data: { ram: ram },
            success: function( data ) {
                $('#tab1>.row').html(data.json1);
                $('#tab2>.row').html(data.json2);
            }
        });
    });*/

    $('select[name=orderby]').change(function () {
        var id = $(this).find(':selected')[0].id;
        var category_id = $('input[name=category_id]').val();
        $.ajax({
            url: "ajax/category_filter.php",
            method: "get",
            dataType: "json",
            data: { id: id,category_id: category_id },
            success: function( data ) {
                $('#tab1>.row').html(data.json1);
                $('#tab2>.row').html(data.json2);
            }
        });
    });

    $('#hisse-hisse-ode').click(function () {
        $("#product-buy").validate({
            rules: {
                product: {
                    required: true
                }
            },
            messages: {               //messages to appear on error
                product: {
                    required: "Zəhmət olmasa ödəniş müddətini seçin.",
                }
            }
        });
    });


	// mintiup////
$('#Container').mixItUp();

})(jQuery);

$( document ).ready(function() {
//Whatsapp start

	'use strict';

	$(function () {
		var delay_on_start = 3000;
		var $whatsappme = $('.whatsappme');
		var $badge = $whatsappme.find('.whatsappme__badge');
		var wame_settings = $whatsappme.data('settings');
		var store;

		// Fallback if localStorage not supported (iOS incognito)
		// Implements functional storage in memory and will not persist between page loads
		try {
			localStorage.setItem('test', 1);
			localStorage.removeItem('test');
			store = localStorage;
		} catch (e) {
			store = {
				_data: {},
				setItem: function (id, val) { this._data[id] = String(val); },
				getItem: function (id) { return this._data.hasOwnProperty(id) ? this._data[id] : null; }
			};
		}

		// In some strange cases data settings are empty
		if (typeof (wame_settings) == 'undefined') {
			try {
				wame_settings = JSON.parse($whatsappme.attr('data-settings'));
			} catch (error) {
				wame_settings = undefined;
			}
		}

		// only works if whatsappme is defined
		if ($whatsappme.length && !!wame_settings && !!wame_settings.telephone) {
			whatsappme_magic();
		}

		function whatsappme_magic() {
			var is_mobile = !!navigator.userAgent.match(/Android|iPhone|BlackBerry|IEMobile|Opera Mini/i);
			var has_cta = wame_settings.message_text !== '';
			var message_hash, is_viewed, timeoutID;

			// stored values
			var messages_viewed = (store.getItem('whatsappme_hashes') || '').split(',').filter(Boolean);
			var is_second_visit = store.getItem('whatsappme_visited') == 'yes';

			if (has_cta) {
				message_hash = hash(wame_settings.message_text).toString();
				is_viewed = messages_viewed.indexOf(message_hash) > -1;
			}

			store.setItem('whatsappme_visited', 'yes');

			if (!wame_settings.mobile_only || is_mobile) {
				// show button
				setTimeout(function () { $whatsappme.addClass('whatsappme--show'); }, delay_on_start);

				if (has_cta && !is_viewed) {
					if (wame_settings.message_badge) { // show badge
						setTimeout(function () { $badge.addClass('whatsappme__badge--in'); }, delay_on_start + wame_settings.message_delay);
					} else if (is_second_visit) { // show dialog
						setTimeout(function () { $whatsappme.addClass('whatsappme--dialog'); }, delay_on_start + wame_settings.message_delay);
					}
				}
			}

			if (has_cta && !is_mobile) {
				$('.whatsappme__button')
					.mouseenter(function () { timeoutID = setTimeout(show_dialog, 1500); })
					.mouseleave(function () { clearTimeout(timeoutID); });
			}

			$('.whatsappme__button').click(function () {
				var link = whatsapp_link(wame_settings.telephone, wame_settings.message_send);

				if (has_cta && !$whatsappme.hasClass('whatsappme--dialog')) {
					show_dialog();
				} else {
					$whatsappme.removeClass('whatsappme--dialog');
					save_message_viewed();
					send_event(link);
					// Open WhatsApp link
					window.open(link, 'whatsappme');
				}
			});

			$('.whatsappme__close').click(function () {
				$whatsappme.removeClass('whatsappme--dialog');
				save_message_viewed();
			});

			function show_dialog() {
				$whatsappme.addClass('whatsappme--dialog');

				if (wame_settings.message_badge && $badge.hasClass('whatsappme__badge--in')) {
					$badge.removeClass('whatsappme__badge--in').addClass('whatsappme__badge--out');
					save_message_viewed();
				}
			}

			function save_message_viewed() {
				if (has_cta && !is_viewed) {
					messages_viewed.push(message_hash)
					store.setItem('whatsappme_hashes', messages_viewed.join(','));
					is_viewed = true;
				}
			}
		}
	});

	// Return a simple hash (source https://gist.github.com/iperelivskiy/4110988#gistcomment-2697447)
	function hash(s) {
		for (var i = 0, h = 1; i < s.length; i++) {
			h = Math.imul(h + s.charCodeAt(i) | 0, 2654435761);
		}
		return (h ^ h >>> 17) >>> 0;
	};

	// Return WhatsApp link with optional message
	function whatsapp_link(phone, message) {
		var link = 'https://api.whatsapp.com/send?phone=' + phone;
		if (typeof (message) == 'string' && message != '') {
			link += '&text=' + encodeURIComponent(message);
		}

		return link;
	}

	// Trigger Google Analytics event
	function send_event(link) {
		if (typeof gtag == 'function') { // Send event (Global Site Tag - gtag.js)
			gtag('event', 'click', {
				'event_category': 'WhatsAppMe',
				'event_label': link,
				'transport_type': 'beacon'
			});
		} else if (typeof ga == 'function') { // Send event (Universal Analtics - analytics.js)
			ga('send', 'event', {
				'eventCategory': 'WhatsAppMe',
				'eventAction': 'click',
				'eventLabel': link,
				'transport': 'beacon'
			});
		}
	}

	// Math.imul polyfill (source https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/imul#Polyfill)
	Math.imul = Math.imul || function (a, b) {
		var ah = (a >>> 16) & 0xffff;
		var al = a & 0xffff;
		var bh = (b >>> 16) & 0xffff;
		var bl = b & 0xffff;
		return ((al * bl) + (((ah * bl + al * bh) << 16) >>> 0) | 0);
	};

//Whatsapp end

//Left menu start

	var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeft = document.getElementById( 'showLeft' ),
		showLeftClose = document.querySelector( '.close' ),

		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

	showLeft.onclick = function() {
		classie.toggle( this, 'active' );
		classie.toggle( menuLeft, 'cbp-spmenu-open' );
	};
	showLeftClose.onclick=function()
	{
		classie.toggle( this, 'active' );
		classie.toggle( menuLeft, 'cbp-spmenu-open' );
	};

	const input = document.getElementById("search-input");
	const searchBtn = document.getElementById("search-btn");

	const expand = () => {
		searchBtn.classList.toggle("close");
		input.classList.toggle("square");
	};

	searchBtn.addEventListener("click", expand);
	$('#search-btn').click(function(){
		$('#showLeft').toggle(1000);
		$('.location').toggle(1000);
	});
	//Left menu end

});
