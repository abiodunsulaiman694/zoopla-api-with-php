$(document).ready(function(){
 
    // fetch properties from zoopla on first load
    fetchProperties();
 
});

function fetchProperties()
{
	// get list of products from the API
	document.getElementById('results').innerHTML = '<div class="text-info text-center">Loading properties...</div>';
	$("#results").load("config/api.php");
	// $.getJSON("../config/api.php", function(data){
		 
	// });
}