<?php include_once "Frame/header.php"; ?>

<script>
    var urlParams = new URLSearchParams(window.location.search);
    var categoryId = urlParams.get('category');

    async function fetchSubCategoryById(categoryId) {
        try{
        const response = await fetch('Fetch/get_sub_category_by_id.php?category=' + categoryId);
        const data = await response.json();
        const category = {};
        await Promise.all(
            data.map(async subCategory => {
                category[subCategory.id] = {
                    title: subCategory.title,
                    description: subCategory.description,
                    cost: subCategory.cost
                };
            })
        );
       await populatePage(category);
    } catch (error) {
        console.error('Error fetching data:', error);
        //console log the response and data to see what is going on
        console.log("response " + response);
        console.log("data " + data);
        
    }
}

    async function populatePage(category)
    {
        var description = document.getElementById('categoryDescription');
        description.innerHTML = category.description;
        //if there is a cost display it
        if (category.cost != null) {
            var cost = document.getElementById('categoryCost');
            cost.innerHTML = 'Cost: $' + category.cost;
        }
        //if the category is a consultation, display the consultation form
        if (category.title == 'Consultation') {
            var consultationForm = document.getElementById('consultationForm');
            consultationForm.style.display = 'block';
           await fetchSubCategories(1);
        }//else hide the form
        else {
            var consultationForm = document.getElementById('consultationForm');
            consultationForm.style.display = 'none';
        }
        
    }

   async function fetchSubCategories(categoryId){
    try{
        const response = await fetch('Fetch/get_sub_categories.php?mainCategoryId=' + categoryId);
        const data = await response.json();
        const subCategories = {};
        await Promise.all(
            data.map(async subCategory => {
                subCategories[subCategory.id] = {
                    title: subCategory.title,
                    description: subCategory.description,
                    cost: subCategory.cost
                };
            })
        );
        populateDropdownSelect(subCategories);
    }
    catch (error) {
        console.error('Error fetching data:', error);
    }
}

    function populateDropdownSelect(subCategories) {
        var select = document.getElementById('subCategory');
        Object.keys(subCategories).forEach(subCategoryId => {
            const subCategory = subCategories[subCategoryId];
            const option = document.createElement('option');
            option.value = subCategory.id;
            option.innerHTML = subCategory.title;
            select.appendChild(option);
        });
    }

    //  var request = new XMLHttpRequest();
    // var urlParams = new URLSearchParams(window.location.search);
    // var categoryId = urlParams.get('category');

    // // Use "window.onload" instead of "window.load"
    // window.onload = function() {
    //     request.open('GET', 'Fetch/get_sub_category_by_id.php?category=' + categoryId);
    //     request.onload = loadComplete;
    //     request.send();
    // }

    // function loadComplete(evt) {
    //     var data = JSON.parse(request.responseText);
    //     console.log(data);
    //     var subCategory = data[0];
    //     //description
    //     var description = document.getElementById('categoryDescription');
    //     description.innerHTML = subCategory.description;
    //     //if there is a cost display it
    //     if (subCategory.cost != null) {
    //         var cost = document.getElementById('categoryCost');
    //         cost.innerHTML = 'Cost: $' + subCategory.cost;
    //     }
    //     //if the category is a consultation, display the consultation form
    //     if (subCategory.title == 'Consultation') {
    //         var consultationForm = document.getElementById('consultationForm');
    //         consultationForm.style.display = 'block';
    //         loadConsultationForm();
    //     }//else hide the form
    //     else {
    //         var consultationForm = document.getElementById('consultationForm');
    //         consultationForm.style.display = 'none';
    //     }

        
    // }

    // function loadConsultationForm() {
    //     var request = new XMLHttpRequest();
    //     request.open('GET', 'get_sub_categories.php?maincategoryId=' + 1);
    //     request.onload = ConsultationLoad;
    //     request.send();

    // }   

    // function ConsultationLoad(evt) {
    //     var data = JSON.parse(request.responseText);
    //     var subCategories = data;
    //     var select = document.getElementById('subCategory');
    //     subCategories.forEach(subCategory => {
    //         var option = document.createElement('option');
    //         option.value = subCategory.id;
    //         option.innerHTML = subCategory.title;
    //         select.appendChild(option);
    //     });
    // }
    window.onload = function() {
        console.log("fetching .." + categoryId);
    fetchSubCategoryById(categoryId);
  };

    </script>