$(document).ready(function() {

    load_cart_data();


    function load_cart_data(){

        $.ajax({

            url:"../Backend/businesslogic/getProductsFromCart.php",                     //selects * products from DB and returns json
            method:"GET",
            dataType: "json",

            success:function(data) {
                $('#cart_details').html(data.tabledata);                                //tabledata is loaded
                $('#totalCart').html("<b>Gesamtsumme " + data.total + " €</b>");        //total amount is loaded (money to pay)
                $('#quantity').text(data.count);                                        //overall products count (in Navbar)
                $("[id^=removeProduct]").on("click", removeItem)                        //removeButtons are enabled
            },
            error: function(data){
                console.log("error");
            }
        });

        
    }

    function removeItem(){

        let id = $(this).attr("id").slice(13)                           //cuts off 13 chars from id, "number" of id remains

        $.ajax({

            url:"../Backend/businesslogic/removeFromCart.php",
            method:"POST",                                              //cart id is passed and related row gets deleted
            data: {id: id},                     

            success:function(data) {
                load_cart_data();
                $('#cartbtn').popover("hide")                           //reload cart data, hide popover and show message to customer
                alert("Produkt erfolgreich entfernt") 
            },
            error: function(){
                console.log("error");
            }
        });

    }
    
    $('#cartbtn').popover({

        sanitize: false,                                                //important for passing HTML elements like <td> or <th> to the popover content
        html: true,
        placement: 'bottom',
        title: 'Ihr Warenkorb',
        trigger: 'click',
        container: 'body',

        content: function(){
            load_cart_data();
            return $('#popover_content_wrapper').html();                //Shopping cart structure is loaded
        }
        
    })


});