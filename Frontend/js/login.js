function logout() {
    $.ajax({
        url: './res/templates/logout.php',
        method: 'GET',
        success: function () {
            location.reload();
        }
    });
}
$(document).ready(function () {
    $("#loginForm").on("submit", function(e) {
        e.preventDefault();
        const form = $(e.target);
        const json = convertFormToJSON(form);
        // Send the login info to server
        login(json);
    });

    // Function to generate a random 5-digit alphanumeric coupon code

    function login(json) {
        // Send the coupon code as JSON
        $.ajax({
            url: '../Backend/RequestHandler.php?resource=login',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify(json),
            contentType: 'application/json',
            success: function(response) {
                if (response.loginStatus === 'failed') {
                    let message = ''
                    switch (response.errorCode) {
                        case 1:
                            message = 'Password ist falsch.'
                            break
                        case 2:
                            message = 'Benutzer nicht gefunden.'
                            break

                        default:
                            message = 'Unbekannter Fehler.'
                    }

                    showAlert('danger', `Login fehlgeschlagen! \n Fehler: ${message}`)
                } else {
                    // similar behavior as an HTTP redirect
                    // with replace cannot go back
                    window.location.replace("index.php");
                    console.log("Successfully logged in");
                }

            },
            error: function(xhr, status, error) {
                showAlert('danger', 'Fehler beim Login!');
                console.log("There has been an error");
                console.log(error);
            }
        });
    }
})