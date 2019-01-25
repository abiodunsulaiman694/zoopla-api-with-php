<?php
class Property{
 
    private $conn;
    private $table_name = "properties";
 
    // model properties
    public $id;
    public $county;
    public $country;
    public $town;
    public $postcode;
    public $full_details_url;
    public $description;
    public $displayable_address;
    public $image;
    public $thumbnail_url;
    public $bedrooms;
    public $bathrooms;
    public $price;
    public $type;
    public $purpose;
    public $source;
    public $listing_id;
    public $created_at;
    public $updated_at;
 
    public function __construct($db){
        $this->conn = $db;
    }
    function clean_numbers($dirty) {
        $unwanteds = [",", " ", "#", "N", "GBP"];
        $cleaned = str_replace($unwanteds, "", $dirty);
        return $cleaned;
    }
 
    function create(){
 
        //sql
        if (isset($this->image) && ($this->image != "")) {
            $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    county=:county,
                    country=:country,
                    town=:town,
                    postcode=:postcode,
                    description=:description,
                    displayable_address=:displayable_address,
                    bedrooms=:bedrooms,
                    bathrooms=:bathrooms,
                    price=:price,
                    type=:type,
                    purpose=:purpose,
                    source=:source,
                    image=:image";
        } else {
            $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    county=:county,
                    country=:country,
                    town=:town,
                    postcode=:postcode,
                    description=:description,
                    displayable_address=:displayable_address,
                    bedrooms=:bedrooms,
                    bathrooms=:bathrooms,
                    price=:price,
                    type=:type,
                    purpose=:purpose,
                    source=:source";
        }
        
        $stmt = $this->conn->prepare($query);
 
        // posted values
        $this->county=htmlspecialchars(strip_tags($this->county));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->town=htmlspecialchars(strip_tags($this->town));
        $this->postcode=htmlspecialchars(strip_tags($this->postcode));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->displayable_address=htmlspecialchars(strip_tags($this->displayable_address));
        $this->bedrooms=htmlspecialchars(strip_tags($this->bedrooms));
        $this->bathrooms=htmlspecialchars(strip_tags($this->bathrooms));
        //clean price and convert to pennies
        $this->price=$this->clean_numbers(htmlspecialchars(strip_tags($this->price)))*100;
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->purpose=htmlspecialchars(strip_tags($this->purpose));
        $this->source = 'admin';
        if (isset($this->image) && ($this->image != "")) {
            $this->image='uploads/'.htmlspecialchars(strip_tags($this->image));
        }
        // bind values 
        $stmt->bindParam(":county", $this->county);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":postcode", $this->postcode);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":displayable_address", $this->displayable_address);
        $stmt->bindParam(":bedrooms", $this->bedrooms);
        $stmt->bindParam(":bathrooms", $this->bathrooms);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":purpose", $this->purpose);
        $stmt->bindParam(":source", $this->source);
        if (isset($this->image) && ($this->image != "")) {
            $stmt->bindParam(":image", $this->image);
        }
 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }
 
    function createFromApi(){
 
        //sql
            $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    county=:county,
                    country=:country,
                    town=:town,
                    full_details_url=:full_details_url,
                    description=:description,
                    displayable_address=:displayable_address,
                    image=:image,
                    thumbnail_url=:thumbnail_url,
                    latitude=:latitude,
                    longitude=:longitude,
                    bedrooms=:bedrooms,
                    bathrooms=:bathrooms,
                    price=:price,
                    type=:type,
                    purpose=:purpose,
                    listing_id=:listing_id,
                    source=:source";
        
        $stmt = $this->conn->prepare($query);
 
        // posted values
        $this->county=htmlspecialchars(strip_tags($this->county));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->town=htmlspecialchars(strip_tags($this->town));
        $this->full_details_url=htmlspecialchars(strip_tags($this->full_details_url));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->displayable_address=htmlspecialchars(strip_tags($this->displayable_address));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->thumbnail_url=htmlspecialchars(strip_tags($this->thumbnail_url));
        $this->latitude=htmlspecialchars(strip_tags($this->latitude));
        $this->longitude=htmlspecialchars(strip_tags($this->longitude));
        $this->bedrooms=htmlspecialchars(strip_tags($this->bedrooms));
        $this->bathrooms=htmlspecialchars(strip_tags($this->bathrooms));
        //clean price and convert to pennies
        $this->price=$this->clean_numbers(htmlspecialchars(strip_tags($this->price)))*100;
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->purpose=htmlspecialchars(strip_tags($this->purpose));
        $this->listing_id=htmlspecialchars(strip_tags($this->listing_id));
        $this->source = 'api';
        // bind values 
        $stmt->bindParam(":county", $this->county);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":full_details_url", $this->full_details_url);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":displayable_address", $this->displayable_address);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":thumbnail_url", $this->thumbnail_url);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":bedrooms", $this->bedrooms);
        $stmt->bindParam(":bathrooms", $this->bathrooms);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":purpose", $this->purpose);
        $stmt->bindParam(":listing_id", $this->listing_id);
        $stmt->bindParam(":source", $this->source);
 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }
    function readAll($from_record_num, $records_per_page){
 
        $query = "SELECT
                    id, county, country, town, postcode, description, displayable_address, postcode, image, bedrooms, bathrooms, price, type, purpose, source, created_at, updated_at, thumbnail_url
                FROM
                    " . $this->table_name . "
                ORDER BY
                    updated_at DESC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        return $stmt;
    }
    // used for pagination
    public function countAll(){
     
        $query = "SELECT id FROM " . $this->table_name . "";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
     
        $num = $stmt->rowCount();
     
        return $num;
    }
    function readOne(){
 
        $query = "SELECT
                    id, county, country, town, image, postcode, description, displayable_address, postcode, image, bedrooms, bathrooms, price, type, purpose, source, created_at, updated_at, thumbnail_url, full_details_url
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
     
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            //return 404
        }
     
        $this->county=$row['county'];
        $this->country=$row['country'];
        $this->town=$row['town'];
        $this->postcode=$row['postcode'];
        $this->description=$row['description'];
        $this->displayable_address=$row['displayable_address'];
        $this->bedrooms=$row['bedrooms'];
        $this->bathrooms=$row['bathrooms'];
        $this->price=$row['price'];
        $this->type=$row['type'];
        $this->purpose=$row['purpose'];
        $this->source = $row['source'];
        $this->image = $row['image'];
        $this->full_details_url = $row['full_details_url'];
        $this->thumbnail_url = $row['thumbnail_url'];
    }
    function findByListingId($listing_id){
 
        $query = "SELECT
                    id, listing_id
                FROM
                    " . $this->table_name . "
                WHERE
                    listing_id = ?
                LIMIT
                    0,1";
     
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $listing_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    function update(){
 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    county=:county,
                    country=:country,
                    town=:town,
                    postcode=:postcode,
                    description=:description,
                    displayable_address=:displayable_address,
                    bedrooms=:bedrooms,
                    bathrooms=:bathrooms,
                    price=:price,
                    type=:type,
                    purpose=:purpose,
                    source=:source,
                    image=:image
                WHERE
                    id = :id";
     
        $stmt = $this->conn->prepare($query);
     
        // posted values
        $this->county=htmlspecialchars(strip_tags($this->county));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->town=htmlspecialchars(strip_tags($this->town));
        $this->postcode=htmlspecialchars(strip_tags($this->postcode));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->displayable_address=htmlspecialchars(strip_tags($this->displayable_address));
        $this->bedrooms=htmlspecialchars(strip_tags($this->bedrooms));
        $this->bathrooms=htmlspecialchars(strip_tags($this->bathrooms));
        //clean price and convert to pennies
        $this->price=$this->clean_numbers(htmlspecialchars(strip_tags($this->price)))*100;
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->purpose=htmlspecialchars(strip_tags($this->purpose));
        $this->source = 'admin';
        $this->image='uploads/'.htmlspecialchars(strip_tags($this->image));
        $this->id=htmlspecialchars(strip_tags($this->id));
     
        // bind parameters
        $stmt->bindParam(":county", $this->county);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":postcode", $this->postcode);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":displayable_address", $this->displayable_address);
        $stmt->bindParam(":bedrooms", $this->bedrooms);
        $stmt->bindParam(":bathrooms", $this->bathrooms);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":purpose", $this->purpose);
        $stmt->bindParam(":source", $this->source);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(':id', $this->id);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    function updateFromApi($listing_id){
 
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    county=:county,
                    country=:country,
                    town=:town,
                    full_details_url=:full_details_url,
                    description=:description,
                    displayable_address=:displayable_address,
                    image=:image,
                    thumbnail_url=:thumbnail_url,
                    latitude=:latitude,
                    longitude=:longitude,
                    bedrooms=:bedrooms,
                    bathrooms=:bathrooms,
                    price=:price,
                    type=:type,
                    purpose=:purpose
                WHERE
                    listing_id = :listing_id";
     
        $stmt = $this->conn->prepare($query);
     
        // posted values
        $this->county=htmlspecialchars(strip_tags($this->county));
        $this->country=htmlspecialchars(strip_tags($this->country));
        $this->town=htmlspecialchars(strip_tags($this->town));
        $this->full_details_url=htmlspecialchars(strip_tags($this->full_details_url));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->displayable_address=htmlspecialchars(strip_tags($this->displayable_address));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->thumbnail_url=htmlspecialchars(strip_tags($this->thumbnail_url));
        $this->latitude=htmlspecialchars(strip_tags($this->latitude));
        $this->longitude=htmlspecialchars(strip_tags($this->longitude));
        $this->bedrooms=htmlspecialchars(strip_tags($this->bedrooms));
        $this->bathrooms=htmlspecialchars(strip_tags($this->bathrooms));
        //clean price and convert to pennies
        $this->price=$this->clean_numbers(htmlspecialchars(strip_tags($this->price)))*100;
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->purpose=htmlspecialchars(strip_tags($this->purpose));
        $this->listing_id=htmlspecialchars(strip_tags($this->listing_id));
     
        // bind parameters
        $stmt->bindParam(":county", $this->county);
        $stmt->bindParam(":country", $this->country);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":full_details_url", $this->full_details_url);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":displayable_address", $this->displayable_address);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":thumbnail_url", $this->thumbnail_url);
        $stmt->bindParam(":latitude", $this->latitude);
        $stmt->bindParam(":longitude", $this->longitude);
        $stmt->bindParam(":bedrooms", $this->bedrooms);
        $stmt->bindParam(":bathrooms", $this->bathrooms);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":purpose", $this->purpose);
        $stmt->bindParam(":listing_id", $this->listing_id);
     
        // execute the query
        if($stmt->execute()){
            return true;
        }
     
        return false;
    }
    // delete the property
    function delete(){
     
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
         
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
     
        if($result = $stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    // read properties by search term
    public function search($search_term, $from_record_num, $records_per_page){
     
        // select query
        $query = "SELECT
                    id, county, country, town, postcode, description, displayable_address, postcode, image, bedrooms, bathrooms, price, type, purpose, source, created_at, updated_at
                FROM
                    " . $this->table_name . "
                WHERE
                    county LIKE ? OR country LIKE ? OR town LIKE ? OR postcode LIKE ? OR description LIKE ? OR type LIKE ? OR purpose LIKE ? OR displayable_address LIKE ?
                ORDER BY
                    created_at DESC
                LIMIT
                    ?, ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->bindParam(3, $search_term);
        $stmt->bindParam(4, $search_term);
        $stmt->bindParam(5, $search_term);
        $stmt->bindParam(6, $search_term);
        $stmt->bindParam(7, $search_term);
        $stmt->bindParam(8, $search_term);
        $stmt->bindParam(9, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(10, $records_per_page, PDO::PARAM_INT);
     
        // execute query
        $stmt->execute();
     
        // return values from database
        return $stmt;
    }
     
    public function countAll_BySearch($search_term){
     
        // select query
        $query = "SELECT
                    COUNT(*) as total_rows
                FROM
                    " . $this->table_name . "
                WHERE
                    county LIKE ? OR country LIKE ? OR town LIKE ? OR postcode LIKE ? OR description LIKE ? OR type LIKE ? OR purpose LIKE ? OR displayable_address LIKE ?";
     
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
     
        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->bindParam(3, $search_term);
        $stmt->bindParam(4, $search_term);
        $stmt->bindParam(5, $search_term);
        $stmt->bindParam(6, $search_term);
        $stmt->bindParam(7, $search_term);
        $stmt->bindParam(8, $search_term);
     
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
     
        return $row['total_rows'];
    }
    // will upload image file to server
    function uploadImage(){
     
        $result_message="";
     
        // now, if image is not empty, try to upload the image
        if($this->image && $this->image != ""){
     
            // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/";
            $target_file = $target_directory . $this->image;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
     
            // error message is empty
            $file_upload_error_messages="";

            // make sure that file is a real image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check!==false){
                // submitted file is an image
            }else{
                $file_upload_error_messages.="<div>File is not an image.</div>";
            }
             
            // make sure certain file types are allowed
            $allowed_file_types=array("jpg", "jpeg", "png", "gif");
            if(!in_array($file_type, $allowed_file_types)){
                $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
            }
             
            // make sure file does not exist
            if(file_exists($target_file)){
                $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
            }
             
            // make sure submitted file is not too large, can't be larger than 2 MB
            if($_FILES['image']['size'] > (2048000)){
                $file_upload_error_messages.="<div>Image must be less than 2 MB in size.</div>";
            }
             
            // make sure the 'uploads' folder exists
            // if not, create it
            if(!is_dir($target_directory)){
                mkdir($target_directory, 0777, true);
            }
            // if $file_upload_error_messages is still empty
            if(empty($file_upload_error_messages)){
                // it means there are no errors, so try to upload the file
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                    // it means image was uploaded
                }else{
                    $result_message.="<div class='alert alert-danger'>";
                        $result_message.="<div>Unable to upload image.</div>";
                        $result_message.="<div>Update the info to upload image.</div>";
                    $result_message.="</div>";
                }
            }
             
            // if $file_upload_error_messages is NOT empty
            else{
                // it means there are some errors, so show them to user
                $result_message.="<div class='alert alert-danger'>";
                    $result_message.="{$file_upload_error_messages}";
                    $result_message.="<div>Update the info to upload image.</div>";
                $result_message.="</div>";
            }
     
        }
     
        return $result_message;
    }

}
?>