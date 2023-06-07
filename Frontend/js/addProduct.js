$(document).ready(function () {
    $("#productForm").on("submit", function (e) {
        e.preventDefault();
        const form = $(e.target);
        const json = convertFormToJSON(form);
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=product',
            method: 'POST', // Change to 'POST', 'PUT', 'DELETE' as needed
            dataType: 'json',
            data: json,
            success: function(response) {
                // Handle successful response
                console.log("Successfully added product");
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });

    });



    function convertFormToJSON(form) {
        const array = $(form).serializeArray(); // Encodes the set of form elements as an array of names and values.
        const json = {};
        $.each(array, function () {
            json[this.name] = this.value || "";
        });
        return json;
    }

})