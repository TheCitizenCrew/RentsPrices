"use strict" ;

var iconGeolocAuto = new L.Icon({
	iconUrl: '/img/marker-leaf-green2.png',
	iconSize: new L.Point(64, 64),
	iconAnchor: [10, 62],
	shadowUrl: '/img/marker-leaf-shadow.png',
	shadowSize: [50, 44],
	shadowAnchor: [0, 48]
});
var iconGeolocManual = new L.Icon({
	iconUrl: '/img/marker-leaf-yellow2.png',
	iconSize: new L.Point(64, 64),
	iconAnchor: [10, 62],
	shadowUrl: '/img/marker-leaf-shadow.png',
	shadowSize: [50, 44],
	shadowAnchor: [0, 48]
});
var iconGeolocNotFound = new L.Icon({
	iconUrl: '/img/marker-leaf-red2.png',
	iconSize: new L.Point(64, 64),
	iconAnchor: [10, 62],
	shadowUrl: '/img/marker-leaf-shadow.png',
	shadowSize: [50, 44],
	shadowAnchor: [0, 48]
});
