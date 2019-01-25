<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/property.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare product object
    $property = new Property($db);
     
    // set product id to be deleted
    $property->id = $_POST['property_id'];
     
    // delete the product
    if($property->delete()){
        echo "Property was deleted.";
    }
     
    // if unable to delete the product
    else{
        echo "Unable to delete object.";
    }
}
?>