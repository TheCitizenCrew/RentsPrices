'use strict';

function GeocoderAddOk(){};

GeocoderAddOk.prototype = {
	options: {
		serviceUrl: 'http://api-adresse.data.gouv.fr',
		limit: 6
	},

	initialize: function(options) {
		L.setOptions(this, options);
	},

	geocode: function(query, cb, context) {

		var params = L.extend({
			q: query,
			limit: this.options.limit
		}, this.options.geocodingQueryParams);
		var that = this ;
		this.getJSON(this.options.serviceUrl+'/search/', params, function(data) {
			var results = [],
				i,
				f,
				c,
				latLng,
				extent,
				bbox;
			if (data && data.features) {
				for (i = 0; i < data.features.length; i++) {
					f = data.features[i];
					c = f.geometry.coordinates;
					latLng = L.latLng(c[1], c[0]);
					extent = f.properties.extent;

					if (extent) {
						bbox = L.latLngBounds([extent[1], extent[0]], [extent[3], extent[2]]);
					} else {
						bbox = L.latLngBounds(latLng, latLng);
					}

					results.push({
						name: f.properties.name,
						score: f.properties.score,
						center: latLng,
						bbox: bbox
					});
				}
			}

			cb.call(context, results);
		});
	},

	suggest: function(query, cb, context) {
		return this.geocode(query, cb, context);
	},

	reverse: function(location, scale, cb, context) {
		var params = L.extend({
			lat: location.lat,
			lon: location.lng
		}, this.options.reverseQueryParams);
		var that = this ;
		this.getJSON(this.options.serviceUrl+'/reverse/', params, function(data) {
			var results = [],
				i,
				f,
				c,
				latLng,
				extent,
				bbox;
			if (data && data.features) {
				for (i = 0; i < data.features.length; i++) {
					f = data.features[i];
					c = f.geometry.coordinates;
					latLng = L.latLng(c[1], c[0]);
					extent = f.properties.extent;

					if (extent) {
						bbox = L.latLngBounds([extent[1], extent[0]], [extent[3], extent[2]]);
					} else {
						bbox = L.latLngBounds(latLng, latLng);
					}

					results.push({
						name: f.properties.name,
						center: latLng,
						bbox: bbox
					});
				}
			}

			cb.call(context, results);
		});
	},

	getJSON: function(url, params, callback) {
		var xmlHttp = new XMLHttpRequest();
		xmlHttp.onreadystatechange = function () {
			if (xmlHttp.readyState != 4){
				return;
			}
			if (xmlHttp.status != 200 && xmlHttp.status != 304){
				callback('');
				return;
			}
			callback(JSON.parse(xmlHttp.response));
		};
		xmlHttp.open( 'GET', url + L.Util.getParamString(params), true);
		xmlHttp.send(null);
	}

};
