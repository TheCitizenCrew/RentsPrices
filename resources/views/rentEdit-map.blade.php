@section('css')
	@parent
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
	<link rel="stylesheet" href="//cdn.rawgit.com/ebrelsford/Leaflet.loading/v0.1.16/src/Control.Loading.css" />

	<style type="text/css">
		#map {
			/*position: absolute;*/
			width: 100%;
			height: 300px;
		}
	
	</style>
@stop

<button type="button" onclick="geocodeAddress();">localiser l'adresse</button>
<button type="button" onclick="centerOnAddress();">Center sur l'adresse</button>
<div id="map"></div>

@section('javascript')
	@parent
	<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
	<script src="//cdn.rawgit.com/ebrelsford/Leaflet.loading/v0.1.16/src/Control.Loading.js"></script>
	<script src="/Geocoder.AddOk.js"></script>

	<script>

		var map, geocodeMarker;
		var geocoder = new GeocoderAddOk( {limit: 10 } );

		$(function() {

			// Construct the Lealfet Map

			map = L.map('map', {
				 loadingControl: true
			}).setView([47.37760, 0.67961], 17);
			// remove map's pane to avoid map moves while scrolling the page
			map.scrollWheelZoom.disable();
			map.touchZoom.disable();
			L.tileLayer('http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
			    attribution: 'Data &copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://mapquest.com">MapQuest</a>-OSM Tiles',
			    subdomains: ['otile1','otile2', 'otile3', 'otile4']
			}).addTo(map);

			// Catch lost focus on some form's inputs

			$( "#street, #zipcode, #city, #country" ).focusout(function()
			{
				if( $('#street').val() !='' && $('#zipcode').val() != '' && $('#city').val() != '' )
				{
					geocodeAddress();
				}
			});

			// Place the map on previously recorded location
			var lat = $('#addrlat').val(),
				lng = $('#addrlng').val();
			if( lat!=0 && lng!=0 )
			{
				createGeoMarker( lat, lng );
				map.setView( geocodeMarker.getLatLng(), 18);
			}

		});

		function centerOnAddress()
		{
			if( geocodeMarker )
			{
				map.setView( geocodeMarker.getLatLng(), 18);
			}
		}

		/**
		 * Construct the address string and call the geocoder
		 */
		function geocodeAddress()
		{
			var addr = $('#street').val()+', '+$('#zipcode').val()+', '+$('#city').val()+', '+$('#country').val();
			map.fire('dataloading');
			geocoder.geocode( addr, geocodeResult, null );			
		}

		function geocodeResult(data)
		{
			map.fire('dataload');

			result = data[0];
			console.log(result);
			map.fitBounds(result.bbox);

			$('#addrlat').val( result.center.lat );
			$('#addrlng').val( result.center.lng );

			if( geocodeMarker )
			{
				geocodeMarker.setLatLng(result.center);
			}
			else
			{
				createGeoMarker( result.center.lat, result.center.lng );
			}
		
		}

		function createGeoMarker( lat, lng )
		{
			geocodeMarker = new L.Marker( [lat, lng], {
				draggable: true
				})
			.on('dragend', function(){
				map.setView( geocodeMarker.getLatLng(), 18);
				$('#addrlat').val( geocodeMarker.getLatLng().lat );
				$('#addrlng').val( geocodeMarker.getLatLng().lng );
			})
			.addTo(map);

		}

	</script>
@stop
