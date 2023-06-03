<?php
//must be on every page before the HTML
if (!isset($_SESSION)) {
    session_start(); //must be at the beginning of each session 
}

//logout function 
$_SESSION = array();
session_unset();
session_destroy();
if (isset($_COOKIE['userId'])) {
    unset($_COOKIE['userId']); 
    setcookie('userId', null, time() - 3600, "/"); 
}
if (isset($_COOKIE['username'])) {
    unset($_COOKIE['username']); 
    setcookie('username', null, time() - 3600, "/"); 
}
if (isset($_COOKIE['loginCookie'])) {
    unset($_COOKIE['loginCookie']); 
    setcookie('loginCookie', null, time() - 3600, "/"); 
}
header('Refresh:0; url=../index.php');
