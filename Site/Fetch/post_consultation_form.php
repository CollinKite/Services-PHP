<?php 
include '../Database/dbconnect.php';


$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
$name = isset($data['name']) ? $data['name'] : '';
$email = isset($data['email']) ? $data['email'] : '';
$sub_category_id = isset($data['sub_category_id']) ? $data['sub_category_id'] : 0;
//send data to database in the customer table


try{
$dbConn = Connect();

$query = "INSERT INTO `Customer` (`name`, `email`, `sub_category_id`) VALUES ('$name', '$email', '$sub_category_id')";

$result = @mysqli_query($dbConn, $query);

return $result . "data inserted" . $name . $email . $sub_category_id;

@mysqli_close($dbConn);
}
catch(Exception $e){
    echo $e->getMessage();
    var_dump($data);
}

