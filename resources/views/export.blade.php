
@extends('layout')

@section('title', 'Exporter les données')

@section('content')

<h1>Export</h1>

<h2>Export des loyers</h2>

<p>Tous les logements avec leurs loyers au format :</p>
<ul>
<li><a href="/api/rentsExport/json">JSON</a></li>
</ul>

<p>Tous les loyers avec leur logement au format :</p>
<ul>
<li><a href="/api/rentsExport/csv">CSV</a></li>
</ul>

@stop
