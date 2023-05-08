$(document).ready(function(){
    
    $.ajax({
        type: "GET",
        url: "./res/sample.json",
        success: function(response){
            console.log(response)

            for(i in response){
                console.log(i)
                let entry = response[i]

                $("#pic" + i).attr("src", "./res/img/grill" + i + ".png")
                $("#text" + i).text(entry.info)
                $("#title" + i).text(entry.name)
            }


        },
        error: function(error){
            console.log(error)
        }
    }
    )
})