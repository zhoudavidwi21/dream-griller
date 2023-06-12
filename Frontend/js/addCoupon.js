$(document).ready(function () {

    // Map custom on click event to generate code
    $("#generateCodeButton").on("click", function() {
        // Generate a random 5-digit alphanumeric coupon code
        var couponCode = generateCouponCode(5);

        // Fill the input with the generated coupon code
        $("#couponCode").val(couponCode);
    });

    $("#couponForm").on("submit", function(e) {
        e.preventDefault();
        let couponCode = $("#couponCode").val();
        let couponValue = $("#couponValue").val();
        let couponExpiration = $("#couponExpiration").val();
        // Send the coupon code to the server
        submitCoupon(couponCode, couponValue, couponExpiration);
    });

    // Function to generate a random 5-digit alphanumeric coupon code
    function generateCouponCode(length) {
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var couponCode = '';

        for (var i = 0; i < length; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            couponCode += characters.charAt(randomIndex);
        }

        return couponCode;
    }

    function submitCoupon(couponCode, couponValue, couponExpiration) {
        // Prepare the data to be sent
        var jsonData = {
            couponCode: couponCode,
            couponValue: couponValue,
            couponExpiration: couponExpiration
        };

        // Send the coupon code as JSON
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=coupon',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify(jsonData),
            contentType: 'application/json',
            success: function(response) {
                showAlert('success', `Coupon ${response.code} erfolgreich erstellt!`);
                console.log("Successfully created coupon");
            },
            error: function(xhr, status, error) {
                showAlert('danger', 'Fehler beim Erstellen des Coupons!');
                console.log("There has been an error");
                console.log(error);
            }
        });
    }


});