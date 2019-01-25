<?php
// include database and object files
include_once 'database.php';
include_once '../objects/property.php';
include_once '../config/page_settings.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

	$api_key = "j5arw3whftn3rkktg82veyjy";
	$postcode = "AB10";
	$api_endpoint = "https://api.zoopla.co.uk/api/v1/property_listings.json";

    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $api_endpoint."?postcode=".$postcode."&api_key=".$api_key,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_TIMEOUT => 30000,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET"
    )
);
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
	echo $errMessage = "Error fetching API";
	//return;
} else {
    $json_response = json_decode($response);
    if ($json_response && $json_response->listing) {
    	$listings = $json_response->listing;
    	foreach ($listings as $listing) {
			$property = new Property($db);
			$property->county = $listing->county;
		    $property->country = $listing->country;
		    $property->town = $listing->post_town;
		    $property->description = $listing->description;
		    $property->full_details_url = $listing->details_url;
		    $property->displayable_address = $listing->displayable_address;
		    $property->image = $listing->image_url;
		    $property->thumbnail_url = $listing->thumbnail_url;
		    $property->latitude = $listing->latitude;
		    $property->longitude = $listing->latitude;
		    $property->bedrooms = $listing->num_bedrooms;
		    $property->bathrooms = $listing->num_bathrooms;
		    $property->price = $listing->price;
		    $property->type = $listing->property_type;
		    $property->purpose = $listing->listing_status;
		    $property->listing_id = $listing->listing_id;

    		$found = $property->findByListingId($listing->listing_id);
    		if (!$found) {
    			$property->createFromApi();
    		} else {
    			$property->updateFromApi($listing->listing_id);
    		}

    	}
    }

}
$stmt = $property->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();
$total_rows = $property->countAll();
$page_url = "index.php?";
include_once "../partials/read_properties.php";
include_once '../paginating.php';