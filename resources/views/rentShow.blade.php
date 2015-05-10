@extends('layout')

@section('title', 'Loyer '.$rent->id)

@section('css')
	@parent
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
	<style type="text/css">
		#map {
			width: 100%;
			height: 340px;
		}
	
	</style>
@stop

@section('content')

<h1>Logement</h1>

<h2>Adresse</h2>

<div class="row">
	<div class="col-md-6">
		<table class="table">
		<tr><td>Logement</td><td>@if($rent->buildingIndividual==1) collectif @else	individuel @endif</td></tr>
		<tr><td>Étage</td><td>{{$rent->buildingStage}}</td></tr>
		<tr><td>Nom</td><td>{{$rent->buildingName}}</td></tr>
		<tr><td>Rue</td><td>{{$rent->street}}</td></tr>
		<tr><td>Code postal</td><td>{{$rent->zipcode}}</td></tr>
		<tr><td>Ville</td><td>{{$rent->city}}</td></tr>
		<tr><td>Pays</td><td>{{$rent->country}}</td></tr>
		<tr><td>Latitude</td><td>{{$rent->addrlat}}</td></tr>
		<tr><td>Longitude</td><td>{{$rent->addrlng}}</td></tr>
		<tr><td>Créé le</td><td>{{$rent->created_at}}</td></tr>
		<tr><td>Mise à jour le</td><td>{{$rent->updated_at}}</td></tr>
		</table>
	</div>
	<div class="col-md-6">
		<div id="map"></div>
	</div>
</div>

<h2>Loyers</h2>

<table class="table">
@foreach($rent->prices as $rentPrice)
<tr><td>{{$rentPrice->year}}</td><td>{{$rentPrice->price}}</td></tr>
@endforeach
</table>
<a href="/rent/{{ $rent->id }}/edit"><button>Éditer</button></a>

@stop

@section('javascript')
	@parent
	<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>

	<script>

		var map, geocodeMarker,
			lat = {{$rent->addrlat}},
			lng = {{$rent->addrlng}};
		var zoom = 15 ;

		$(function() {

			// Construct the Lealfet Map

			map = L.map('map', {
				 loadingControl: true
			});
			//}).setView([lat, lng], zoom);
			// remove map's pane to avoid map moves while scrolling the page
			map.scrollWheelZoom.disable();
			map.touchZoom.disable();
			L.tileLayer('http://{s}.mqcdn.com/tiles/1.0.0/map/{z}/{x}/{y}.png', {
			    attribution: 'Data &copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://mapquest.com">MapQuest</a>-OSM Tiles',
			    subdomains: ['otile1','otile2', 'otile3', 'otile4']
			}).addTo(map);

			// Place the map on previously recorded location
			if( lat!=0 && lng!=0 )
			{
				createGeoMarker( lat, lng );
				map.setView( geocodeMarker.getLatLng(), zoom);
			}

		});

		function createGeoMarker( lat, lng )
		{
			geocodeMarker = new L.Marker( [lat, lng] )
			.addTo(map);
		}

	</script>

@stop
