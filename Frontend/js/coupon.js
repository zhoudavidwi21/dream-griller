$(document).ready(function() {

    //--- from couponList start ---//
    load_couponList()

    function load_couponList(){                                                           //loads all current coupons from DB

        $.ajax({

            url: "../Backend/RequestHandler.php",
            method: "GET",
            dataType: "json",
            data: {resource: "coupons"},

            success: function(response){

                console.log(response);
                $('#couponTable').empty();
                let content = "";

                $.each(response, function(key, coupon) {
                    // Format the expired variable as "Nein" or "Ja"
                    var formattedExpired = coupon.expired ? "Ja" : "Nein";
                    content += `
                    <tr>
                        <td>${coupon.id}</td>
                        <td>${coupon.code}</td>
                        <td>${coupon.amount}</td>
                        <td>${coupon.residual_value}</td>
                        <td>${formatDate(coupon.date)}</td>
                        <td>${formattedExpired}</td>
                   `
                    content += "</tr>"                              //appends table row for every DB entry
                });
                $('#couponTable').html(content);
            },
            error: function(response){
                console.log(response)
            }
        })
    }
    //--- from addCoupon end ---//

    //--- from addCoupon start ---//
    // Map custom on click event to generate code
    $("#generateCodeButton").on("click", function() {
        // Generate a random 5-digit alphanumeric coupon code
        var couponCode = generateCouponCode(5);

        // Fill the input with the generated coupon code
        $("#couponCode").val(couponCode);
    });

    $("#couponForm").on("submit", function(e) {
        e.preventDefault();
        const form = $(e.target);
        const json = convertFormToJSON(form);
        // Send the coupon code to the server
        submitCoupon(json);
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

    function submitCoupon(json) {
        // Send the coupon code as JSON
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=coupon',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify(json),
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
    //--- from addCoupon end ---//
})