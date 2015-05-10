# RentsPrices

**! Work in progress !**

![Work in progress][workInProgressImage]

[![Code Climate](https://codeclimate.com/github/TheCitizenCrew/RentsPrices/badges/gpa.svg)](https://codeclimate.com/github/TheCitizenCrew/RentsPrices)
[![Test Coverage](https://codeclimate.com/github/TheCitizenCrew/RentsPrices/badges/coverage.svg)](https://codeclimate.com/github/TheCitizenCrew/RentsPrices)

"RentPrices" aka "PrixDesLoyers" permet de saisir les prix des loyers pour un logement année après années.

L'idée est de permettre des études à partir de données déclarées (crowdsourcing) puisque c'est le seul moyen de les obtenir.

## RoadMap

- [x] Choose frameworks
- [x] Rent input
  - [x] form for Rent & Rent Prices [#1](https://github.com/TheCitizenCrew/RentsPrices/issues/1) [#2](https://github.com/TheCitizenCrew/RentsPrices/issues/2)
  - [x] Map location of the rent's address
- [ ] Display Rents
  - [x] on a map
  - [ ] export data on query
  - [ ] statistics by years, places, ... 


## Installation

### Dependencies

[Php](http://php.net), [Lumen](http://lumen.laravel.com), [CDNJs](https://cdnjs.com/), [Bootstrap](http://getbootstrap.com), [JQuery](http://jquery.com), [Leaflet](http://leafletjs.com/)
 
Use "[composer](https://getcomposer.org/)".

### Web server

#### nginx

	...
	location / {
		try_files $uri $uri/ /index.php?$query_string ;
	}
	...


[workInProgressImage]: http://upload.wikimedia.org/wikipedia/commons/thumb/2/26/Work_in_progress_%283709389075%29.jpg/320px-Work_in_progress_%283709389075%29.jpg?raw=true
 
