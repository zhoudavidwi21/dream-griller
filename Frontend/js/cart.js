$(document).ready(function() {  

    
    $('#cartbtn').popover({
        placement: 'bottom',
        title: 'Ihre Produkte',
        content: 'testing 123', //muss durch die eigentlichen Produkte ersetzt werden
        trigger: 'click'
    })

    let cnt = 0;    // dieser Wert muss noch mit einem GET ajax call von der DB geholt werden (Anzahl der Prod. im Warenkorb)

    $("[id^=prodcart").on("click", function(){

        $.ajax({
            type: "post",
            url: "./sites/homepage.php", // hier sollte dann ein php service aufgerufen werden, wo das Produkt in die DB gespeichert wird
            data: cnt,
            success: function() {
                $("#quantity").text(cnt + 1)
                cnt += 1;
            },
            error: function () {
                console.log("error");
            }
        });

    })


});