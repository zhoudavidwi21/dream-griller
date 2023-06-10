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
                // Handle successful response
                console.log("Successfully added product");
            },
            error: function (xhr, status, error) {
                console.log("There has been an error");
                // Handle error
                console.log(error);
            }
        });
    }

    function convertFormDataToJson(formData) {
        const jsonObject = {};
        for (const [key, value] of formData.entries()) {
            if (jsonObject.hasOwnProperty(key)) {
                if (Array.isArray(jsonObject[key])) {
                    jsonObject[key].push(value);
                } else {
                    jsonObject[key] = [jsonObject[key], value];
                }
            } else {
                jsonObject[key] = value;
            }
        }
        return JSON.stringify(jsonObject);
    }
});
