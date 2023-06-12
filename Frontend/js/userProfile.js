$(document).ready(function() {

    /*$(document).on('click', '[id^=disableUser]', function(){
        changeStatus(parseInt($(this).attr("id").slice(11), 10), false)
    })                                                                                  //slice userID from pushed buttons
    $(document).on('click', '[id^=enableUser]', function(){
        changeStatus(parseInt($(this).attr("id").slice(10), 10), true)
    });*/

    let id = $("#profile_id").val()
    load_UserInfo(id)


    function load_UserInfo(id){
        $.ajax({
            url: "../Backend/RequestHandler.php",
            method: "GET",
            dataType: "json",
            data: {
                resource: "user",
                params: {
                  id: id
                }
            },
            success: function(response){
                //console.log(response);
            
                $("#profile_id").val(response.id)
                $("#profile_username").val(response.username)
                $("#profile_firstname").val(response.firstname)
                $("#profile_lastname").val(response.lastname)
                $("#profile_email").val(response.email)
                $("#profile_company").val(response.company)
                $("#profile_postcode").val(response.postcode)
                $("#profile_city").val(response.city)
                $("#profile_adress").val(response.adress)
                $("#profile_paymethod").val(response.paymethod)
                    
            },
            error: function(response){
                console.log(response)
            }
        })
    }

    $("#profileform").on("submit", function(e){
        e.preventDefault();
        const formData = new FormData(this);

        submitProfile(formData);
    })

    function submitProfile(formData){
        $.ajax({
            url: "../Backend/RequestHandler.php?resource=userprofile",
            method: "POST",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,

            success: function(response){
                console.log(response)
            },
            error: function(response){
                console.log(response)
            }
        })
    }

})