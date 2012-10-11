/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function polymaps() {
	
	// Import the polymaps namespace into a variable (for convenience)
	var poly = org.polymaps;

	// A map instance retrieved via the constructor. 
	var map = poly.map()
	.container(document.getElementById("map").appendChild(poly.svg("svg")))
	.add(poly.interact())
    .add(poly.hash());
	// Use the map instance and insert into it a new SVG instance.
	// The new SVN instance will add a new element in the documet body.
	// Then add an image title layer.

    map.add(poly.image().url(poly.url("http://{S}tile.cloudmade.com"
							+ "/c3060cc966ce4cd89382d09b14e0d1eb" // http://cloudmade.com/register
							+ "/70184/256/{Z}/{X}/{Y}.png")
							.hosts(["a.", "b.", "c.", ""])));

	map.add(poly.compass()
    .pan("none"));

	// When passed with no arguments, Polymaps methods return the value of the associated field, rather than the instance.
	// This allows the method to serve both as a setter and a getter:
	//map.container();

}

/* http://cartographer.visualmotive.com/ */
function cartograph() {

	// Instance of Google Map
	var map = new GMap2( document.getElementById( "map" ) );

	// Colour ranges
	var options = { colors: [ "#000", "#999", "#00aaff" ] };
	
	var cartographer = Cartographer ( map, options );

	cartographer.choropleth([
	{region:"US-MN",val:0},
	{region:"US-IA",val:2},
	{region:"US-WI",val:4},
	{region:"US-SD",val:2},
	{region:"US-ND",val:0},
	{region:"US-MI",val:4},
	{region:"US-UT",val:2}
	], { colorScheme:"BuPu"});

}