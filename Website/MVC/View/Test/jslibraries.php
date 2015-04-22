<title>YOUR TITLE</title>

<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/Module/morris.css" />
<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/Module/jRating.css" />
<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/Module/unslider.css" />
<link type="text/css" rel="stylesheet" href="/<?php echo __css_directory__;?>/Module/scrollpath.css" />

<?php
	// inclure ci-dessus les balises à inclure dans la balise <head> du layout
	$this->endSection('head');
?>
<?php
	// inclure ci-dessous les balises à inclure à la fin de votre DOM
	$this->beginSection();
?>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/raphael.min.js"></script>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/morris.min.js"></script>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/arctext.js"></script>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/tubular.js"></script>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/jRating.js"></script>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/unslider.js"></script>
	<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/scrollpath.js"></script>

	<!-- MORRIS JS -->
	<script type="text/javascript">
		$(document).ready(function(){
			new Morris.Line({
				// ID of the element in which to draw the chart.
				element: 'div1',
				// Chart data records -- each entry in this array corresponds to a point on
				// the chart.
				data: [
					{ year: '2008', value: 20 },
					{ year: '2009', value: 10 },
					{ year: '2010', value: 5 },
					{ year: '2011', value: 5 },
					{ year: '2012', value: 20 }
				],
				// The name of the data record attribute that contains x-values.
				xkey: 'year',
				// A list of names of data record attributes that contain y-values.
				ykeys: ['value'],
				// Labels for the ykeys -- will be displayed when you hover over the
				// chart.
				labels: ['Value']
			});
		});
	</script>
	<!-- END MORRIS -->

	<!-- ARCTEXT JS -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#arctextTitle').arctext({radius: 300});
		});
	</script>
	<!-- END ARCTEXT -->

	<!-- TUBULAR JS -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('.page').tubular({videoId: '0Bmhjf0rKe8'});
		});
	</script>
	<!-- END TUBULAR -->

	<!-- jRating -->
	<script type="text/javascript">
		$(document).ready(function(){
			$(".exemple3").jRating({
				step:true,
				length : 5, // nb of stars
				decimalLength: 0, // number of decimal in the rate
				rateMax: 5
			});
		});
	</script>
	<!-- END jRating -->

	<!-- Unslider -->
	<script type="text/javascript">
		$(function() {
			$('.banner').unslider({
				speed: 500,               //  The speed to animate each slide (in milliseconds)
				delay: 3000,              //  The delay between slide animations (in milliseconds)
				complete: function() {},  //  A function that gets called after every slide animation
				keys: true,               //  Enable keyboard (left, right) arrow shortcuts
				dots: true,               //  Display dot navigation
				fluid: false              //  Support responsive design. May break non-responsive designs
			});
		});
	</script>
	<!-- END Unslider -->

	<!-- Scrollpath JS -->
	<script type="text/javascript">
		$(document).ready(function(){
			var path = $.fn.scrollPath("getPath", {
				scrollSpeed: 80, // Default is 50
				rotationSpeed: Math.PI / 10 // Default is Math.PI / 15
			});
			path.moveTo(400, 50, {name: "div1"})
			.lineTo(400, 800, {name: "div2"})
			.arc(200, 1200, 400, -Math.PI/2, Math.PI/2, true)
			.lineTo(600, 1600, {
				callback: function() {
					highlight($(".settings"));
				},
				name: "div3"
			})
			.lineTo(1750, 1600, {
				callback: function() {
					highlight($(".sp-scroll-handle"));
				},
				name: "div4"
			})
			.arc(1800, 1000, 600, Math.PI/2, 0, true, {rotate: Math.PI/2 })
			.lineTo(2400, 750, {
				name: "div5"
			})
			.arc(1300, 50, 900, -Math.PI/2, -Math.PI, true, {rotate: Math.PI*2, name: "end"});

			// We're done with the path, let's initate the plugin on our wrapper element
			$(".wrapper").scrollPath({drawPath: true, wrapAround: true});

			// Add scrollTo on click on the navigation anchors
			$("nav").find("a").each(function() {
				var target = $(this).attr("href").replace("#", "");
				$(this).click(function(e) {
					e.preventDefault();
					
					// Include the jQuery easing plugin (http://gsgd.co.uk/sandbox/jquery/easing/)
					// for extra easing functions like the one below
					$.fn.scrollPath("scrollTo", target, 1000, "easeInOutSine");
				});
			});
		});

		function highlight(element) {
			if(!element.hasClass("highlight")) {
				element.addClass("highlight");
				setTimeout(function() { element.removeClass("highlight"); }, 2000);
			}
		}
	</script>
	<!-- END Scrollpath -->
<?php
	$this->endSection('scripts');
	$this->beginSection();
	// START CONTENT
	// Intégrer ci-dessous la vue
?>

<!-- NAVIGATION -->
<nav>
	<ul>
		<li><a href="#div1">1</a></li>
		<li><a href="#div2">2</a></li>
		<li><a href="#div3">3</a></li>
		<li><a href="#div4">4</a></li>
	</ul>
</nav>
<!-- END NAVIGATION -->

<div class="wrapper">
	<!-- MORRIS JS -->
	<div id="div1" class="div1" style="height: 250px;"></div>
	<!-- END MORRIS -->
	<br/>
	<!-- ARCTEXT JS -->
	<div id="div2" class="div2" style="width: 400px;margin:auto;text-align:center;">
		<h1 id="arctextTitle" style="color: black;">TITRE ARCTEXT</h1>
	</div>
	<!-- END ARCTEXT -->
	<br/>

	<!-- JRating -->
	<div id="div3" class="div3" style="width: 400px;margin:auto;text-align:center;">
		<p class="exemple3" data-average="3" data-id="3"></p>
	</div>
	<!-- END JRating -->
	<br/>

	<!-- Unslider -->
	<div class="banner div4" id="div4">
		<ul>
			<li>This is a slide.</li>
			<li>This is another slide.</li>
			<li>This is a final slide.</li>
		</ul>
	</div>
	<!-- END Unslider -->
</div>