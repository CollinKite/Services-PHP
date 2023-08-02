<?php 
include '../Database/dbconnect.php';


$name = isset ($_POST['name']) ? $_POST['name'] : '';
$email = isset ($_POST['email']) ? $_POST['email'] : '';
$sub_category_id = isset ($_POST['sub_category_id']) ? $_POST['sub_category_id'] : 0;
//send data to database in the customer table
try{
$dbConn = Connect();

$query = "INSERT INTO `Customer` (`name`, `email`, `sub_category_id`) VALUES ('$name', '$email', '$sub_category_id')";

$result = @mysqli_query($dbConn, $query);

return $result + "data inserted" + $name + $email + $sub_category_id;

@mysqli_close($dbConn);
}
catch(Exception $e){
    echo $e->getMessage();
}

