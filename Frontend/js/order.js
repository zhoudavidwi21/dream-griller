/**
 * Formats string date input from 'yyyy-mm-dd' to 'dd.mm.yyyy'
 * @param date
 * @returns {string}
 */
function formatDate(date) {
    var dateObject = new Date(Date.parse(date));
    return dateObject.toLocaleDateString('de-DE');
}

/**
 * Formats given float input into currency with two decimal places
 * @param floatNumber
 * @returns {string}
 */
function formatCurrency(floatNumber) {
    return parseFloat(floatNumber).toFixed(2);
}
$(document).ready(function() {

    var cartExists = sessionStorage.getItem("cart")

    if (cartExists) {
        var globalCart = JSON.parse(cartExists);                                //saving sessionStorage-Item in global variable
    } else {
        var globalCart = [];
    }

    let content = "";
    let overallSum = 0;

    load_order()

    function load_order(){
        //console.log(globalCart)

        $.each(globalCart, function(key, item) {

            let total = parseFloat((item.price * item.quantity).toFixed(2));
            overallSum += total;

            content += `
            <tr>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>${item.price} €</td>
            <td>${total} €</td>
            </tr>
            `
        })

        $('#checkOutTable').html(content);
        $('#totalSumOrder').html("<b>" + parseFloat(overallSum.toFixed(2)) + " €</b>");
    }



    $("#submitOrder").on("click", insertOrder)

    function insertOrder(){
        $.ajax({

            url: '../Backend/RequestHandler.php?resource=order',
            type: 'POST',
            data: { total: overallSum,  cart: globalCart},

            success: function(response) {

                //console.log("order saved");

                globalCart = [];
                sessionStorage.setItem("cart", JSON.stringify(globalCart))

                var currentPath = window.location.pathname;
                var basePath = currentPath.substring(0, currentPath.lastIndexOf('/'));
        
                $("#checkOutSuccess").show();
                
                setTimeout(function() {
                    $("#checkOutSuccess").hide();
                    window.location.href = basePath + "/";
                }, 2000);
                
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    // Open the order details modal on "Bestellungsdetails ansehen" button click
    $(document).on('click', '.viewOrderDetailsButton', function() {
        var orderId = $(this).data('orderid');
        viewOrderDetails(orderId);
    });

    // Print the invoice on "Print Invoice" button click
    $(document).on('click', '#printInvoiceButton', function() {
        var invoiceWindow = window.open('', '_blank');
        var invoiceContent = $('.modal-content').clone(); // Clone the modal content

        // Remove the buttons from the cloned content
        invoiceContent.find('#printInvoiceButton').remove();
        invoiceContent.find('[data-bs-dismiss="modal"]').remove();

        // Write the modified content to the new window
        invoiceWindow.document.open();
        invoiceWindow.document.write('<html><head><title>Invoice</title></head><body>');
        invoiceWindow.document.write(invoiceContent.html()); // Get the HTML content of the cloned and modified modal
        invoiceWindow.document.write('</body></html>');
        invoiceWindow.document.close();

        // Wait for the content to load in the new window
        invoiceWindow.onload = function() {
            // Print the new window
            invoiceWindow.print();
            // Close the new window after printing
            invoiceWindow.close();
        };
    });


    /**
     * Displays orderDetails for a given OrderId
     * @param orderId
     */
    function viewOrderDetails(orderId) {
        // Make an AJAX request to fetch the order details from the backend
        $.ajax({
            url: '../Backend/RequestHandler.php',
            method: 'GET',
            dataType: 'json',
            data: {
                resource: 'order',
                params: {
                    orderId: orderId
                }
            },
            success: function(response) {
                console.log(response);
                $("#orderID").text(response.invoiceNumber);
                $("#customerID").text(response.customerId);
                $("#customerName").text(response.customerFirstname + " " + response.customerLastname);
                $("#orderDate").text(formatDate(response.orderDate));
                $("#addressLine").text(response.customerAddress);
                $("#postCode").text(response.customerPostcode);
                $("#city").text(response.customerCity);
                $("#totalSum").text(formatCurrency(response.invoiceTotal) + "€");


                // Clear previous order items
                $('#orderItems').empty();
                let content = "";

                // Add order items
                $.each(response.orderItems, function (index, orderItem) {
                    content += `
                        <tr>
                            <td>${orderItem.productName}</td>
                            <td>${orderItem.productQuantity}</td>
                            <td>${formatCurrency(orderItem.productPrice)}</td>
                            <td>${formatCurrency(orderItem.productSubtotal)}</td>          
                        </tr>
                        `
                });
                $('#orderItems').html(content);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

})

/**
 * Displays the a list of orders for a given customerId
 * @param customerId
 */
function load_orderList_by_userID(customerId) {
    $.ajax({

        url: "../Backend/RequestHandler.php",
        method: "GET",
        dataType: "json",
        data: {
            resource: "orderByCustomer",
            params: {
                customerId: customerId
            }
        },

        success: function(response){

            console.log(response);
            $('#orderTable').empty();
            let content = "";
            // Sort the orders by date in ascending order
            response.sort(function(a, b) {
                return new Date(a.date) - new Date(b.date);
            });
            $.each(response, function(key, order) {
                content += `
                        <tr>
                            <td>${order.id}</td>
                            <td>${formatCurrency(order.total)}</td>
                            <td>${formatDate(order.date)}</td>
                            <td><button type="button" data-bs-toggle="modal" data-bs-target="#orderModal" id="ordersUser${customerId}" class="btn btn-primary btn-sm viewOrderDetailsButton" 
                            data-orderid="${order.id}">Bestellungsdetails ansehen</button>
                            </td>                                            `
                content += "</tr>"                              //appends table row for every DB entry
            });

            $('#orderTable').html(content);

        },
        error: function(response){
            console.log(response)
        }
    })
}