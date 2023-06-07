// Formularübermittlung abfangen
document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault(); // Das Standardformularverhalten verhindern
  
    // Formulardaten sammeln
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
  
    // AJAX-Anfrage senden
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./sites/login_alternative.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          // wenn Anmeldung erfolgreich, leiten Sie den Benutzer weiter
          window.location.href = "../index.php";
        } else {
          // wenn Anmeldung fehlgeschlagen, Fehlermeldung anzeigen
          alert(response.message);
        }
      }
    };
    
    // Daten in das gewünschte Format codieren (z. B. URL-Codierung)
    var data = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
  
    // AJAX-Anfrage senden
    xhr.send(data);
  });
  