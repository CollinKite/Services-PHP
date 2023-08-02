<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  header {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
  }

  .container {
    max-width: 960px;
    margin: 0 auto;
    padding: 20px;
  }

  .dropdown {
    position: relative;
    display: inline-block;
    margin-right: 20px;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1;
  }

  .dropdown-content a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #333;
  }

  .dropdown-content a:hover {
    background-color: #f9f9f9;
  }
</style>


<script>
async function fetchMainAndSubCategories() {
    try {
        const mainCategoriesResponse = await fetch('Fetch/get_main_categories.php');
        const mainCategories = await mainCategoriesResponse.json();

        const categories = {};
        await Promise.all(
        mainCategories.map(async mainCategory => {
            const subCategoriesResponse = await fetch(`Fetch/get_sub_categories.php?mainCategoryId=${mainCategory.id}`);
            const subCategories = await subCategoriesResponse.json();
            categories[mainCategory.id] = {
            name: mainCategory.name,
            subcategories: subCategories
            };
        })
        );

      // After fetching all subcategories, populate the dropdown menu
        populateDropdownMenu(categories);
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

  // Function to populate the dropdown menu with main categories and subcategories
function populateDropdownMenu(categories) {
    const dropdownContainer = document.getElementById('dropdownContainer');
    Object.keys(categories).forEach(mainCategoryId => {
        const mainCategory = categories[mainCategoryId];
        const dropdown = document.createElement('div');
        dropdown.classList.add('dropdown');
        dropdown.innerHTML = `
        <span>${mainCategory.name}</span>
        <div class="dropdown-content">
            ${mainCategory.subcategories
            .map(
                subcategory =>
                `<a href="${mainCategory.name.replace(/\s+/g, '_')}.php?title=${subcategory.title}&categoryid=${subcategory.id}">${subcategory.title}</a>`
            )
            .join('')}
        </div>`;
    dropdownContainer.appendChild(dropdown);
    });
}


// Call the fetchMainAndSubCategories function to initiate the data fetching
fetchMainAndSubCategories();
</script>
<div id="dropdownContainer" class="dropdown-container"></div>

<script>

  // Function to handle menu item clicks and redirect to the content page, this may have to change for login and other pages
  function handleMenuItemClick(event) {
    if (event.target.tagName === 'A') {
        event.preventDefault();

        const href = event.target.getAttribute('href');
        const categoryID = getQueryParamValue(href, 'categoryid');
        const categoryTitle = getQueryParamValue(href, 'title');

        window.location.href = `content.php?title=${categoryTitle}&categoryid=${categoryID}`;
    }
}

// Function to extract the value of a query parameter from a URL
function getQueryParamValue(url, paramName) {
    const paramStartIndex = url.indexOf(`${paramName}=`);
    if (paramStartIndex === -1) {
        return null; // Parameter not found in the URL
    }

    const paramValueStartIndex = paramStartIndex + paramName.length + 1;
    const paramValueEndIndex = url.indexOf('&', paramValueStartIndex);
    const paramValue = paramValueEndIndex === -1 ? url.substring(paramValueStartIndex) : url.substring(paramValueStartIndex, paramValueEndIndex);
    return paramValue;
}


const dropdownContainer = document.getElementById('dropdownContainer');
dropdownContainer.addEventListener('click', handleMenuItemClick);

  </script>