<title>YOUR TITLE</title>

<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/raphael.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/morris.min.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/arctext.js"></script>
<script type="text/javascript" src="/<?php echo __js_directory__  ; ?>/Module/tubular.js"></script>

<link type="text/css" rel="stylesheet" href="<?php echo __css_directory__;?>/Module/morris.css" />
<?php
    // inclure ci-dessus les balises à inclure dans la balise <head> du layout
    $head = $this->RegisterViewHead();
    // START CONTENT
    // Intégrer ci-dessous la vue
?>
<div class="page">
	<!-- MORRIS JS -->
	<div id="myfirstchart" style="height: 250px;"></div>
	<script type="text/javascript">
		new Morris.Line({
			// ID of the element in which to draw the chart.
			element: 'myfirstchart',
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
	</script>
	<!-- END MORRIS -->

	<!-- ARCTEXT JS -->
	<h1 id="arctextTitle">TITRE ARCTEXT</h1>
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
</div>