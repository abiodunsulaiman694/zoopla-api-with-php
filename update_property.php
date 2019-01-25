<?php
// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/property.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$property = new Property($db);
 
// set ID property of property to be edited
$property->id = $id;
 
// read the details of property to be edited
$property->readOne();
 
?>
<?php
 
// set page header
$page_title = "Update Property";
include_once "partials/header.php";
 
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>All Properties</a>";
echo "</div>";
?>
<?php 
// if the form was submitted
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

    if(!empty($_FILES["image"]["name"])) {
        $image = sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]);
		$property->image = $image;
    }

    // update the product
    if($property->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Product was updated. ";
            echo "<a href='property_details.php?id={$property->id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> View Details
                </a>";

        echo "</div>";
        // try to upload the submitted 
        if(!empty($_FILES["image"]["name"])) {
			echo $property->uploadImage();
        }
    }
 
    // if unable to update the product, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update product.";
        echo "</div>";
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">

    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>County</td>
            <td><input type='text' name='county' class='form-control' value='<?php echo $property->county; ?>' /></td>
        </tr>
 
        <tr>
            <td>Country</td>
            <td><input type='text' name='country' class='form-control' value='<?php echo $property->country; ?>' /></td>
        </tr>
 
        <tr>
            <td>Town</td>
            <td><input type='text' name='town' class='form-control' value='<?php echo $property->town; ?>' /></td>
        </tr>
 
        <tr>
            <td>Postcode</td>
            <td><input type='text' name='postcode' class='form-control' value='<?php echo $property->postcode; ?>' /></td>
        </tr>
 
        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'><?php echo $property->description; ?></textarea></td>
        </tr>
 
        <tr>
            <td>Displayable Address</td>
            <td><input type="text" name='displayable_address' class='form-control' value='<?php echo $property->displayable_address; ?>' /></td>
        </tr>
 
        <tr>
            <td>
            	Image
            	<?php
            		echo $property->image ? "<img src='uploads/{$property->image}' style='height:50px;' />" : "";
            	?>
        	</td>
            <td><input type='file' name='image' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Number of Bedrooms</td>
            <td>
            	<select name="bedrooms" class="form-control">
            		<?php for ($i=1; $i <= 10; $i++) { 
            			if ($property->bedrooms == $i) {
            				echo '<option value="'.$i.'" selected>'.$i.'</option>';
            			} else {
            				echo '<option value="'.$i.'">'.$i.'</option>';
            			}
            		} ?>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td>Number of Bathrooms</td>
            <td>
            	<select name="bathrooms" class="form-control">
            		<?php for ($i=1; $i <= 10; $i++) { 
            			if ($property->bathrooms == $i) {
            				echo '<option value="'.$i.'" selected>'.$i.'</option>';
            			} else {
            				echo '<option value="'.$i.'">'.$i.'</option>';
            			}
            		} ?>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' value='<?php echo number_format(($property->price/100), 2); ?>' /></td>
        </tr>
 
        <tr>
            <td>Property Type</td>
            <td>
            	<select name="type" class="form-control">
            		<option value="Apartment"
            		<?php
            		if ($property->type === "Apartment") {
            			echo "selected";
            		}
            		?>
            		>Apartment</option>
            		<option value="Bungalow"
            		<?php
            		if ($property->type === "Bungalow") {
            			echo "selected";
            		}
            		?>
            		>Bungalow</option>
            		<option value="Luxury"
            		<?php
            		if ($property->type === "Luxury") {
            			echo "selected";
            		}
            		?>
            		>Luxury</option>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td>For Sale/Rent</td>
            <td>
            	<select name="purpose" class="form-control">
            		<option value="sale"
            		<?php
            		if ($property->purpose === "sale") {
            			echo "selected";
            		}
            		?>
            		>For Sale</option>
            		<option value="rent"
            		<?php
            		if ($property->purpose === "rent") {
            			echo "selected";
            		}
            		?>
            		>For Rent</option>
            	</select>
            </td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update Property</button>
            </td>
        </tr>
 
    </table>
</form>

<?php
// set page footer
include_once "partials/footer.php";
?>