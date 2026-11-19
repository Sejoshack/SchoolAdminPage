
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_admin() {

    if (empty($_SESSION["admin_id"])) {
        header("Location: login.php");
        exit();
    }

}

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

function verify_csrf() {

    if (
        !isset($_POST["csrf_token"]) ||
        !isset($_SESSION["csrf_token"]) ||
        !hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])
    ) {
        die("Invalid request. Please try again.");
    }

}

?>
