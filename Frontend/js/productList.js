$(document).ready(function() {

    $(document).on('click', '[id^=disableProduct]', function(){
        changeStatus(parseInt($(this).attr("id").slice(11), 10), false)
    })                                                                                  //slice productID from pushed buttons
    $(document).on('click', '[id^=enableProduct]', function(){
        changeStatus(parseInt($(this).attr("id").slice(10), 10), true)
    });

    load_productList()

    function load_productList(){                                                           //loads all current products from DB

        $.ajax({

            url: "../Backend/RequestHandler.php",
            method: "GET",
            dataType: "json",
            data: {resource: "products"},

            success: function(response){

                console.log(response);
                $('#productTable').empty();
                let content = "";

                $.each(response, function(key, product) {

                    content += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td>${product.description}</td>                       
                        <td>${product.price}</td>
                        <td>${product.rating}</td>
                        <td>${product.image}</td>
                        <td>${product.gas}</td>
                        <td>${product.charcoal}</td>
                        <td>${product.pellet}</td>
                        <td>${product.sale}</td>

                   `
                    if(product.enabled){
                        content += `
                        <td><a id="disableProduct${product.id}" class="btn btn-secondary btn-sm" href="#">Deaktivieren</a></td>
                        `
                    }else{
                        content += `
                        <td><a id="enableProduct${product.id}" class="btn btn-success btn-sm" href="#">Aktivieren</a></td>
                        `
                    }

                    content += "</tr>"                              //appends table row for every DB entry

                    
                });

                $('#productTable').html(content);
                    
            },
            error: function(response){
                console.log(response)
            }
        })
    }

})