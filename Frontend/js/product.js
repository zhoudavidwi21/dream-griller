/**
 * Function to add an alert on method call
 * @param alertType - type of message, changes color of alert
 * (primary, secondary, success, danger, warning, info, light, dark)
 * @param alertMessage - message inside alert
 */
function showAlert(alertType, alertMessage) {
    const alertDiv = $('<div>').addClass(`alert alert-${alertType} alert-dismissible fade show`).attr('role', 'alert');
    const strongTag = $('<strong>').text(`${alertMessage}`);
    const button = $('<button>').addClass('btn-close').attr({
        'type': 'button',
        'data-bs-dismiss': 'alert',
        'aria-label': 'Close'
    });

    alertDiv.append(strongTag, button);
    $('h1').prepend(alertDiv);

    // Automatically dismiss the alert after 3 seconds
    setTimeout(function () {
        alertDiv.alert('close');
    }, 5000);
}

/**
 * Function to serialize form data into a key-value array to be used as json
 * @param form - form variable
 * @returns {{}} - return array with key-values with keys as in form name
 */
function convertFormToJSON(form) {
    const array = $(form).serializeArray(); // Encodes the set of form elements as an array of names and values.
    const json = {};
    $.each(array, function () {
        json[this.name] = this.value || "";
    });
    return json;
}

$(document).ready(function() {

    //--- from productList start ---//
    $(document).on('click', '[id^=disableProduct]', function(){
        changeStatus(parseInt($(this).attr("id").slice(14), 10), false)
    })                                                                                  //slice productID from pushed buttons
    $(document).on('click', '[id^=enableProduct]', function(){
        changeStatus(parseInt($(this).attr("id").slice(13), 10), true)
    });

    load_productList()

    function truncateDescription(description, maxLength) {
        if (description.length > maxLength) {
          return description.substring(0, maxLength) + '...';
        }
        return description;
      }

    function load_productList(){                                                           //loads all current products from DB

        $.ajax({

            url: "../Backend/RequestHandler.php",
            method: "GET",
            dataType: "json",
            data: {resource: "products"},

            success: function(response){

                console.log(response);
                $('#productTable').empty();
                let content = "";

                $.each(response, function(key, product) {

                    content += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${truncateDescription(product.description, 50)}</td> 
                        <td>${product.price}</td>
                        <td>${product.rating}</td>
                        <td><img src="${product.image}" alt="Thumbnail" width="50px"></td>
                        <td>${product.gas}</td>
                        <td>${product.charcoal}</td>
                        <td>${product.pellet}</td>
                        <td>${product.sale}</td>
                        <td><a id="changeProduct${product.id}" class="btn btn-primary btn-sm" href="#">Produkt bearbeiten</a></td>                    
                   `
                    if(product.sale){
                        content += `
                        <td><a id="disableProduct${product.id}" class="btn btn-secondary btn-sm" href="#">Produkt deaktivieren</a></td>
                        `
                    }else{
                        content += `
                        <td><a id="enableProduct${product.id}" class="btn btn-success btn-sm" href="#">Produkt aktivieren</a></td>
                        `
                    }

                    content += "</tr>"                              //appends table row for every DB entry

                    
                });

                $('#productTable').html(content);
                    
            },
            error: function(response){
                console.log(response)
            }
        })
    }

    function changeStatus(id, newValue){                            //changes user status to the respective opposite
        
        $.ajax({

            url: "../Backend/RequestHandler.php?resource=product&params[id]=" +  id + "&params[newValue]=" + newValue,
            method: "PUT",
            dataType: "json",

            success: function(){
                console.log("changed");
                load_productList();
                
            },
            error: function(response){
                console.log(response)
            }
        })

    }
    //--- from productList end ---//

    //--- from addProduct start ---//
    // add Product functionality
    $("#productForm").on("submit", function (e) {
        e.preventDefault();
        const form = $(e.target);
        const formData = new FormData(form[0]);

        // Get the image file
        const fileInput = form.find('input[type="file"]');
        const file = fileInput[0].files[0];
        if (file) {
            formData.set('productImage', file);
        }

        // const jsonData = convertFormDataToJson(formData);
        submitProduct(formData);
    });

    // Does not submit as a json because else image could not be sent
    function submitProduct(formData) {
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=product',
            method: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                showAlert('success', 'Produkt erfolgreich hinzugefügt!');
                // Handle successful response
                console.log("Successfully added product");
            },
            error: function (xhr, status, error) {
                showAlert('danger', 'Fehler beim Hinzufügen des Produkts!');
                console.log("There has been an error");
                // Handle error
                console.log(error);
            }
        });
    }
    //--- from addCoupon end ---//
})