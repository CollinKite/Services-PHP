<html>

<head>
    <!-- <link rel="stylesheet" href="style.css"> -->
<?php
    $websiteName = "Utah Home Services";
    echo "<title>" . $websiteName . " - " . $page . "</title>";
    $style = "";
    //check if dbconnect.php is included
    if(!function_exists('Connect')){
        require_once "dbconnect.php";
    }
    //this is a big no no, but couldn't get it to work else wise.
    $conn = Connect();
    $query = "SELECT styles.filename 
            FROM Selected_Style 
            INNER JOIN styles ON Selected_Style.style_id = styles.id";

    $result = mysqli_query($conn, $query);

    if($row = mysqli_fetch_assoc($result)){
        $style = $row['filename'];
    }
?>
<!-- style -->
<link rel="stylesheet" href="../css/<?php echo $style; ?>">
<!-- <link rel="stylesheet" href="../css/darkmode.css"> -->
</head>
<body>
<header>
    <h1>Utah Home Services</h1>
    <?php
    require_once "Frame/menu.php";
    ?>

    <?php echo "<h2>" . $page . "</h2>" ?>


</header>