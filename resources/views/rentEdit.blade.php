
@extends('layout')

@section('title', 'Ajouter un loyer')

@section('content')
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

		<h2>Adresse</h2>

		<div class="form-group">
			<div class="checkbox">
				<label>
					<input type="radio" name="buildingIndividual" value="1" @if($rent->buildingIndividual==1) checked="checked" @endif />Logement collectif
				</label>
				<label>
					<input type="radio" name="buildingIndividual" value="0" @if($rent->buildingIndividual==='0') checked="checked" @endif />Logement individuelle
				</label>
				<p class="help-block">La bâtiment héberge-t-il un (individuel) ou plusieurs logements (collectif).</p>
				@if ($errors->first('buildingIndividual'))
					<p class="text-danger">error {{$errors->first('buildingIndividual')}} </p>
				@endif				
			</div>
		</div>
		<div class="form-group">
			<label for="buildingStage">Étage</label>
			<input type="text" class="form-control" name="buildingStage" id="buildingStage" placeholder="L'étage de l'appartement" value="{{$rent->buildingStage}}" />
			@if ($errors->first('buildingStage'))
				<p class="text-danger">error {{$errors->first('buildingStage')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="buildingName">Bâtiment</label>
			<input type="text" class="form-control" name="buildingName" id="buildingName" placeholder="Le numéro ou nom du bâtiment" value="{{$rent->buildingName}}" />
			@if ($errors->first('buildingName'))
				<p class="text-danger">error {{$errors->first('buildingName')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="street">Rue</label>
			<input type="text" class="form-control" name="street" id="street" placeholder="Le numéro et nom de la rue" value="{{$rent->street}}" />
			@if ($errors->first('street'))
				<p class="text-danger">error {{$errors->first('street')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="zipcode">Code postal</label>
			<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Le code postal"  value="{{$rent->zipcode}}" />
			@if ($errors->first('zipcode'))
				<p class="text-danger">error {{$errors->first('zipcode')}} </p>
			@endif				
		</div>
		<div class="form-group">
			<label for="city">Ville</label>
			<input type="text" class="form-control" name="city" id="city" placeholder="La commune"  value="{{$rent->city}}" />
			@if ($errors->first('city'))
				<p class="text-danger">error {{$errors->first('city')}} </p>
			@endif				
		</div>

		<h2>Loyers</h2>

		<p>Vivamus fermentum semper porta. Nunc diam velit, adipiscing ut tristique vitae, sagittis vel odio. Maecenas convallis ullamcorper ultricies. Curabitur ornare, ligula semper consectetur sagittis, nisi diam iaculis velit, id fringilla sem nunc vel mi. Nam dictum, odio nec pretium volutpat.</p>

		<div class="container" id="rents">
			<?php $rowsCount = 0 ; ?>
			@forelse($rent->prices as $price)
				<div class="row" id="rentRow">
					<fieldset>
					<input type="hidden" name="rentprice[{{$rowsCount}}][id]" value="{{$price->id}}" />
						<div class="form-group">
							<div class="col-xs-2">
								<label >Année</label>
								<input type="text" class="form-control" placeholder="L'année"
									name="rentprice[{{$rowsCount}}][year]" value="{{$price->year}}" />
								@if( $errors->first('year'.$rowsCount) )
									<p class="text-danger">error {{$errors->first('year'.$rowsCount)}} </p>
								@endif				
							</div>
							<div class="col-xs-2">
								<label >Prix mensuel</label>
								<input type="text" class="form-control" placeholder="Le prix mensuel"
									name="rentprice[{{$rowsCount}}][price]" value="{{$price->price}}" />
								@if( $errors->first('price'.$rowsCount) )
									<p class="text-danger">error {{$errors->first('price'.$rowsCount)}} </p>
								@endif				
							</div>
						</div>
					</fieldset>
				</div>
				<?php $rowsCount ++ ; ?>
			@empty
				<div class="row" id="rentRow">
					<fieldset>
					<input type="hidden" name="rentprice[{{$rowsCount}}][id]" value="" />
						<div class="form-group">
							<div class="col-xs-2">
								<label >Année</label>
								<input type="text" class="form-control" placeholder="L'année"
									name="rentprice[{{$rowsCount}}][year]" value="" />
							</div>
							<div class="col-xs-2">
								<label >Prix mensuel</label>
								<input type="text" class="form-control" placeholder="Le prix mensuel"
									name="rentprice[{{$rowsCount}}][price]" value="" />
							</div>
						</div>
					</fieldset>
				</div>
			@endforelse

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
				// Clone the initial Rent's row div "#rentRow"
				var row = $('#rentRow').clone();
				// Rename the input field "rentprice[0][xxx]"
				row.html( row.html().replace(/(rentprice\[)[0-9]+(\])/gm, '$1'+n+'$2') );
				$('input', row).val(null);
				// Insert the copy into the DOM
				$(this).before( row.attr('id', 'rentRow' + n ) );
			});
		});
	</script>
@stop
