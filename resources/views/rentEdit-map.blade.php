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


<a id="locateAddress" tabindex="0" class="btn btn-default " role="button" onclick="geocodeAddress(true);" data-toggle="popover" data-trigger="manual" data-content="L'adresse n'est pas complète" >
localiser l'adresse</a>

<a id="centerOnMarker" tabindex="0" class="btn btn-default " role="button" onclick="centerOnMarker();" >
Center sur le marqueur</a>

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
			defaultMapView = [45.936, 10.481],
			zoom = 17 ;

		$(function() {

			// Construct the Lealfet Map

			map = L.map('map', {
				 loadingControl: true
			}).setView(defaultMapView, 5);
			// remove map's pane to avoid map moves while scrolling the page
			map.scrollWheelZoom.disable();
			map.touchZoom.disable();
			L.tileLayer('http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
			    attribution: 'Data &copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://mapquest.com">MapQuest</a>-OSM Tiles',
			    subdomains: ['otile1','otile2', 'otile3', 'otile4']
			}).addTo(map);

			// Catch lost focus on some form's inputs
			$( "#street, #zipcode, #city, #country" ).focusout(function() {
				if( $('#street').val() !='' && $('#zipcode').val() != '' && $('#city').val() != '' )
				{
					geocodeAddress();
				}
			});

			// bottstrap popover trigger manual, so need code to hide it
			$( "#locateAddress" ).focusout(function() {
				$('#locateAddress').popover('hide');
			});
			
			// Place the geomarker and some other map stuff
			createGeoMarker( $('#addrlat').val(), $('#addrlng').val() );

		});

		/**
		 * Center the map on address
		 */
		function centerOnMarker()
		{
			map.setView( geocodeMarker.getLatLng(), zoom);
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
			console.log('addr.length: '+addr.length);
			if( addr.length < 4 )
			{
				$('#locateAddress').popover('show');
			}
			if( addr.length == 0 )
			{
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
				// No result
				geocodeMarker.setIcon(iconGeolocNotFound);
				return ;
			}
			console.log('score: '+data[0].score);

			// pan the map and geomarker
			map.fitBounds(data[0].bbox);
			geocodeMarker.setLatLng(data[0].center);

			// update data
			$('#addrlat').val( data[0].center.lat );
			$('#addrlng').val( data[0].center.lng );

			geolocManual(false);

			if( data[0].score < 0.5 )
			{
				// Poor result
				geocodeMarker.setIcon(iconGeolocNotFound);
			}

		}

		function createGeoMarker( lat, lng )
		{
			var unknowPosition = false ;
			if( lat=='' && lng=='' )
			{
				unknowPosition = true ;
			}

			if( unknowPosition )
			{
				lat = map.getCenter().lat;
				lng = map.getCenter().lng;
			}

			geocodeMarker = new L.Marker( [lat, lng], {
				draggable: true
				})
			.on('dragend', geocodeMarkerOnDragEnd)
			.addTo(map);

			if( unknowPosition )
			{
				geocodeMarker.setIcon(iconGeolocNotFound);
			}
			else
			{
				geolocManual( geolocManual() );
				map.setView( geocodeMarker.getLatLng(), zoom);
			}

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
