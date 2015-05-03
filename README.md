# RentsPrices

**UNDER DEVELOPMENT !**

PrixDesLoyers permet de saisir les prix des loyers pour un logement année après années.

L'idée est de permettre des études à partir de données déclarées (crowdsourcing) puisque c'est le seul moyen de les obtenir.

# Installation

## Dependencies

Use "[composer](https://getcomposer.org/)".

## Web server

### nginx

	...
	# remove trailing slash, but not for homepage
	rewrite ^(.+)[/]$ $1 permanent;
	location / {
		try_files $uri $uri/ /index.php?$query_string ;
	}
	...
 