
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
			<input type="hidden" name="id" id="id" value="{{$rent->id}}" />
			<input type="hidden" name="geolocManual" id="geolocManual" value="{{$rent->geolocManual}}" />

			<h2>Adresse</h2>

			<div class="form-group @if($errors->first('buildingIndividual'))has-error @endif">
				<label for="buildingIndividual" class="col-sm-1 control-label">Type</label>
				<div class="col-sm-6 checkbox">
					<label class="control-label">
						<input type="radio" name="buildingIndividual" value="1" @if($rent->buildingIndividual==1) checked="checked" @endif />Logement collectif
					</label>
					<label class="control-label">
						<input type="radio" name="buildingIndividual" value="0" @if($rent->buildingIndividual==='0') checked="checked" @endif />Logement individuelle
					</label>
					<span class="help-block">La bâtiment héberge-t-il un (individuel) ou plusieurs logements (collectif).</span>
				</div>
				@if ($errors->first('buildingIndividual'))
					<p class="text-danger">error {{$errors->first('buildingIndividual')}} </p>
				@endif				
			</div>
			
			<div class="form-group @if($errors->first('buildingHLM'))has-error @endif">
				<label for="buildingStage" class="col-sm-1 control-label">HLM</label>
				<div class="col-sm-5 checkbox">
					<label class="control-label">
						<input type="radio" name="buildingHLM" value="1" @if($rent->buildingHLM==1) checked="checked" @endif />Oui
					</label>
					<label class="control-label">
						<input type="radio" name="buildingHLM" value="0" @if($rent->buildingHLM==='0') checked="checked" @endif />Non
					</label>
					<span class="help-block">Est-ce un logement à loyer modéré ?</span>
				</div>
				@if ($errors->first('buildingHLM'))
					<p class="text-danger">error {{$errors->first('buildingHLM')}} </p>
				@endif				
			</div>

			<div class="form-group @if($errors->first('surfaceM2'))has-error @endif">
					<label for="surfaceM2" class="col-sm-1 control-label">Surface en m2</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="surfaceM2" id="surfaceM2" placeholder="Surface du logement" value="{{$rent->surfaceM2}}" />
					</div>
					@if ($errors->first('surfaceM2'))
						<p class="text-danger">error {{$errors->first('surfaceM2')}} </p>
					@endif
			</div>

			<div class="form-group @if($errors->first('roomsCount'))has-error @endif">
					<label for="roomsCount" class="col-sm-1 control-label">Nb.&nbsp;de pièces</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="roomsCount" id="roomsCount" placeholder="Nombre de pièces du logement" value="{{$rent->roomsCount}}" />
					</div>
					@if ($errors->first('roomsCount'))
						<p class="text-danger">error {{$errors->first('roomsCount')}} </p>
					@endif
			</div>

			<div class="form-group @if($errors->first('kitchenRoom'))has-error @endif">
				<label for="kitchenRoom" class="col-sm-1 control-label">Une&nbsp;pièce cuisine</label>
				<div class="col-sm-5 checkbox">
					<label class="control-label">
						<input type="radio" name="kitchenRoom" value="1" @if($rent->kitchenRoom==1) checked="checked" @endif />Oui
					</label>
					<label class="control-label">
						<input type="radio" name="kitchenRoom" value="0" @if($rent->kitchenRoom==='0') checked="checked" @endif />Non
					</label>
					<span class="help-block">La cuisine est-elle une pièce dédiée ?</span>
				</div>
				@if ($errors->first('kitchenRoom'))
					<p class="text-danger">error {{$errors->first('kitchenRoom')}} </p>
				@endif				
			</div>

			<div class="form-group @if($errors->first('buildingStage'))has-error @endif">
					<label for="buildingStage" class="col-sm-1 control-label">Étage</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="buildingStage" id="buildingStage" placeholder="L'étage du logement" value="{{$rent->buildingStage}}" />
					</div>
					@if ($errors->first('buildingStage'))
						<p class="text-danger">error {{$errors->first('buildingStage')}} </p>
					@endif
			</div>

			<div class="form-group @if($errors->first('buildingName'))has-error @endif">
				<label for="buildingName" class="col-sm-1 control-label">Bâtiment</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" name="buildingName" id="buildingName" placeholder="Numéro ou nom du bâtiment" value="{{$rent->buildingName}}" />
				</div>
				@if ($errors->first('buildingName'))
					<p class="text-danger">error {{$errors->first('buildingName')}} </p>
				@endif
			</div>
			
			<div class="form-group @if($errors->first('street'))has-error @endif">
				<label for="street" class="col-sm-1 control-label">Rue</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="street" id="street" placeholder="Numéro et nom de la rue" value="{{$rent->street}}" />
				</div>
				@if ($errors->first('street'))
					<p class="text-danger">error {{$errors->first('street')}} </p>
				@endif
			</div>

			<div class="form-group @if($errors->first('city'))has-error @endif">
				<label for="zipcode" class="col-sm-1 control-label">Code postal</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Code postal"  value="{{$rent->zipcode}}" />
				</div>
				@if ($errors->first('zipcode'))
					<p class="text-danger">error {{$errors->first('zipcode')}} </p>
				@endif
			</div>

			<div class="form-group">
				<label for="city" class="col-sm-1 control-label">Ville</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="city" id="city" placeholder="Commune" value="{{$rent->city}}" />
				</div>
				@if ($errors->first('city'))
					<p class="text-danger">error {{$errors->first('city')}} </p>
				@endif
			</div>

			<div class="form-group">
				<label for="country" class="col-sm-1 control-label">Pays</label>
				<div class="col-sm-8">
					<input type="text" class="form-control" name="country" id="country" placeholder="Le Pays" value="{{$rent->country}}" />
				</div>
				@if ($errors->first('country'))
					<p class="text-danger">error {{$errors->first('country')}} </p>
				@endif
			</div>

			<p>La position géographique de l'adresse du logement a été calculée automatiquement.
			Vous pouvez la corriger en déplacement le marqueur bleu.<br/>
			<small>Le géocodage automatique ne fonctionne que pour la France métropolitaine, pour l'instant (cf. <a href="https://github.com/TheCitizenCrew/RentsPrices/issues/10">issue #10</a>)</small>.</p>

			@include('rentEdit-map')


				<div class="form-group">
					<label for="addrlat" class="col-sm-1 control-label">Lattitude</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="addrlat" id="addrlat" placeholder="latitude"  value="{{$rent->addrlat}}" />
					</div>
					@if ($errors->first('addrlat'))
					<p class="text-danger">error {{$errors->first('addrlat')}} </p>
					@endif
				</div>
				<div class="form-group">
					<label for="addrlng" class="col-sm-1 control-label">Longitude</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="addrlng" id="addrlng" placeholder="longitude"  value="{{$rent->addrlng}}" />
					</div>
					@if ($errors->first('addrlng'))
					<p class="text-danger">error {{$errors->first('addrlng')}} </p>
					@endif
				</div>

			<h2>Loyers</h2>

			<p>Saisie des loyers.</p>

			<div id="rents">
				<?php $rowsCount = 0 ; ?>
				@foreach($rent->prices as $price)
				<div id="rentRow{{$rowsCount}}" class="form-group">
					<input type="hidden" name="rentprice[{{$rowsCount}}][id]" value="{{$price->id}}" /></form>
					<fieldset>
						<div class="col-sm-12">
							<div class="form-group row">

								<div class="col-sm-2">
									<label >Année</label>
									<input type="text" class="form-control" placeholder="L'année"
										name="rentprice[{{$rowsCount}}][year]" value="{{$price->year}}" />
									@if( $errors->first('year'.$rowsCount) )
										<p class="text-danger">error {{$errors->first('year'.$rowsCount)}} </p>
									@endif				
								</div>
	
								<div class="col-sm-2">
									<label>Mois</label>
									<input type="text" class="form-control" placeholder="Le mois"
										name="rentprice[{{$rowsCount}}][month]" value="{{$price->month}}" />
									@if( $errors->first('month'.$rowsCount) )
										<p class="text-danger">error {{$errors->first('month'.$rowsCount)}} </p>
									@endif
								</div>

								<div class="col-sm-2">
									<label>Loyer</label>
									<input type="text" class="form-control" placeholder="Le prix mensuel"
										name="rentprice[{{$rowsCount}}][price]" value="{{$price->price}}" />
									@if( $errors->first('price'.$rowsCount) )
										<p class="text-danger">error {{$errors->first('price'.$rowsCount)}} </p>
									@endif
								</div>

								<div class="col-sm-1">
									<button type="button" class="btn btn-default rentpriceTrash" data-rowcount="{{$rowsCount}}" aria-label="Left Align">
										<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
									</button>
								</div>

							</div>

							<div class="form-group row">
							
								<div class="col-sm-2">
									<label>Charges</label>
									<input type="text" class="form-control" placeholder="Les charges"
										name="rentprice[{{$rowsCount}}][loads]" value="{{$price->loads}}" />
									@if( $errors->first('loads'.$rowsCount) )
										<p class="text-danger">error {{$errors->first('loads'.$rowsCount)}} </p>
									@endif
								</div>
								<div class="col-sm-2">
									<label>Autres Charges</label>
									<input type="text" class="form-control" placeholder="Autres charges"
										name="rentprice[{{$rowsCount}}][loadsOther]" value="{{$price->loadsOther}}" />
									@if( $errors->first('loadsOther'.$rowsCount) )
										<p class="text-danger">error {{$errors->first('loadsOther'.$rowsCount)}} </p>
									@endif
								</div>
								<div class="col-sm-4">
									<label>Description autres Charges</label>
									<input type="text" class="form-control" placeholder="Description autres charges"
										name="rentprice[{{$rowsCount}}][loadsOtherText]" value="{{$price->loadsOtherText}}" />
									@if( $errors->first('loadsOtherText'.$rowsCount) )
										<p class="text-danger">error {{$errors->first('loadsOtherText'.$rowsCount)}} </p>
									@endif
								</div>

							</div>

						</div>
					</fieldset>
					<hr/>
				</div>
				<?php $rowsCount ++ ; ?>
				@endforeach

				<button type="button" id="addRent" class="btn btn-default">
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Ajouter un loyer</button>
			</div>

			<br/>
			<a href="@if($rent->id > 0) {{ app('url')->route('RentShow',array('id'=>$rent->id)) }} @else {{ app('url')->route('Home') }} @endif" class="btn btn-warning">Annuler</a>
			<button type="submit" class="btn btn-success">Enregistrer</button>

		</form>

	</div>

@stop

@section('javascript')
	@parent

	<script>
		"use strict" ;

		$(function() {

			// add a rent button
			$('#addRent').on('click', function()
			{
				var n = $('#rents > div').size();
				// Clone the initial Rent's row div "#rentRow"
				var row = $('#rentRow0').clone();
				row.attr('id', 'rentRow' + n );
				// Rename the input field "rentprice[0][xxx]"
				row.html( row.html().replace(/(rentprice\[)[0-9]+(\])/gm, '$1'+n+'$2') );
				// emptying all inputs fields value
				$('input', row).val(null);
				// Insert the copy into the DOM
				$(this).before( row );
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
