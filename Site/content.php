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

  .content-text {
    margin-bottom: 30px; /* Increase the margin to create more space */
    font-size: 18px; /* Increase the font size for better readability */
    margin-top: 30px;
    margin: 0 auto;
  }

  /* Content Cost */
  .content-cost {
    padding: 20px; /* Increase the padding for better spacing */
    font-size: 16px; /* Increase the font size for better readability */
    margin: 0 auto;
  }

  /* Form Container Styling */
  .form-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }

  /* Form Container Styling */
  .form-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }

  /* Form Styling */
  #consultationFormContainer{
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  }
  #basePageInfo{
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
  }
  .consultation-form label,
  .consultation-form input,
  .consultation-form select,
  .consultation-form button {
    margin-bottom: 15px;
  }

  .consultation-form label {
    font-weight: bold;
  }

  .consultation-form input,
  .consultation-form select {
    width: 100%;
    max-width: 300px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
  }

  .consultation-form button {
    display: block;
    margin: 0 auto; /* Center the button */
    background-color: #007bff;
    color: #fff;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s;
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

<div id="basepageinfo">

<div class="content-text" id="categoryDescription"></div>

<!-- Add an empty container for the category cost -->
<div class="content-cost" id="categoryCost" hidden></div>
</div>

<!-- If the title is "Consultation," show the form -->
<div id="consultationFormContainer" hidden>
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
echo "<br><br><br><br><br>";
include_once "Frame/footer.php";
?>