$(document).ready(function() {

    
    load_product_data("charcoal", "");                                          //load products for Homepage (default: charcoal, and empty String --> no "search" value)
    load_cart_data();                                                           //load data for cart information

    

    $("input[name=grillCategories]").on("click", function(){
        let categorie = $("input[name=grillCategories]:checked").val();         //"clicked" categorie is passed to load_product_data
        load_product_data(categorie, "")
    })

    $("#searchfilter").on("keyup", function(){
        let input = $("#searchfilter").val();                                   //"clicked" categorie and user input is passed
        let categorie = $("input[name=grillCategories]:checked").val();
        
        load_product_data(categorie, input)

    })



    function load_product_data(categorie, input){

        $.ajax({
            
            url: "../Backend/RequestHandler.php/product/" +  categorie,
            method: "GET",
            dataType: "json",
            //data: {categorie: categorie, input: input},

            success: function(data){
                $.each(data, function(product) {
                    console.log(product["id"], ",", product["name"]);
    
                });
                
                let content = `
                <div class="col-md-4 mb-5">
                <div class="card h-100" id="item-'.$row["id"].'">
                    <div class="card-body">
                        <a><h2 id="title'.$row["id"].'" class="card-title">'.$row["name"].'</h2></a>
                        <img id="pic0" class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/200x200/dee2e6/6c757d.png">
                        <p id="text'.$row["id"].'" class="card-text">'.$row["description"].'</p>
                        <span class="price fs-4">'.$row["price"].' €</span>
                    </div>
                    <div class="card-footer">
                        <a id="prodcart'.$row["id"].'" class="btn btn-sonstige btn-sm">In den Einkaufswagen</a>
                    </div>
                </div>
            </div>`
                
                //$('#contentRow').html(content);                           //content from BE is appended
                //$("[id^=prodcart]").on("click", putInCart)                      //"In den Einkaufswagen" is enabled
            },
            error: function(data){
                console.log(data)
            }
        })
    }

    function load_cart_data(){

        $.ajax({

            url: "../Backend/businesslogic/getProductsFromCart.php",                    //selects * products from DB and returns json
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

            url:"../Backend/businesslogic/putIntoCart.php",         //product with related product_id is uploaded to DB
            method:"POST",                                              
            data: {id: id},                     

            success:function(data) {
                load_cart_data();                                   //cart data gets refreshed
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
        let method = $(this).text()                                 //addition or subtraction

        $.ajax({

            url:"../Backend/businesslogic/changeQuantityCart.php",  //quantity of related cartitem gets modified
            method:"POST",                                              
            data: {id: id, method: method},                     

            success:function(data) {
                load_cart_data();                                   //cart data gets refreshed
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
            return $('#popover_content').html();                        //Shopping cart structure is loaded
        }
        
    })


});