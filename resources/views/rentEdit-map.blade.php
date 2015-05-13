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


<a id="locateAddress" tabindex="0" class="btn btn-default " role="button" onclick="geocodeAddress(true);" data-toggle="popover" data-trigger="focus" data-content="L'adresse n'est pas complète" >
localiser l'adresse</a>

<a id="centerAddress" tabindex="0" class="btn btn-default " role="button" onclick="centerOnAddress();" data-toggle="popover" data-trigger="focus" data-content="L'adresse n'est pas complète" >
Center sur l'adresse</a>

<div id="map"></div>

@section('javascript')
	@parent
	<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
	<script src="//cdn.rawgit.com/ebrelsford/Leaflet.loading/v0.1.16/src/Control.Loading.js"></script>
	<script src="/js/Geocoder.AddOk.js"></script>
	<script src="/js/RentsMap.common.js"></script>
	
	<script>
		"use strict" ;

		var map, geocodeMarker,
			geocoder = new GeocoderAddOk( {limit: 10 } ),
			zoom = 17 ;

		$(function() {

			// Construct the Lealfet Map

			map = L.map('map', {
				 loadingControl: true
			}).setView([45.936, 10.481], 5);
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
				map.setView( geocodeMarker.getLatLng(), zoom);
			}

		});

		/**
		 * Center the map on address
		 */
		function centerOnAddress()
		{
			if( geocodeMarker )
			{
				map.setView( geocodeMarker.getLatLng(), zoom);
				reutrn ;
			}
			$('#centerAddress').popover('show');
		}

		/**
		 * Construct the address string and call the geocoder.
		 */
		function geocodeAddress(force)
		{

			// if geolocManual is on and force is off, do nothing

			if( force == undefined || force == false )
			{
				if( geolocManual() )
				{
					return ;
				}
			}

			// Construct the address query string

			var addr = [];
			['#street', '#zipcode', '#city', '#country'].forEach( function(input){
				var v = $(input).val() ;
				if( v != undefined && v.trim() != '' )
					addr.push( v );
			} );
			if( addr.length == 0 )
			{
				$('#locateAddress').popover('show');
				return ;
			}

			// Call the geocoder

			map.fire('dataloading');
			geocoder.geocode( addr.join(','), geocoderOnResult, null );			
		}

		/**
		 * Handle geocoder result (callback)
		 */
		function geocoderOnResult(data)
		{
			map.fire('dataload');

			if( data[0] == undefined )
			{
				return ;
			}
			result = data[0];
			map.fitBounds(result.bbox);

			$('#addrlat').val( result.center.lat );
			$('#addrlng').val( result.center.lng );

			if( geocodeMarker )
			{
				geocodeMarker.setLatLng(result.center);
				geolocManual(false);
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
			.on('dragend', geocodeMarkerOnDragEnd)
			.addTo(map);
			geolocManual( geolocManual() );
		}

		function geocodeMarkerOnDragEnd(e)
		{
			map.setView( geocodeMarker.getLatLng(), 18);
			$('#addrlat').val( geocodeMarker.getLatLng().lat );
			$('#addrlng').val( geocodeMarker.getLatLng().lng );
			geolocManual(true);
		}

		function geolocManual(state)
		{
			if( ! geocodeMarker )
				return ;
			if( state == undefined ) {
				return $('#geolocManual').val() != 0 ? true : false ;
			}
			if( state == true ) {
				$('#geolocManual').val('1');
				geocodeMarker.setIcon(iconGeolocManual);
			} else {
				$('#geolocManual').val('0');
				geocodeMarker.setIcon(iconGeolocAuto);
			}
		}

	</script>
@stop
