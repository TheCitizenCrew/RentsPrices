@extends('layout')

@section('title', 'Loyer '.$rent->id)

@section('content')

<table>
<tr><td>Logement</td><td>@if($rent->buildingIndividual==1) collectif @else	individuel @endif</td></tr>
<tr><td>Étage</td><td>{{$rent->buildingStage}}</td></tr>
<tr><td>Nom</td><td>{{$rent->buildingName}}</td></tr>
<tr><td>Rue</td><td>{{$rent->street}}</td></tr>
<tr><td>Code postal</td><td>{{$rent->zipcode}}</td></tr>
<tr><td>Ville</td><td>{{$rent->city}}</td></tr>
<tr><td>Créé le</td><td>{{$rent->created_at}}</td></tr>
<tr><td>Mise à jour le</td><td>{{$rent->updated_at}}</td></tr>
</table>

<table>
@foreach($rent->prices as $rentPrice)
<tr><td>{{$rentPrice->year}}</td><td>{{$rentPrice->price}}</td></tr>
@endforeach
</table>
<a href="/rent/{{ $rent->id }}/edit"><button>Éditer</button></a>

@stop
