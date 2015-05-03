# RentsPrices

**UNDER DEVELOPMENT !**

"RentPrices" aka "PrixDesLoyers" permet de saisir les prix des loyers pour un logement année après années.

L'idée est de permettre des études à partir de données déclarées (crowdsourcing) puisque c'est le seul moyen de les obtenir.

## User view

RoadMap:

- [x] Choose frameworks
- [ ] Rent input
  - [ ] form for Rent & Rent Prices
    - [ ] Map location of the rent's address
- [ ] Display Rents
  - [ ] on a map
  - [ ] export data on query
  - [ ] statistics by years, places, ... 



## Tech view

### Installation

#### Dependencies

[Php](http://php.net), [Lumen](http://lumen.laravel.com), [CDNJs](https://cdnjs.com/), [Bootstrap](http://getbootstrap.com), [JQuery](http://jquery.com), [Leaflet](http://leafletjs.com/)
 
Use "[composer](https://getcomposer.org/)".

#### Web server

##### nginx

	...
	# remove trailing slash, but not for homepage
	rewrite ^(.+)[/]$ $1 permanent;
	location / {
		try_files $uri $uri/ /index.php?$query_string ;
	}
	...
 