$(document).ready(function(){
    
    /*$.ajax({
        type: "GET",
        url: "./res/sample.json",
        success: function(response){
            for(i in response){
                let entry = response[i]

                $("#pic" + i).attr("src", "./res/img/grill" + i + ".png")
                $("#text" + i).text(entry.info)
                $("#title" + i).text(entry.name)
                $("[id^=prodcart]").on("click", putInCart) 

            }
        },
        error: function(){
            console.log("error")
        }
    })


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
        

    }*/
})