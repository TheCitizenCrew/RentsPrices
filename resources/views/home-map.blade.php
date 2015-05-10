
@section('css')
	@parent
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
	<link rel="stylesheet" href="//cdn.rawgit.com/ebrelsford/Leaflet.loading/v0.1.16/src/Control.Loading.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.Default.css" />
	
	<style type="text/css">
		#map {
			width: 100%;
			height: 600px;
		}
	
	</style>
@stop


<div id="alertBox" class="alert alert-danger" style="display: none;">
	<button type="button" class="close" onclick="$('#alertBox').hide()">&times;</button>
	<strong>Warning!</strong> <span>There was a problem with your network connection.</span>
</div>

<div id="map"></div>

@section('javascript')
	@parent
	<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
	<script src="//cdn.rawgit.com/ebrelsford/Leaflet.loading/v0.1.16/src/Control.Loading.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/leaflet.markercluster.js"></script>
	<script>
	var map, markers ;

	$(function() {

		// Construct the Lealfet Map

		map = L.map('map', {
			 loadingControl: true
		});
		//.setView([lat, lng], zoom);
		// remove map's pane to avoid map moves while scrolling the page
		map.scrollWheelZoom.disable();
		map.touchZoom.disable();
		L.tileLayer('http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
		    attribution: 'Data &copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://mapquest.com">MapQuest</a>-OSM Tiles',
		    subdomains: ['otile1','otile2', 'otile3', 'otile4']
		}).addTo(map);

		markers = new L.MarkerClusterGroup({ chunkedLoading: true });
		markers.addTo(map);

		map.on('moveend', function() {
			$("#alertBox").hide();
			map.fire('dataloading');
			var bounds = map.getBounds();
			var url = 'http://prixdesloyers.localhost/api/findRentsInBBox'
				+ "/" + bounds.getSouthWest().lat // swLat
				+ "/" + bounds.getSouthWest().lng // swLon=
				+ "/" + bounds.getNorthEast().lat // neLat=
				+ "/" + bounds.getNorthEast().lng // neLon=
			;
			loadData( url );
		});

		map		.setView([45.936, 10.481], 5);
		
	});

	function loadData( url )
	{
		var jqxhr = $.getJSON( url, function( data ) {
			markers.clearLayers();
			data.forEach( function(rent) {
				//console.log(rent);
				var title = rent.street+', '+rent.zipcode+', '+rent.city ;
				var marker = L.marker( L.latLng(rent.addrlat, rent.addrlng), { title: title });
				marker.bindPopup('<b>'+title+'</b>');
				markers.addLayer(marker);
			});
			map.fire('dataload');
		})
		.fail(function( data ) {
			map.fire('dataload');
			var alert = $("#alertBox");
			$('span',alert).text('Échec du chargement des données ('+data.status+' '+data.statusText+').');
			alert.show();
		});

	}

	</script>
	
@stop
