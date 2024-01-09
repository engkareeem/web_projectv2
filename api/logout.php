<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Perform logout actions, e.g., unset or destroy the session

    // Set the "userId" cookie to expire in the past, effectively deleting it
    setcookie("userId", "", time() - 3600, "/");

    // Redirect to a login page or any other page after logout
    echo 'success';
    exit;
}
?>