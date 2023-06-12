$(document).ready(function() {

    $(document).on('click', '[id^=disableUser]', function(){
        changeStatus(parseInt($(this).attr("id").slice(11), 10), false)
    })                                                                                  //slice userID from pushed buttons
    $(document).on('click', '[id^=enableUser]', function(){
        changeStatus(parseInt($(this).attr("id").slice(10), 10), true)
    });

    load_userList()

    function load_userList(){                                                           //loads all current users from DB

        $.ajax({

            url: "../Backend/RequestHandler.php",
            method: "GET",
            dataType: "json",
            data: {resource: "users"},

            success: function(response){

                console.log(response);
                $('#userTable').empty();
                let content = "";

                $.each(response, function(key, user) {

                    if(user.username !== "admin"){

                        content += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>                       
                            <td>${user.firstname}</td>
                            <td>${user.lastname}</td>
                            <td>${user.company}</td>
                            <td>${user.gender}</td>
                            <td>${user.adress}</td>
                            <td>${user.postcode}</td>                        
                            <td>${user.city}</td>
                            <td>${user.paymethod}</td>
                            <td>${user.enabled}</td>
                            <td><a id="ordersUser${user.id}" class="btn btn-primary btn-sm" href="#">Bestellungen</a></td>                    

                        `
                        if(user.enabled){
                            content += `
                            <td><a id="disableUser${user.id}" class="btn btn-secondary btn-sm" href="#">Deaktivieren</a></td>
                            `
                        }else{
                            content += `
                            <td><a id="enableUser${user.id}" class="btn btn-success btn-sm" href="#">Aktivieren</a></td>
                            `
                        }

                        content += "</tr>"                              //appends table row for every DB entry
                    }

                    
                });

                $('#userTable').html(content);
                    
            },
            error: function(response){
                console.log(response)
            }
        })
    }

    function changeStatus(id, newValue){                            //changes user status to the respective opposite
        
        $.ajax({

            url: "../Backend/RequestHandler.php?resource=user&params[id]=" +  id + "&params[newValue]=" + newValue,
            method: "PUT",
            dataType: "json",

            success: function(){
                console.log("changed");
                load_userList();
                
            },
            error: function(response){
                console.log(response)
            }
        })

    }



})