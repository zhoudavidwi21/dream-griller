$(document).ready(function() {

    if (!sessionStorage.getItem("cart")) {
        let cart = []
        sessionStorage.setItem("cart", JSON.stringify(cart))
    }

    //console.log(sessionStorage)

    //on_page_load()
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

    /*function on_page_load() {
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=products',
            method: 'GET', // Change to 'POST', 'PUT', 'DELETE' as needed
            dataType: 'json',
            success: function(response) {
                // Handle successful response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    }*/


    function load_product_data(categorie, input){

        $.ajax({
            
            url: "../Backend/RequestHandler.php?resource=productCat&params[category]=" +  categorie + "&params[input]=" + input,
            method: "GET",
            dataType: "json",
            //data: {categorie: categorie, input: input},

            success: function(response){

                console.log("success");
                $('#contentRow').empty();

                $.each(response, function(key, product) {

                    let content = `
                    <div class="col-md-4 mb-5">
                        <div class="card h-100" id="item-">
                            <div class="card-body">
                                <a><h2 id="title-${product.id}" class="card-title">${product.name}</h2></a>
                                <img id="pic-${product.id}" class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/200x200/dee2e6/6c757d.png">
                                <p id="description-${product.id}" class="card-text">${product.description}</p>
                                <span id="price-${product.id}" class="price fs-4">${product.price} €</span>
                            </div>
                            <div class="card-footer">
                                <a id="prodcart-${product.id}" class="btn btn-sonstige btn-sm">In den Einkaufswagen</a>
                            </div>
                        </div>
                    </div>
                    `

                    $('#contentRow').append(content);
                    $('#prodcart-' + product.id).on("click", putInCart)
                    
                });
                
            },
            error: function(response){
                console.log(response)
            }
        })
    }

    /*function load_cart_data(){

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

        
    }*/

    function load_cart_data(){

        let cart = JSON.parse(sessionStorage.getItem("cart"))
        console.log(cart)

        let content = `
        <div class="table-responsive" id="order_table">
            <table class="table table-bordered table-striped">
                <tr>  
                    <th>Name</th>  
                    <th>Anzahl</th>  
                    <th>Preis</th>  
                    <th>Gesamt</th>  
                    <th></th>  
                </tr>
        `
        let count = 0;
        let overallSum = 0;

        for(i in cart){
            let item = cart[i];

            let total = item.price * item.quantity;
            count++;
            overallSum += total;
            
            content += `
            <tr>
                <td>${item.name}</td>
                <td>${item.quantity} Stück<br>
                    <button id="btnQuantAdd${item.id}">+</button>
                    <button id="btnQuantSub${item.id}">-</button>
                </td>
                <td>${item.price} €</td>
                <td>${total} €</td>
                <td><button class="btn btn-danger btn-xs delete" id="removeProduct${item.id}">Entf.</button></td>
            </tr>
            `
        }

        content += "</table></div>";

        $('#cart_details').html(content);
        $('#totalCart').html("<b>Gesamtsumme " + overallSum + " €</b>");
        $('#quantity').text(" " + count);
        $("[id^=btnQuant]").on("click", changeQuant);
   
    }


    function putInCart(){
        //über Session noch CartId holen !!

        let id = $(this).attr("id").slice(9)

        $.ajax({

            url:"../Backend/RequestHandler.php?resource=product&params[id]=" +  id,         //product with related product_id is uploaded to DB
            method:"GET",                                              
            dataType: "json",                    

            success:function(data) {
                let currentCart = JSON.parse(sessionStorage.getItem("cart"));

                let itemExists = currentCart.find(function(item){
                    return item.id === data.id;
                })

                if(itemExists){
                    itemExists.quantity += 1
                }else{
                currentCart.push({
                    id: data.id,
                    name: data.name,
                    price: data.price,
                    quantity: 1
                })
                }

                sessionStorage.setItem("cart", JSON.stringify(currentCart))


                
                load_cart_data();                                   //cart data gets refreshed
                /*$('#cartbtn').popover("hide")                           
                alert(data)*/
            },
            error: function(data){
                console.log(data);
            }
        });
        

    }

    

    function changeQuant(){

        console.log("hello")

        let id = $(this).attr("id").slice(11)
        let method = $(this).text()                                 //addition or subtraction

        console.log(method)

        let currentCart = JSON.parse(sessionStorage.getItem("cart"));
        let itemToChange = currentCart.find(function(item){
            return item.id === id;
        })

        console.log(itemToChange)

        if(method === "+"){
            itemToChange.quantity++;
        }else{
            itemToChange.quantity--;
        }

        //load_cart_data();


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