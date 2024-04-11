// dashboard.js





document.addEventListener('DOMContentLoaded', function () {

    function getDbUserFromLocalStorage() {
        const dbUserJSON = localStorage.getItem('dbUser');
        if (dbUserJSON) {
            return JSON.parse(dbUserJSON);
        } else {
            return null;
        }
    }
    
    function createUserName(dbUser) {
        if (dbUser && dbUser.first_name && dbUser.last_name) {
            return `${dbUser.first_name} ${dbUser.last_name}`;
        } else {
            return 'User';
        }
    }
    
    function onPageLoad() {
        const dbUser = getDbUserFromLocalStorage();
    
        if (dbUser) {
            const userNameElement = document.getElementById('userName');
    
            if (userNameElement) {
                const userName = createUserName(dbUser);
                userNameElement.textContent = userName;
            }
    
        } else {
            window.location.href = 'sign-in.html';
            console.log('No user found');
        }
    }
    
    // Call onPageLoad function when the page is loaded
    onPageLoad()

    






    const dbUser = JSON.parse(localStorage.getItem('dbUser'));
    const cid = dbUser ? dbUser.cid : null;
    const requestBody = JSON.stringify({ cid });

    const fullName = dbUser ? `${dbUser.first_name} ${dbUser.last_name}` : '';
    const fullNameElement = document.getElementById('fullName');
    fullNameElement.textContent = `Hello, ${fullName} !!`;




    // Total Products- starts here
    function fetchProductCount() {

      if (cid) {
        fetch('https://minitgo.com/api/total_products.php')
          .then(response => response.json())
          .then(data => {
            const products = data.data.filter(product => product.cid === cid);
            const totalCount = products.length;

            const totalProductsElement = document.getElementById('totalProductsCount');
            if (totalProductsElement) {
              totalProductsElement.textContent = totalCount;
            }
          })
          .catch(error => {
            console.error('Error fetching product count:', error);
          });
      } else {
        console.error('No client_id found in local storage');
      }
    }
    fetchProductCount();

    // Total Products- ends here








    // Total Orders - starts here

    function updateTotalOrders() {
     

      fetch('https://minitgo.com/api/fetch_total_orders.php', {
        method: 'POST',
        body: requestBody
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          console.log("DATA", data);
          const totalOrders = data.count;
          console.log("TOTAL ORDERS:", totalOrders);

          const totalOrdersElement = document.getElementById('total_orders');
          totalOrdersElement.textContent = totalOrders;
        })
        .catch(error => {
          console.error('Error updating total orders:', error);
          const totalOrdersElement = document.getElementById('total_orders');
          totalOrdersElement.textContent = 'Error fetching total orders';
        });
    }
    updateTotalOrders();


    // Total Orders - ends here






    // Total Sales - starts here


    function updateTotalSale() {


      fetch('https://minitgo.com/api/total_sale.php', {
        method: 'POST',
        body: requestBody,
        headers: {
        }
      })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json(); // Parse response body as JSON
        })
        .then(data => {
          console.log("DATA", data);
          const totalSales = data.total_amount; // Access total_amount from parsed JSON data
          console.log("TOTAL SALES:", totalSales);
          const totalSalesWithRupee = `₹ ${totalSales}`;

          const totalSalesElement = document.getElementById('total_sale');
          totalSalesElement.textContent = totalSalesWithRupee;
        })
        .catch(error => {
          console.error('Error updating total sales:', error);
          const totalSalesElement = document.getElementById('total_sale');
          totalSalesElement.textContent = 'Error fetching total sales';
        });
    }

    updateTotalSale();

    // Total Sales - ends here





    // Todays Orders- starts here 

    function updateTodaysOrders(){
        fetch('https://minitgo.com/api/todays_orders.php', {
            method: 'POST',
            
            body: requestBody
        })
        .then(response => response.json())
        .then(data => {
            console.log("TODAYS:",data)
            document.getElementById('todays_orders').textContent = data.count;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    
    }

    updateTodaysOrders()

   
    // Todays Orders-ends here

  });


