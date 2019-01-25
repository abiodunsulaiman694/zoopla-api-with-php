<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/property.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$property = new Property($db);

$page_title = "Create Property";
include_once "partials/header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>View Properties</a>";
echo "</div>";
 
?>
<?php 
if($_POST){
 
    // set property values
    $property->county = $_POST['county'];
    $property->country = $_POST['country'];
    $property->town = $_POST['town'];
    $property->postcode = $_POST['postcode'];
    $property->description = $_POST['description'];
    $property->displayable_address = $_POST['displayable_address'];
    $property->bedrooms = $_POST['bedrooms'];
    $property->bathrooms = $_POST['bathrooms'];
    $property->price = $_POST['price'];
    $property->type = $_POST['type'];
    $property->purpose = $_POST['purpose'];

    $image=!empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";

	$property->image = $image;
 
    // create the property
    if($property->create()){
        echo "<div class='alert alert-success'>Property was created.</div>";
        // try to upload the submitted image
		echo $property->uploadImage();
    }
 
    // if unable to create the property, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>County</td>
            <td><input type='text' name='county' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Country</td>
            <td><input type='text' name='country' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Town</td>
            <td><input type='text' name='town' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Postcode</td>
            <td><input type='text' name='postcode' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>
 
        <tr>
            <td>Displayable Address</td>
            <td><input type="text" name='displayable_address' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Image</td>
            <td><input type='file' name='image' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Number of Bedrooms</td>
            <td>
            	<select name="bedrooms" class="form-control">
            		<?php for ($i=1; $i <= 10; $i++) { 
            			echo '<option value="'.$i.'">'.$i.'</option>';
            		} ?>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td>Number of Bathrooms</td>
            <td>
            	<select name="bathrooms" class="form-control">
            		<?php for ($i=1; $i <= 10; $i++) { 
            			echo '<option value="'.$i.'">'.$i.'</option>';
            		} ?>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Property Type</td>
            <td>
            	<select name="type" class="form-control">
            		<option value="Apartment">Apartment</option>
            		<option value="Bungalow">Bungalow</option>
            		<option value="Luxury">Luxury</option>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td>For Sale/Rent</td>
            <td>
            	<select name="purpose" class="form-control">
            		<option value="sale">For Sale</option>
            		<option value="rent">For Rent</option>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create Property</button>
            </td>
        </tr>
 
    </table>
</form>
<?php
 
// footer
include_once "partials/footer.php";
?>