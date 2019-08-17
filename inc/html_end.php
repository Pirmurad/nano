<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/az_AZ/sdk.js#xfbml=1&version=v2.11&appId=1978001302460332&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<!--<script src="js/vendor/jquery-1.12.4.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->

<!--<script type="text/javascript" src="js/bootstrap.min.js"></script>-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


<? if (get('linkname')=='mehsul'): ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-zoom/1.7.21/jquery.zoom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script>
        if ($ && $.fn.zoom) {
            $('img.zoomImg').wrap('<span style="display:inline-block"></span>')
                .css('display', 'block')
                .parent()
                .zoom();
        }
    </script>
<? endif; ?>
<? if (get('linkname')=='elaqe'): ?>

<!-- Google map  -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-EEPxbay_aFpp3jcFXpjyPQcVQUJ2pp0"></script>

<!-- Google map start -->

<script>
	function initialize() {
		var mapOptions = {
			zoom: 17,
			scrollwheel: false,
			center: new google.maps.LatLng(40.4003461, 49.8661039)
		};

		var map = new google.maps.Map(document.getElementById('googleMap'),
			mapOptions);


		var marker = new google.maps.Marker({
			position: map.getCenter(),
			animation: google.maps.Animation.BOUNCE,
			icon: 'img/map.png',
			map: map
		});

	}

	google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Google map End -->

<? endif; ?>

<!-- magnific popup js -->
<!--<script src="js/jquery.magnific-popup.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<!-- mixitup js -->
<script src="js/jquery.mixitup.min.js"></script>
<!-- jquery-ui price-->
<!--<script src="js/jquery-ui.min.js"></script>-->
<!-- ScrollUp Js -->
<!--<script src="js/jquery.scrollUp.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>
<!-- nivo slider js -->
<!--<script src="js/jquery.nivo.slider.pack.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/jquery.nivo.slider.pack.min.js"></script>
<!-- mobail menu js -->
<script src="js/jquery.meanmenu.js"></script>
<!-- owl carousel js -->
<script src="js/owl.carousel.min.js"></script>
<!-- All js plugins included in this file. -->
<script src="js/plugins.js"></script>
<!-- Main js file that contents all jQuery plugins activation. -->
<script src="js/main.js"></script>

</body>

</html>