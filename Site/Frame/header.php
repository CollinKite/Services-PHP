<html>

<head>
    <link rel="stylesheet" href="style.css">
<?php
$websiteName = "Utah Home Services";
echo "<title>" . $websiteName . " - " . $page . "</title>";
?>

<style>
        /* Styling for the dropdown container and options */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 150px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            padding: 12px;
        }

        /* Styling to show the dropdown options when hovering or clicking on the main category */
        .dropdown:hover .dropdown-content,
        .dropdown.active .dropdown-content {
            display: block;
        }
</style>

</head>
<body>
<header>
    <h1>Utah Home Services</h1>
    <?php
    require_once "Frame/menu.php";
    ?>

    <?php echo "<h2>" . $page . "</h2>" ?>


</header>