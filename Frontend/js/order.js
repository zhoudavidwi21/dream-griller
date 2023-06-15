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


})