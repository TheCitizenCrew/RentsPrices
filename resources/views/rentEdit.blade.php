
@extends('layout')

@section('title', 'Ajouter un loyer')

@section('content')

	<h1>Ajouter un loyer</h1>
    
	@if (! $errors->isEmpty())
	<p class="bg-warning">il y a des erreurs dans le formulaire.</p>
	@endif

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			@include('rentEdit-form')
		</div>
		<div class="col-md-6">
			@include('rentEdit-map')
		</div>
		</div>
</div>

@stop

