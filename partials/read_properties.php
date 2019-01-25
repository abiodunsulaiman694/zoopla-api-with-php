<?php
// search form
echo "<form role='search' action='search_properties.php'>";
    echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type product name or description...' name='search' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
        echo "</div>";
    echo "</div>";
echo "</form>";


 
echo "<div class='right-button-margin'>";
    echo "<a href='create_property.php' class='btn btn-default pull-right'>Create new Property</a>";
echo "</div>";
 
// display the products if there are any
if($total_rows>0){
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Thumbnail</th>";
            echo "<th>Town/County/Country</th>";
            echo "<th>Price</th>";
            echo "<th>Type</th>";
            echo "<th>Purpose</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td>";
                if ($thumbnail_url && $source == "api") {
                    echo '<img src="'.$thumbnail_url.'" />';
                } else if ($thumbnail_url && $source == "admin") {
                    echo '<img src="thumbs/'.$thumbnail_url.'" />';
                } else {
                    echo "No thumbnail found";   
                }
                "</td>";
                echo "<td>{$town}/{$county}/{$country}</td>";
                echo "<td>".
                number_format(($price/100), 2).
                "</td>";
                echo "<td>{$type}</td>";
                echo "<td>";
                    if ($purpose == "sale") {
                        echo "For Sale";
                    } elseif ($purpose == "rent") {
                        echo "For Rent";
                    }
                echo "</td>";
 
                echo "<td>";
                    // details, update and delete buttons
                echo "<a href='property_details.php?id={$id}' class='btn btn-primary left-margin'>
                    <span class='glyphicon glyphicon-list'></span> Details
                </a>";

                if ($source == "admin") {

                    echo "
                     
                    <a href='update_property.php?id={$id}' class='btn btn-info left-margin'>
                        <span class='glyphicon glyphicon-edit'></span> Update
                    </a>
                     
                    <a delete-id='{$id}' class='btn btn-danger delete-object'>
                        <span class='glyphicon glyphicon-remove'></span> Delete
                    </a>";
                }
                echo "</td>";
 
            echo "</tr>";
 
        }
 
    echo "</table>";
}
 
// No property found
else{
    echo "<div class='alert alert-info'>No property found.</div>";
}
?>