
@extends('layout')

@section('title', 'Ajouter un loyer')

@section('content')

	<div class="container-fluid">

	<h1>Ajouter un loyer</h1>

	@if (! $errors->isEmpty())
	<p class="bg-warning">il y a des erreurs dans le formulaire.</p>
	@endif

	@if(empty($rent->id))
		<form class="form-horizontal" method="POST" action="/rent">
		@else
		<form class="form-horizontal" method="POST" action="/rent/{{$rent->id}}">
		@endif
			<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			<input type="hidden" name="geolocManual" id="geolocManual" value="{{$rent->geolocManual}}" />

			<h2>Adresse</h2>

			<div class="form-group @if($errors->first('buildingIndividual'))has-error @endif">
				<div class="checkbox">
					<label class="control-label">
						<input type="radio" name="buildingIndividual" value="1" @if($rent->buildingIndividual==1) checked="checked" @endif />Logement collectif
					</label>
					<label class="control-label">
						<input type="radio" name="buildingIndividual" value="0" @if($rent->buildingIndividual==='0') checked="checked" @endif />Logement individuelle
					</label>
					<p class="help-block">La bâtiment héberge-t-il un (individuel) ou plusieurs logements (collectif).</p>
					@if ($errors->first('buildingIndividual'))
					<p class="text-danger">error {{$errors->first('buildingIndividual')}} </p>
					@endif				
				</div>
			</div>
			<div class="form-group @if($errors->first('buildingStage'))has-error @endif">
				<div class="row">
					<div class="col-xs-3">
						<label for="buildingStage" class="control-label">Étage</label>
						<input type="text" class="form-control" name="buildingStage" id="buildingStage" placeholder="L'étage de l'appartement" value="{{$rent->buildingStage}}" />
						@if ($errors->first('buildingStage'))
						<p class="text-danger">error {{$errors->first('buildingStage')}} </p>
						@endif
					</div>
				</div>
			</div>
			<div class="form-group @if($errors->first('buildingName'))has-error @endif">
				<label for="buildingName" class="control-label">Bâtiment</label>
				<input type="text" class="form-control" name="buildingName" id="buildingName" placeholder="Le numéro ou nom du bâtiment" value="{{$rent->buildingName}}" />
				@if ($errors->first('buildingName'))
				<p class="text-danger">error {{$errors->first('buildingName')}} </p>
				@endif
			</div>
			<div class="form-group @if($errors->first('street'))has-error @endif">
				<label for="street" class="control-label">Rue</label>
				<input type="text" class="form-control" name="street" id="street" placeholder="Le numéro et nom de la rue" value="{{$rent->street}}" />
				@if ($errors->first('street'))
				<p class="text-danger">error {{$errors->first('street')}} </p>
				@endif
			</div>
			<div class="form-group @if($errors->first('city'))has-error @endif">
				<label for="zipcode" class="control-label">Code postal</label>
				<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Le code postal"  value="{{$rent->zipcode}}" />
				@if ($errors->first('zipcode'))
				<p class="text-danger">error {{$errors->first('zipcode')}} </p>
				@endif
			</div>
			<div class="form-group">
				<label for="city" class="control-label">Ville</label>
				<input type="text" class="form-control" name="city" id="city" placeholder="La commune"  value="{{$rent->city}}" />
				@if ($errors->first('city'))
				<p class="text-danger">error {{$errors->first('city')}} </p>
				@endif
			</div>
			<div class="form-group">
				<label for="country" class="control-label">Pays</label>
				<input type="text" class="form-control" name="country" id="country" placeholder="Le Pays"  value="{{$rent->country}}" />
				@if ($errors->first('country'))
				<p class="text-danger">error {{$errors->first('country')}} </p>
				@endif
			</div>

			<p>La position géographique de l'adresse du logement a été calculée automatiquement.
			Vous pouvez la corriger en déplacement le marqueur bleu.<br/>
			<small>Le géocodage automatique ne fonctionne que pour la France métropolitaine, pour l'instant (cf. <a href="https://github.com/TheCitizenCrew/RentsPrices/issues/10">issue #10</a>)</small>.</p>

			@include('rentEdit-map')

			<div class="row">
				<div class="form-group col-md-3">
					<label for="addrlat" class="control-label">Lattitude</label>
					<input type="text" class="form-control" name="addrlat" id="addrlat" placeholder="latitude"  value="{{$rent->addrlat}}" />
					@if ($errors->first('addrlat'))
					<p class="text-danger">error {{$errors->first('addrlat')}} </p>
					@endif
				</div>
				<div class="form-group col-md-3">
					<label for="addrlng" class="control-label">Longitude</label>
					<input type="text" class="form-control" name="addrlng" id="addrlng" placeholder="longitude"  value="{{$rent->addrlng}}" />
					@if ($errors->first('addrlng'))
					<p class="text-danger">error {{$errors->first('addrlng')}} </p>
					@endif
				</div>
			</div>

			<h2>Loyers</h2>

			<p>Indiquez les loyers par année.</p>

			<div id="rents">
				<?php $rowsCount = 0 ; ?>
				@foreach($rent->prices as $price)
				<div  id="rentRow{{$rowsCount}}">
					<input type="hidden" name="rentprice[{{$rowsCount}}][id]" value="{{$price->id}}" />
					<fieldset class="row">
						
							<div class="form-group col-md-2">
								<label >Année</label>
								<input type="text" class="form-control" placeholder="L'année"
									name="rentprice[{{$rowsCount}}][year]" value="{{$price->year}}" />
								@if( $errors->first('year'.$rowsCount) )
									<p class="text-danger">error {{$errors->first('year'.$rowsCount)}} </p>
								@endif				
							</div>

							<div class="form-group col-md-2">
								<label >Prix mensuel</label>
								<input type="text" class="form-control" placeholder="Le prix mensuel"
									name="rentprice[{{$rowsCount}}][price]" value="{{$price->price}}" />
								@if( $errors->first('price'.$rowsCount) )
									<p class="text-danger">error {{$errors->first('price'.$rowsCount)}} </p>
								@endif				
							</div>
							<div class="form-group col-md-1">
								<button type="button" class="btn btn-default rentpriceTrash" data-rowcount="{{$rowsCount}}" aria-label="Left Align">
									<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
								</button>
							</div>
							
					</fieldset>
				</div>
				<?php $rowsCount ++ ; ?>
				@endforeach
		
				<button type="button" id="addRent" class="btn btn-default">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter une année</button>
			</div>
		
			<br/>
			<a href="/rent/{{$rent->id}}" class="btn btn-warning">Annuler</a>
			<button type="submit" class="btn btn-success">Enregistrer</button>
			
		</form>

	</div>

@stop

@section('javascript')
	@parent

	<script>
		$(function() {

			// add a rent button
			$('#addRent').on('click', function()
			{
				var n = $('#rents > div.row').size();
				// Clone the initial Rent's row div "#rentRow"
				var row = $('#rentRow0').clone();
				// Rename the input field "rentprice[0][xxx]"
				row.html( row.html().replace(/(rentprice\[)[0-9]+(\])/gm, '$1'+n+'$2') );
				// emptying all inputs fields value
				$('input', row).val(null);
				// Insert the copy into the DOM
				$(this).before( row.attr('id', 'rentRow' + n ) );
			});

			// Remove a RentPrice
			$('.rentpriceTrash').on('click', function()
			{
				var row = $('#rentRow' + $(this).data().rowcount );
				// The input for #id should be outside the fieldset !
				$('fieldset input', row).val(null);
				row.hide();
			});

		});
	</script>

@stop
