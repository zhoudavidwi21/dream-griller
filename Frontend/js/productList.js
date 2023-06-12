$(document).ready(function() {

    $(document).on('click', '[id^=disableProduct]', function(){
        changeStatus(parseInt($(this).attr("id").slice(11), 10), false)
    })                                                                                  //slice productID from pushed buttons
    $(document).on('click', '[id^=enableProduct]', function(){
        changeStatus(parseInt($(this).attr("id").slice(10), 10), true)
    });

    load_productList()

    function truncateDescription(description, maxLength) {
        if (description.length > maxLength) {
          return description.substring(0, maxLength) + '...';
        }
        return description;
      }

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
                        <td>${truncateDescription(product.description, 50)}</td> 
                        <td>${product.price}</td>
                        <td>${product.rating}</td>
                        <td><img src="${product.image}" alt="Thumbnail" width="50px"></td>
                        <td>${product.gas}</td>
                        <td>${product.charcoal}</td>
                        <td>${product.pellet}</td>
                        <td>${product.sale}</td>

                   `
                    if(product.sale){
                        content += `
                        <td><a id="disableProduct${product.id}" class="btn btn-secondary btn-sm" href="#">Produkt deaktivieren</a></td>
                        `
                    }else{
                        content += `
                        <td><a id="enableProduct${product.id}" class="btn btn-success btn-sm" href="#">Produkt aktivieren</a></td>
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

    function changeStatus(id, newValue){                            //changes user status to the respective opposite
        
        $.ajax({

            url: "../Backend/RequestHandler.php?resource=product&params[id]=" +  id + "&params[newValue]=" + newValue,
            method: "PUT",
            dataType: "json",

            success: function(){
                console.log("changed");
                load_productList();
                
            },
            error: function(response){
                console.log(response)
            }
        })

    }


})