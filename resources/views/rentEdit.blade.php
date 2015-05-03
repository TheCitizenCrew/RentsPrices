
@extends('layout')

@section('title', 'Ajouter un loyer')

@section('content')
    <h1>Ajouter un loyer</h1>
    
	@if (! $errors->isEmpty())
		<p class="bg-warning">il y a des erreurs dans le formulaire.</p>
	@endif				

	<form class="form-horizontal" method="POST">
		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

		<h2>Adresse</h2>

		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="radio" name="buildingIndividual" value="1" />Appartement
				</label>
				<label>
					<input type="radio" name="buildingIndividual" value="0" />Maison individuelle
				</label>
				<p class="help-block">S'il n'y a qu'un seul logement dans le bâtiment sélectionnez "maison individuelle".</p>
				@if ($errors->first('buildingIndividual'))
					<p class="text-danger">error {{$errors->first('buildingIndividual')}} </p>
				@endif				
			</div>
		</div>
		<div class="form-group">
			<label for="buildingStage">Étage</label>
			<input type="text" class="form-control" name="buildingStage" id="buildingStage" placeholder="L'étage de l'appartement">
			@if ($errors->first('buildingStage'))
				<p class="text-danger">error {{$errors->first('buildingStage')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="buildingName">Bâtiment</label>
			<input type="text" class="form-control" name="buildingName" id="buildingName" placeholder="Le numéro ou nom du bâtiment">
			@if ($errors->first('buildingName'))
				<p class="text-danger">error {{$errors->first('buildingName')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="street">Rue</label>
			<input type="text" class="form-control" name="street" id="street" placeholder="Le numéro et nom de la rue">
			@if ($errors->first('street'))
				<p class="text-danger">error {{$errors->first('street')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="zipcode">Code postal</label>
			<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Le code postal">
			@if ($errors->first('zipcode'))
				<p class="text-danger">error {{$errors->first('zipcode')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="city">Ville</label>
			<input type="text" class="form-control" name="city" id="city" placeholder="La commune">
			@if ($errors->first('city'))
				<p class="text-danger">error {{$errors->first('city')}} </p>
			@endif				
		</div>

		<h2>Loyers</h2>

		<p>Vivamus fermentum semper porta. Nunc diam velit, adipiscing ut tristique vitae, sagittis vel odio. Maecenas convallis ullamcorper ultricies. Curabitur ornare, ligula semper consectetur sagittis, nisi diam iaculis velit, id fringilla sem nunc vel mi. Nam dictum, odio nec pretium volutpat.</p>

		<div class="container" id="rents">
			<div class="row" id="rentRow">
				<div class="form-group">
					<div class="col-xs-2">
						<label >Année</label>
						<input type="text" class="form-control" name="years[]" placeholder="L'année">
					</div>
					<div class="col-xs-2">
						<label >Prix mensuel</label>
						<input type="text" class="form-control" name="prices[]" placeholder="Le prix mensuel">
					</div>
				</div>
			</div>
			<button type="button" id="addRent" class="btn btn-default">Ajouter une année</button>
		</div>

		<br/>
		<button type="submit" class="btn btn-default">Enregistrer</button>

	</form>

@stop

@section('javascript')
	@parent
	<script>
		$(function() {
			$('#addRent').on('click', function(){
				var n = $('#rents > div.row').size();
				$(this).before( $('#rentRow').clone().attr('id', n) );
			});
		});
	</script>
@stop
