$(document).ready(function() {

    let id = $("#profile_id").val();
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

        const plainPassword = $("#profile_password").val()
        const id = $("#profile_id").val()

        checkPassword(formData, plainPassword, id)
    })

    function checkPassword(formData, plainPassword, id){
        $.ajax({
            
            url: '../Backend/RequestHandler.php?resource=userpw',
            type: 'POST',
            data: { password: plainPassword,  id: id},
            success: function(response) {
              if(response){
                $("#userChangeSuccess").show();
                submitProfile(formData)

                setTimeout(function() {
                    $("#userChangeSuccess").hide();
                }, 3000);


              }else{
                $("#userChangeFail").show();

                setTimeout(function() {
                    $("#userChangeFail").hide();
                }, 3000);
              }
            },
            error: function(error) {
              console.error(error);
            }
          });

    }

    function submitProfile(formData){
        $.ajax({
            url: "../Backend/RequestHandler.php?resource=userprofile",
            method: "POST",
            dataType: "json",
            data: formData,
            contentType: false,
            processData: false,

            success: function(response){
                //console.log(response)
            },
            error: function(response){
                //console.log(response)
            }
        })
    }

    $("#passwordform").on("submit", function(e){
        e.preventDefault();

        const oldPw = $("#old_pw").val();
        const newPw = $("#new-pw").val();
        const newPwValidation = $("#new-pw-validate").val();

        validateNewPassword(oldPw, newPw, newPwValidation)
    })

    function validateNewPassword(oldPw, newPw, newPwValidation){
        $.ajax({
            
            url: '../Backend/RequestHandler.php?resource=newpw',
            type: 'POST',
            data: { old: oldPw,  new: newPw, newPwValidation: newPwValidation},
            success: function(response) {
                if(response){
                    $("#pwChangeSuccess").show();
    
                    setTimeout(function() {
                        $("#pwChangeSuccess").hide();
                    }, 3000);
    
                  }else{
                    $("#pwChangeFail").show();
    
                    setTimeout(function() {
                        $("#pwChangeFail").hide();
                    }, 3000);
                  }
            },
            error: function(error) {
                console.error(error);
            }
          });
    }

    

})