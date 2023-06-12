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
$(document).ready(function () {
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
});
