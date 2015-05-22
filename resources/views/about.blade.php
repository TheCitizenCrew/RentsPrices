
@extends('layout')

@section('title', 'Ajouter un loyer')

@section('content')
<h1>À propos</h1>

<p>Cette application permet de récolter et partager les prix des loyers (en France pour l'instant).</p>

<h2>Mentions Légales</h2>

<h3>Contribution au service</h3>

<p>En contribuant à ce service de récolte et de partage des prix des loyers, vous accepter toutes les conditions exprimées ci-suit.</p>

<p>Si vous rencontrez des problèmes techniques ou fonctionnels vous pouvez en faire part via l'outil de gestion d'anomalies gracieusement mit à disposition par GitHub : <a href="https://github.com/TheCitizenCrew/RentsPrices/issues">github.com/TheCitizenCrew/RentsPrices/issues</a>.</p>

<p>Les seuls cookies qui sont déposés dans votre navigateur sont des cookies de session expirant quand vous quittez le site. Les données des cookies sont uniquement stockées sur votre navigateur.</p>

<p>Les seules données conservées sur la machine faisant fonctionner le service sont:</p>
<ul>
	<li>Les données de logements et loyers saisies par les contributeurs anonymes</li>
	<li>Les "logs" du logiciel serveur HTTP contenant pour chaque requête au service: l'url de la requête, la date et l'adresse client du protocole Internet (IP).</li>
</ul>

<h3>Droits propriété, de réutilisation et de distribution</h3>

<p>Les contenus, les données et le programme constituant ce service de récolte des prix des loyers sont partagés et protégés selon ces termes :</p>
<ul>
<li><img src="https://s.yimg.com/pw/images/cc_icon_attribution.gif.v2" /> <strong>Paternité</strong>: vous devez citer l'auteur originale: TheCitizenCrew's Contributors.</li>
<li><img src="https://s.yimg.com/pw/images/cc_icon_sharealike.gif.v2" /> <strong>Partage selon les Conditions Initiales</strong>: vous pouvez redistribuer ces contenus, données et programme orginaux ou modifiés sous un contrat identique à celui-ci.</li>
</ul>

<p>En utilisant les outils juridiques que sont les licences suivantes :</p>

<div class="panel panel-default">
  <div class="panel-heading">Les contenus</div>
  <div class="panel-body">
		<p>Les contenus de cette application sont partagées et protégées par 
		<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">
		Licence Creative Commons Attribution -  Partage dans les Mêmes Conditions 4.0 International</a> <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">
		<img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a>.
		</p>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Les données</div>
  <div class="panel-body">
		<p>Les données récoltées et stockées par cette application sont partagées et protégées par
		<a rel="license" href="http://opendatacommons.org/licenses/odbl/">
		 Open Database License</a> <a rel="license" href="http://opendatacommons.org/licenses/odbl/">
		<img alt="Open Database License" style="border-width:0" height="36px" src="/img/odbl_logo.png" /></a>.
		</p>
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Le programme</div>
  <div class="panel-body">
		<p>Le programme de cette application est partagé et protégé par le contrat
		<a rel="license" href="http://www.gnu.org/licenses/gpl-3.0.txt">
		 GNU GENERAL PUBLIC LICENSE version 3</a> <a rel="license" href="http://www.gnu.org/licenses/gpl-3.0.txt">
		<img alt="GNU GENERAL PUBLIC LICENSE version 3" style="border-width:0" src="https://www.gnu.org/graphics/gplv3-127x51.png" height="36px" /></a>.
		</p>
		<p>Le code source est disponible sur GitHub : <a href="https://github.com/TheCitizenCrew/RentsPrices">github.com/TheCitizenCrew/RentsPrices</a>.
		</p>
  </div>
</div>

<h3>Autres ayants droit</h3>

<div class="panel panel-default">
  <div class="panel-heading">Le fond de carte</div>
  <div class="panel-body">
		<p>Les tuiles composant le fond de carte sont mises gracieusement à disposition par la société <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png"></p>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">Technologies informatiques</div>
  <div class="panel-body">
		<p>
		Le programme est écrit avec le langage <a href="http://php.net">PHP</a> et basé sur le cadre logiciel <a href="http://lumen.laravel.com/">Laravel / Lumen</a>.
		De nombreux autres composants logiciels sont utilisés dont vous pourrez trouver la liste dans le fichier <a href="https://github.com/TheCitizenCrew/RentsPrices/blob/master/README.md">README</a> de l'application. 
		</p>
  </div>
</div>

<h3>Contacts</h3>

<p>Ce site est un service de communication au public en ligne édité par le collectif TheCitizenCrew à titre non professionnel au sens de l’article 6, III, 1° de la loi 2004-575 du 21 juin 2004.</p>

<p>Le contact du collectif TheCitizenCrew est Cyrille Giquello joignable par email cyrille <i>arobase</i> giquello <i>point</i> fr ou par téléphone 06 32 33 02 18.</p>

<p>La machine nécessaire au fonctionnement de ce service est louée à la société <a href="http://ovh.fr">OVH</a>.</p>

@stop
