$(document).ready(function() {

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
                    // Format the expiry date to dd.mm.yyyy
                    var expiryDate = new Date(Date.parse(coupon.date));
                    var formattedExpiryDate = expiryDate.toLocaleDateString('de-DE');
                    // Format the expired variable as "Nein" or "Ja"
                    var formattedExpired = coupon.expired ? "Ja" : "Nein";

                    content += `
                    <tr>
                        <td>${coupon.id}</td>
                        <td>${coupon.code}</td>
                        <td>${coupon.amount}</td>
                        <td>${formattedExpiryDate}</td>
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



})