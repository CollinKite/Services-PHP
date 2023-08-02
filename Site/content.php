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

//The reason the fetch is above the header is to initalize the page variable

if (isset($_GET['title'])) {
    $page = $_GET['title'];
} else {
    $page = 'default_value'; // Provide a default value if the session variable is not set
}


include_once "Frame/header.php";

?>

<div class="content-text" id="categoryDescription"></div>

<!-- Add an empty container for the category cost -->
<div class="content-cost" id="categoryCost"></div>

<!-- If the title is "Consultation," show the form -->
<div id="consultationFormContainer">
    <form class="consultation-form" >
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required><br><br>
        <!--Drop down selection box of services will go here--> 
        <label for="service">Service:</label>
        <select id="service" name="service">
        </select><br><br>
        <!--SubmitButton-->
        <button type="submit" value="Submit">Submit</button>
    </form>
</div>



<?php
include_once "load_content.php";
?>


<?php
include_once "Frame/footer.php";
?>