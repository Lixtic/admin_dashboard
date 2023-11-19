<?php
session_start();
session_destroy(); // Destroy the user's session.

// Redirect the user to the login page or any other appropriate page.
header("Location: index.html"); // 
?>
