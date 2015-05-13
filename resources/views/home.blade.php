
@extends('layout')

@section('title', 'Prix des loyers')

@section('content')

<p class="bg-primary">La base de données contient <span id="rentsCount"...></span> logements et <span id="rentPricesCount">...</span> loyers.</p>

	@include('home-map')

@stop

@section('javascript')
	@parent
	<script>
	"use strict" ;

	$(function() {
		$.getJSON( '/api/rentsCount', function( data ) {
			$('#rentsCount').text( data.rentsCount );
			$('#rentPricesCount').text( data.rentPricesCount );
		});
	});
	</script>
@stop
