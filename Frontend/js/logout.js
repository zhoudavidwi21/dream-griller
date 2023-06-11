// Not in use because every change/reload of the site calls logout

window.addEventListener('beforeunload', function(event) {
    // Check if the "loginCookie" is set
    if (!document.cookie.includes('loginCookie')) {
        // Sending an AJAX request to logout.php
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './res/templates/logout.php', false);
        xhr.send();
    }
});
