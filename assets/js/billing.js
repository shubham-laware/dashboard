// billing.js

const form = document.getElementById("product_code_searchbar");
const input = document.getElementById("product_code_input");
const products_section = document.getElementById("products_section");
const items_section = document.getElementById("items_section");

let checkoutProducts = [];

form.addEventListener("submit", function (event) {
  event.preventDefault();
  let product_codes = input.value?.trim();
  
  if (product_codes === "") {
    return;
  }

  // Split the input value by comma to get individual product codes
  product_codes = product_codes.split(",").map(code => code.trim());

  fetch(`https://minitgo.com/api/fetch_products.php`, {
    method: "GET",
  })
  .then((response) => response.json())
  .then((data) => {
    const filteredProducts = data.data.filter(product => {
      // Check if the product code is included in the array of product codes
      return product_codes.includes(product.pcode);
    });
    console.log("Filtered products:", filteredProducts);
    displayProducts(filteredProducts);
  })
  .catch((error) => console.error("Error:", error));
});



// form.addEventListener("submit", function (event) {
//   event.preventDefault();
//   let product_codes = input.value?.trim();
  
//   if (product_codes === "") {
//     return;
//   }

//   // Split the input value by comma to get individual product codes
//   product_codes = product_codes.split(",").map(code => code.trim());
//   fetch(`https://minitgo.com/api/fetch_products.php?pcode=${product_codes}`, {
//     method: "GET",
//     headers: {
//       "Content-Type": "application/json",
//     },
//   })
//   .then((response) => {
//     console.log("RESPONSE:",response)
//     return response.json()
//   })
//   .then((data) => {
//     const filteredProducts = data.data.filter(product => {
//       // Check if the product code is included in the array of product codes
//       return product_codes.includes(product.pcode);
//     });
//     console.log("Filtered products:", filteredProducts);
//     displayProducts(filteredProducts);
//   })
//   .catch((error) => console.error("Error:", error));
// });

function onAddToCheckout(productId) {
  fetch(`https://minitgo.com/api/fetch_products.php`, {
    method: "GET",
  })
  .then((response) => response.json())
  .then((data) => {
    const products = data.data;
    const productToAdd = products.find((product) => product.product_id === productId);
    if (productToAdd) {
      checkoutProducts.push(productToAdd);
      console.log("Product added to checkout:", productToAdd);
      updateCheckoutProductCount(); // Update the count of checkout products
    } else {
      console.log("Product not found");
    }
  })
  .catch((error) => console.error("Error:", error));
}

function updateCheckoutProductCount() {
  items_section.innerHTML = `
    <span>Bill Items ${checkoutProducts.length}</span>
    <button
      class="btn btn-primary my-auto"
      data-bs-toggle="modal"
      data-bs-target="#billingModal"
    >
      Send bill
    </button>
  `;
}

console.log(checkoutProducts.length);

// Get the quantity input field in the modal
const quantityInput = document.getElementById("quantity");

// Function to update the quantity input field value
function updateQuantityField() {
  if (quantityInput) {
    quantityInput.value = checkoutProducts.length; // Set the value to the number of checkout items
  }
}

// Event listener to execute the function when the modal is shown
document.getElementById('billingModal').addEventListener('shown.bs.modal', function () {
  updateQuantityField(); // Update the quantity field when the modal is shown
});


function displayProducts(products) {
  products_section.innerHTML = "";
  let products_html = "";

  products.forEach((product) => {
    products_html += "<div class='col-xl-3 col-md-6 mb-xl-0 mb-4 my-2'>";
    products_html +=
      "<div class='card card-blog card-plain rounded rounded-2 shadow shadow-2 p-3'>";
    products_html += "<div class='position-relative'>";
    products_html +=
      "<a class='d-block border border-radius-xl d-flex justify-content-center  mx-1'>";
    products_html +=
      "<img src='" +
      product.product_image1 +
      "' alt='img-blur-shadow' class='img-fluid fixed-size-image border-radius-xl p-1'>"; // Product image here
    products_html += "</a>";
    products_html += "</div>";
    products_html += "<div class='card-body px-1 pb-0'>";
    products_html +=
      "<p class='text-gradient text-dark mb-2 text-sm'>" +
      product.category +
      "</p>";
    products_html += "<a href='javascript:;'>"; // Opening <a> tag
    products_html += "<h5>" + product.product_tittle + "</h5>"; // Product title here
    products_html += "</a>"; // Closing <a> tag
    products_html += "<h5>" + product.product_price + "</h5>"; // Product price here
    products_html +=
      "<p class='mb-4 text-sm'>" + product.product_discription + "</p>"; //Product description here
    products_html +=
      "<div class='d-flex align-items-center justify-content-between'>";
    products_html +=
      "<button type='button' class='btn btn-outline-primary btn-sm mb-0'>Edit</button>";
    products_html +=
      "<button type='button' class='btn btn-outline-primary btn-sm mb-0' onclick='onAddToCheckout(\"" +
      product.product_id +
      "\")'>Add to Checkout</button>";
    products_html += "</div>";
    products_html += "</div>";
    products_html += "</div>";
    products_html += "</div>";
  });

  products_section.innerHTML = products_html;
}

function onEdit() {
  return;
}
