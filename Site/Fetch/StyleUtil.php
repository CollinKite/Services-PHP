<?php
require_once "AdminUtil.php";
function getStyles($conn) {
    // Join with Selected_Style to get the selected style filename
    $query = "SELECT styles.*, Selected_Style.id as selected_id 
              FROM styles 
              LEFT JOIN Selected_Style ON styles.id = Selected_Style.style_id";
    
    $result = mysqli_query($conn, $query);
    $styles = array();
    
    while($row = mysqli_fetch_assoc($result)){
        $styles[] = $row;
    }
    echo json_encode($styles);
}


function getSelectedStyle($conn) {
    // Join with styles to get the selected style filename
    $query = "SELECT styles.filename 
              FROM Selected_Style 
              INNER JOIN styles ON Selected_Style.style_id = styles.id";

    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($result)){
        return $row['filename'];
    } else {
        echo "No style selected";
    }
}



function setStyle($conn) {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!verifyAdminToken($conn)){
        echo "Invalid token";
        die();
    }

    $id = $data['id'];
    if(empty($id)){
        echo "ID is empty";
        die();
    }

    $id = mysqli_real_escape_string($conn, $id);

    // First, delete the existing selected style
    $query = "DELETE FROM Selected_Style";
    $result = mysqli_query($conn, $query);
    if(!$result){
        echo "Error deleting existing selected style: " . mysqli_error($conn);
        die();
    }

    // Then, insert the new selected style
    $query = "INSERT INTO Selected_Style (style_id) VALUES ('$id')";
    $result = mysqli_query($conn, $query);
    if($result){
        echo "Style updated successfully";
    } else {
        echo "Error updating style: " . mysqli_error($conn);
    }
}



?>