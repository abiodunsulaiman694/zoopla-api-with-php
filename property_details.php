<?php
// get ID of the property to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/property.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$property = new Property($db);
 
// set ID property of property to be read
$property->id = $id;
 
// read the details of property to be read
$property->readOne();
$page_title = "Property Details";
include_once "partials/header.php";
 
// read properties button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span>All Properties";
    echo "</a>";
    echo "&nbsp;<a href='update_property.php?id={$id}' class='btn btn-info '>";
        echo "<span class='glyphicon glyphicon-list'></span>Update Property";
    echo "</a>";
    echo "<a delete-id='{$id}' class='btn btn-danger delete-object'>
				    <span class='glyphicon glyphicon-remove'></span> Delete
				</a>";
echo "</div>";

// HTML table for displaying a property details
echo "<p>&nbsp;</p>";
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>County</td>";
        echo "<td>{$property->county}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Country</td>";
        echo "<td>{$property->country}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Town</td>";
        echo "<td>{$property->country}</td>";
    echo "</tr>";

    if ($property->source == "api") {
    	echo "<tr>";
	        echo "<td>Full Details</td>";
	        echo "<td><a href='{$property->full_details_url}' target='_blank'>View Full Details</a></td>";
    	echo "</tr>";
    } else {
    	echo "<tr>";
	        echo "<td>Postcode</td>";
	        echo "<td>{$property->postcode}</td>";
    	echo "</tr>";
    }
 

 
    echo "<tr>";
        echo "<td>Description</td>";
        echo "<td>{$property->description}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Address</td>";
        echo "<td>{$property->displayable_address}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Bedrooms</td>";
        echo "<td>{$property->bedrooms}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Bathrooms</td>";
        echo "<td>{$property->bathrooms}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>".
        number_format(($property->price/100), 2).
        "</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Type</td>";
        echo "<td>{$property->type}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Purpose</td>";
        echo "<td>";
        if ($property->purpose == "sale") {
    		echo "For Sale";
    	} elseif ($property->purpose == "rent") {
    		echo "For Rent";
    	}
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>Image</td>";
    echo "<td>";
        echo $property->image ? "<img src='{$property->image}' style='width:300px;' />" : "No image found.";
    echo "</td>";
echo "</tr>";
 
echo "</table>";
 
// set footer
include_once "partials/footer.php";
?>