$(document).ready(function() {

    $(document).on('click', '.btnQuant', function(){
        changeQuant(parseInt($(this).attr("id").slice(11), 10), $(this).text())     //slicing and passing Product ID + method (quant +1 or -1)
    })
    $(document).on('click', '[id^=removeProduct]', function(){
        removeItem(parseInt($(this).attr("id").slice(13), 10))                      //slicing productId from product that should be removed
    });

    // Add event listener for dragstart event on product cards
    $(document).on('dragstart', '.card', function(event) {
        const productId = $(this).attr('id').slice(5);
        event.originalEvent.dataTransfer.setData('text/plain', productId);
    });

    // Add event listener for dragover event on the cart container
    $('#cartbtn').on('dragover', function(event) {
        event.preventDefault();
    });

    // Add event listener for drop event on the cart container
    $('#cartbtn').on('drop', function(event) {
        event.preventDefault();
        const productId = event.originalEvent.dataTransfer.getData('text/plain');
        putInCart(productId);
    });

    var cartExists = sessionStorage.getItem("cart")

    if (cartExists) {
        var globalCart = JSON.parse(cartExists);                                //saving sessionStorage-Item in global variable
    } else {
        var globalCart = [];
    }


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


    function load_product_data(categorie, input){                   //loads product for specific category and user input (searchfield)

        $.ajax({

            url: "../Backend/RequestHandler.php",
            method: "GET",
            dataType: "json",
            data: {
                resource: "productCat",
                params: {
                    category: categorie,
                    input: input
                }
            },

            success: function(response){

                console.log("success");
                $('#contentRow').empty();

                $.each(response, function(key, product) {

                    let content = `
                    <div class="col-md-4 mb-5">
                    <div class="card h-100" id="item-${product.id}">
                    <div class="card-body">
                    <a><h2 id="title-${product.id}" class="card-title" draggable="true">${product.name}</h2></a>
                    <img id="pic-${product.id}" class="img-fluid rounded mb-4 mb-lg-0" src="${product.image}">                    <p id="description-${product.id}" class="card-text">${product.description}</p>
                    <span id="price-${product.id}" class="price fs-4">${product.price} €</span>
                    <p <span id="rating-${product.id}" style="font-style: italic" class="rating fs-6">Bewertung: ${product.rating}/5</span></p>
                    </div>
                    <div class="card-footer">
                    <a id="prodcart-${product.id}" class="btn btn-sonstige btn-sm">In den Einkaufswagen</a>
                    </div>
                    </div>
                    </div>
                    `

                    $('#contentRow').append(content);                               //for every product a div block is appended
                    $('#prodcart-' + product.id).on("click", function(){            //enables "in den Einkaufswagen"
                        putInCart($(this).attr("id").slice(9))
                    })

                });

            },
            error: function(response){
                console.log(response)
            }
        })
    }


    function load_cart_data(){                                                      //load cart in form of a popover

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

        $.each(globalCart, function(key, item) {

            let total = parseFloat((item.price * item.quantity).toFixed(2));
            count++;
            overallSum += total;

            content += `
            <tr>
                <td>${item.name}</td>
                <td id="quantText${item.id}">${item.quantity} Stück<br>
                    <button id="btnQuantAdd${item.id}" class="btnQuant">+</button>
                    <button id="btnQuantSub${item.id}" class="btnQuant">-</button>
                </td>
                <td>${item.price} €</td>
                <td>${total} €</td>
                <td><button class="btn btn-outline-danger" id="removeProduct${item.id}">Entf.</button></td>
            </tr>
            `
        });

        content += "</table></div>";        //for every item in the globalCart (= sessionStorageItem) one table row is appended

        if(globalCart.length === 0){
            content += '<div id="emptyCart" align="center">Es sind keine Produkte im Warenkorb</div>'
            $("#check_out_cart").attr("href", "#");
        }else{
            $("#check_out_cart").attr("href", "index.php?site=checkOutOrder");          //if cart != empty --> link to checkout is enabled
        }

        $('#cart_details').html(content);
        $('#totalCart').html("<b>Gesamtsumme " + parseFloat(overallSum.toFixed(2)) + " €</b>");
        $('#quantity').text(" " + count);

    }


    function putInCart(id){                                         //product with related product_id is written to cart

        $.ajax({

            url:"../Backend/RequestHandler.php",
            method:"GET",
            dataType: "json",
            data: {
                resource: "product",
                params: {
                    id: id
                }
            },

            success:function(data) {

                let itemExists = globalCart.find(function(item){
                    return item.id === data.id;
                })

                if(itemExists){
                    itemExists.quantity += 1                                    //if product already in cart --> quantity +1 (no new row)
                }else{
                    globalCart.push({
                        id: data.id,
                        name: data.name,
                        price: data.price,
                        quantity: 1
                    })
                }

                sessionStorage.setItem("cart", JSON.stringify(globalCart))      //sessionStorage Item is updated

                load_cart_data();

            },
            error: function(data){
                console.log(data);
            }
        });


    }



    function changeQuant(id, method){                                   //modifiy quantity (dependent on product id and + or -)

        let itemToChange = globalCart.find(function(item){
            return item.id === id;
        })

        console.log(itemToChange)

        if(method === "+"){
            itemToChange.quantity += 1;

        }else if(itemToChange.quantity === 1){
            removeItem(itemToChange.id)

        }else{
            itemToChange.quantity -= 1;
        }

        console.log(itemToChange)

        sessionStorage.setItem("cart", JSON.stringify(globalCart))      //again cart is updated

        $('#cartbtn').popover("show");                                  //popover is updated to instantly display changes
    }

    function removeItem(id){

        let itemToChange = globalCart.find(function(item){
            return item.id === id;
        })

        console.log(itemToChange)

        let index = globalCart.indexOf(itemToChange);                   //search for position of product that should be deleted
        if (index > -1) {
            globalCart.splice(index, 1);                                  //then cut it off array
        }

        sessionStorage.setItem("cart", JSON.stringify(globalCart))

        $('#cartbtn').popover("show");
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