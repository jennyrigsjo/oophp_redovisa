<?php
/**
 * Destroy the session.
 */
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");
// Class files and/or autoloaders must be included before session starts!

if ($_POST["initGame"] ?? false) {
    // Unset all of the session variables.
    $_SESSION = [];

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
    //echo "The session is destroyed.";

    $url = "index.php";
    header("Location: $url");
}
