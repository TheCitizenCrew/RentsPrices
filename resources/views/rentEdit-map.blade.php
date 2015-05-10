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

			map = L.map('map', {
				 loadingControl: true
			}).setView([47.37760, 0.67961], 17);
			map.scrollWheelZoom.disable();
			map.touchZoom.disable();
			L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);

			$( "#street, #zipcode, #city" ).focusout(function()
			{
				if( $('#street').val() !='' && $('#zipcode').val() != '' && $('#city').val() != '' )
				{
					geocodeAddress();
				}
			});

		});

		function geocodeAddress()
		{
			var addr = $('#street').val()+', '+$('#zipcode').val()+', '+$('#city').val();
			console.log('essai_geocode()');
			map.fire('dataloading');
			geocoder.geocode( addr, geocodeResult, null );
			
		}

		function centerOnAddress()
		{
			if( geocodeMarker )
			{
				map.setView( geocodeMarker.getLatLng(), 18);
			}
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
				geocodeMarker = new L.Marker(result.center, {
					draggable: true
					})
				.on('dragend', function(){
					map.setView( geocodeMarker.getLatLng(), 18);
					$('#addrlat').val( geocodeMarker.getLatLng().lat );
					$('#addrlng').val( geocodeMarker.getLatLng().lng );
				})
				.addTo(map);
			}
		
		}

	</script>
@stop
