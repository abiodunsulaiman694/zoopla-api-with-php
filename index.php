<?php
// include database and object files
include_once 'config/page_settings.php';
include_once 'config/database.php';
include_once 'objects/property.php';
 
// instantiate database and objects
$database = new Database();
$db = $database->getConnection();
 
$property = new Property($db);

if ($page != 1 || isset($_GET['search'])) {
	// query properties
	$stmt = $property->readAll($from_record_num, $records_per_page);
	$num = $stmt->rowCount();
	$page_url = "index.php?";
}

$page_title = "All Properties";
include_once "partials/header.php";

if ($page == 1 && !isset($_GET['search'])) {
	echo '<script src="js/fetchProducts.js"></script>';
} else {
	$total_rows = $property->countAll();
	include_once "partials/read_properties.php";
	include_once 'paginating.php';
}

//page footer
?>
<?php
include_once "partials/footer.php";
?>