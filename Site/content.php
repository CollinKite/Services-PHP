<style>
 body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
  }

  /* Content Container */
  .content {
    max-width: 800px;
    margin: 30px auto;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding: 20px;
  }

  /* Content Body */
  .content-text {
    margin-bottom: 20px;
  }

  /* Content Cost */
  .content-cost {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
  }

  /* Form Styling */
  .consultation-form label,
  .consultation-form input,
  .consultation-form select,
  .consultation-form button {
    display: block;
    margin-bottom: 10px;
  }

  .consultation-form label {
    font-weight: bold;
  }

  .consultation-form input,
  .consultation-form select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .consultation-form button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .consultation-form button:hover {
    background-color: #0056b3;
  }
</style>

<?php

include_once "Fetch/get_sub_category_by_id.php";
include_once "Fetch/get_sub_categories.php";

if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];
    $subcategoryInfo = getSubCategoryById($categoryId);
    $page = $subcategoryInfo['title'];

    
} else {
    echo "Category ID not provided.";
}

if($subcategoryInfo['title'] == "Consultation") {
    $services = getSubCategories(1);    
}





?>

<?php 

//The reason the fetch is above the header is to initalize the page variable

include_once "Frame/header.php";

?>

<div class="content">
    <div class="content-container">
        <div class="content-body">
            <div class="content-text">
                <p><?php echo $subcategoryInfo['desc']; ?></p>
            </div>
        </div>
        <div class= "content-cost">
            <p><?php //if cost exists include it
                    if ($subcategoryInfo['cost'] != null) {
                        echo '<h3>Cost:</h3>';
                        echo $subcategoryInfo['cost'];
                    }
                    ?></p>

        <!--If the title is consultiation include a form else make sure the form is not there-->
        <?php if ($subcategoryInfo['title'] == "Consultation") { ?>
            <form class= "consultion-form">
                <label for="name">Name:</label>

                <input type="text" id="name" name="name" required><br><br>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email requried"><br><br>
                <!--Drop down selection box of services will go here--> 
                <label for="service">Service:</label>
                <select id="service" name="service">
                    <?php foreach ($services as $service) { ?>
                        <option value="<?php echo $service['id']; ?>"><?php echo $service['title']; ?></option>
                    <?php } ?>
                </select><br><br>
                <!--SubmitButton-->
                <button type="submit" value="Submit">Submit</button>
        </form>
        <?php } ?>
    </div>

    




<?php
include_once "Frame/footer.php";
?>