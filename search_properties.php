<?php
include_once 'config/page_settings.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/property.php';
 
// instantiate database and property object
$database = new Database();
$db = $database->getConnection();
 
$property = new Property($db);
 
// get search term
$search_term=isset($_GET['search']) ? $_GET['search'] : '';
 
$page_title = "You searched for \"{$search_term}\". <a href='index.php' class='btn btn-primary'>View All Properties</a>";
include_once "partials/header.php";
 
// query properties
$stmt = $property->search($search_term, $from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url="search.php?search={$search_term}&";
 
// count total rows - used for pagination
$total_rows=$property->countAll_BySearch($search_term);

include_once "partials/read_properties.php";
include_once 'paginating.php';

include_once "partials/footer.php";
?>