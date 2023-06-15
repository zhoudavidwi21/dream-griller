$(document).ready(function() {

    //--- from userList start ---//
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
                            <td><a id="ordersUser${user.id}" class="btn btn-primary btn-sm" href="#">Bestellungen ansehen</a></td>                    
                            <td><a id="invoicesUser${user.id}" class="btn btn-primary btn-sm" href="#">Rechnungen ansehen</a></td>                    
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
    //--- from userList start ---//

    //--- from userProfile start ---//
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
    //--- from userProfile end ---//

    //--- from addUser start ---//
    $("#registrationForm").on("submit", function(e) {
        e.preventDefault();
        const form = $(e.target);
        const json = convertFormToJSON(form);
        // Send the coupon code to the server
        if (validateForm()) {
            submitUser(json);
        }
    });

    // Function to generate a random 5-digit alphanumeric coupon code

    function submitUser(json) {
        // Send the coupon code as JSON
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=user',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify(json),
            contentType: 'application/json',
            success: function(response) {
                // similar behavior as an HTTP redirect
                // with replace cannot go back
                window.location.replace("/DreamGriller/Frontend/index.php?site=register_confirmed");
                console.log("Successfully created user");
            },
            error: function(xhr, status, error) {
                showAlert('danger', 'Fehler bei der Registrierung!');
                console.log("There has been an error");
                console.log(error);
            }
        });
    }

    console.log()

    function validateForm() {

        // Check the gender field (not empty)
        var gender = document.getElementById('anrede').value;
        if (gender === "") {
            alert("Anrede ist erforderlich.");
            return false;
        }

        // Check the company field
        // If gender is filled with "Firma" then company must be filled
        // If company is filled, then gender must be set on "Firma"
        var company = document.getElementById('firmenname').value;
        if (gender === "firma" && company.trim() === "") {
            alert("Firmenname ist erforderlich, wenn 'Firma' als Anrede ausgewählt ist.");
            return false;
        } else if (company.trim() !== "" && gender !== "firma") {
            alert("Anrede muss auf 'Firma' gesetzt werden, wenn ein Firmenname angegeben ist.");
            return false;
        } else if (company.trim() !== "" && !/^[A-Za-z0-9\s\.\-]+$/.test(company)) {
            alert("Ungültiger Firmenname. Bitte geben Sie nur Groß- und Kleinbuchstaben, Zahlen, Leerzeichen, Punkt und Bindestrich ein.");
            return false;
        }

        //  Check the first name field (not empty and only allowed characters)
        var firstname = document.getElementById('vorname').value;
        if (firstname.trim() === '') {
            alert("Vorname ist erforderlich.");
            return false;
        }
        else if (!/^[A-Za-z\s\-]+$/.test(firstname)) {
            alert("Ungültiger Vorname. Bitte geben Sie nur Groß- und Kleinbuchstaben, Leerzeichen und Bindestriche ein.");
            return false;
        }

        // Check the last name field (not empty and only allowed characters)
        var lastname = document.getElementById('nachname').value;
        if (lastname.trim() === '') {
            alert("Nachname ist erforderlich.");
            return false;
        }
        else if (!/^[A-Za-z\s\-]+$/.test(lastname)) {
            alert("Ungültiger Nachname. Bitte geben Sie nur Groß- und Kleinbuchstaben, Leerzeichen und Bindestriche ein.");
            return false;
        }

        // Check the adress field (not empty and only allowed characters)
        var address = document.getElementById('adresse').value;
        if (address.trim() === '') {
            alert("Adresse ist erforderlich.");
            return false;
        }
        else if (!/^[A-Za-z0-9\s\/\-\.]+$/.test(address)) {
            alert("Ungültige Adresse. Bitte geben Sie nur Groß- und Kleinbuchstaben, Zahlen, Leerzeichen, Schrägstriche, Bindestriche und Punkte ein.");
            return false;
        }

        // Check the postcode field (not empty and only allowed characters)
        var postcode = document.getElementById('postleitzahl').value;
        if (postcode.trim() === '') {
            alert("Postleitzahl ist erforderlich.");
            return false;
        }
        else if (!/^[0-9]+$/.test(postcode)) {
            alert("Ungültige Postleitzahl. Bitte geben Sie nur Zahlen ein.");
            return false;
        }

        // Check the city field (not empty and only allowed characters)
        var city = document.getElementById('ort').value;
        if (city.trim() === '') {
            alert("Ort ist erforderlich.");
            return false;
        }
        else if (!/^[a-zA-Z\s-]+$/.test(city)) {
            alert("Ungültiger Ort. Bitte verwenden Sie nur Groß- und Kleinbuchstaben, Leerzeichen und Bindestriche.");
            return false;
        }

        // Check the email field (not empty and only with correct format e.g. xxxxx@xxxxx.xxx and standard-email-criterias)
        var email = document.getElementById('email').value;
        if (email.trim() === '') {
            alert("E-Mail-Adresse ist erforderlich.");
            return false;
        }
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert("Ungültiges E-Mail-Format. Bitte geben Sie eine gültige E-Mail-Adresse ein.");
            return false;
        }

        // Check the username field (not empty and only allowed characters)
        // Function to check if username is unique in the database
        var username = document.getElementById('benutzername').value;
        if (username.trim() === '') {
            alert("Benutzername ist erforderlich.");
            return false;
        }
        if (!/^[a-zA-Z0-9]+$/.test(username)) {
            alert("Ungültiger Benutzername. Bitte verwenden Sie nur Groß- und Kleinbuchstaben sowie Zahlen.");
            return false;
        }
        isUsernameUnique(username);

        // Check the password field (not empty)
        // Requirements: more than 5 characters and at least 1 upper case letter, 1 lower case letter and 1 number each
        var password = document.getElementById('passwort').value;
        if (password.trim() === '') {
            alert("Passwort ist erforderlich.");
            return false;
        } else if (password.length < 5) {
            alert("Passwort muss mindestens 5 Zeichen lang sein.");
            return false;
        } else if (!/[A-Z]/.test(password)) {
            alert("Passwort muss mindestens einen Großbuchstaben enthalten.");
            return false;
        } else if (!/[a-z]/.test(password)) {
            alert("Passwort muss mindestens einen Kleinbuchstaben enthalten.");
            return false;
        } else if (!/[0-9]/.test(password)) {
            alert("Passwort muss mindestens eine Ziffer enthalten.");
            return false;
        }

        // Check the passwordCheck field (not empty and must contain the same as the password field)
        var passwordCheck = document.getElementById('passwortWiederholen').value;
        if (passwordCheck.trim() === '') {
            alert("Passwort wiederholen ist erforderlich.");
            return false;
        } else if (password !== passwordCheck) {
            alert("Die Passwörter stimmen nicht überein.");
            return false;
        }

        // Check if the data security checkbox was clicked
        var dataSecurityCheckbox = document.getElementById('data_security');
        if (!dataSecurityCheckbox.checked) {
            alert("Sie müssen den Datenschutz akzeptieren.");
            return false;
        }

        // Check if the terms_and_conditions checkbox was clicked
        var terms_and_conditionsCheckbox = document.getElementById('terms_and_conditions');
        if (!terms_and_conditionsCheckbox.checked) {
            alert("Sie müssen die AGBs akzeptieren.");
            return false;
        }

        // If all checks are successful, submit the form
        return true;
    }



//----------------------------------------------------------------

// konnte ich bis jetzt noch nicht einwandfrei zum Laufen bringen
//sowohl username und email müssen ja unique sein für den Login
// beim folgenden Code wird es schon vorher bei abgebrochen und als fehler dargestellt
// evt hier Hilfe von euch notwendig

    function isUsernameUnique() {
        var username = document.getElementById('benutzername').value;

        // AJAX Request erstellen
        var xhr = new XMLHttpRequest();
        xhr.open('POST', './businesslogic/check_username_uniqueness.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.unique) {
                    // Der Benutzername ist eindeutig
                } else {
                    // Der Benutzername ist bereits vergeben
                    alert("Der Benutzername ist bereits vergeben. Bitte wählen Sie einen anderen Benutzernamen.");
                }
            }
        };

        // Parameter für die AJAX-Anfrage erstellen
        var params = 'username=' + encodeURIComponent(username);

        // AJAX-Anfrage senden
        xhr.send(params);
    }


// andere Variante:

    function isUsernameUnique(username) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);
                if (response.unique) {
                    // Der Benutzername ist eindeutig
                } else {
                    // Der Benutzername ist bereits vergeben
                    alert("Der Benutzername ist bereits vergeben. Bitte wählen Sie einen anderen Benutzernamen.");
                }
            }
        };
        xhttp.open("GET", "./businesslogic/check_username_uniqueness.php?username=" + encodeURIComponent(username), true);
        xhttp.send();
    }
    //--- from addUser start ---//
})