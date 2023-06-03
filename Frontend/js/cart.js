$(document).ready(function() {

    load_product_data();
    load_cart_data();

    function load_product_data(){

        $.ajax({
            
            url: "../Backend/businesslogic/loadProductsToHome.php",
            method: "GET",
            dataType: "json",

            success: function(data){
                console.log(data)
                $('#contentRow').html(data.products);
                $("[id^=prodcart]").on("click", putInCart)
            },
            error: function(data){
                console.log(data)
            }
        })
    }

    function load_cart_data(){

        $.ajax({

            url: "../Backend/businesslogic/getProductsFromCart.php",                     //selects * products from DB and returns json
            method: "GET",
            dataType: "json",

            success:function(data) {
                $('#cart_details').html(data.tabledata);                                //tabledata is loaded
                $('#totalCart').html("<b>Gesamtsumme " + data.total + " €</b>");        //total amount is loaded (money to pay)
                $('#quantity').text(" " + data.count);                                  //overall products count (in Navbar)
                $("[id^=removeProduct]").on("click", removeItem)                        //removeButtons are enabled
                $("[id^=btnQuant]").on("click", changeQuant) 
            },
            error: function(data){
                console.log(data);
            }
        });

        
    }


    function putInCart(){
        //über Session noch CartId holen !!

        let id = $(this).attr("id").slice(8)

        $.ajax({

            url:"../Backend/businesslogic/putIntoCart.php",
            method:"POST",                                              
            data: {id: id},                     

            success:function(data) {
                load_cart_data();
                $('#cartbtn').popover("hide")                           
                alert(data)
            },
            error: function(data){
                console.log(data);
            }
        });
        

    }

    

    function changeQuant(){

        let id = $(this).attr("id").slice(11)
        let method = $(this).text()

        $.ajax({

            url:"../Backend/businesslogic/changeQuantityCart.php",
            method:"POST",                                              
            data: {id: id, method: method},                     

            success:function(data) {
                load_cart_data();
                $('#cartbtn').popover("hide")                           
                alert(data)
            },
            error: function(data){
                console.log(data);
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
                alert(data) 
            },
            error: function(data){
                console.log(data);
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