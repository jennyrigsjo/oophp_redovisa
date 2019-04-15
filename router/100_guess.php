<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Terminate the current game session.
 * @return void
 */
function endSession()
{
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
}

/**
 * Initialize the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Anri16\Guess\Guess();
    }
    return $app->response->redirect("guess/play");
});

/**
 * Play the game - show current game status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Spela Gissa mitt nummer";

    $game = $_SESSION["game"];
    $tries = $game->getTries();

    //Get current values from session variables
    $makeGuess = $_SESSION["makeGuess"] ?? null;
    $cheat = $_SESSION["cheat"] ?? null;
    $number = $_SESSION["number"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $result = $_SESSION["result"] ?? null;
    $exception = $_SESSION["exception"] ?? null;

    //Reset session variables
    $_SESSION["makeGuess"] = null;
    $_SESSION["cheat"] = null;
    $_SESSION["number"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["result"] = null;
    $_SESSION["exception"] = null;

    $data = [
        "tries" => $tries,
        "makeGuess" => $makeGuess,
        "cheat" => $cheat,
        "number" => $number,
        "guess" => $guess,
        "result" => $result,
        "exception" => $exception
    ];

    $app->page->add("guess/play", $data);
    //$app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess.
 */
$app->router->post("guess/make-guess", function () use ($app) {
    $game = $_SESSION["game"];

    //Deal with incoming variables
    $_SESSION["makeGuess"] = $_POST["makeGuess"] ?? null;
    $_SESSION["guess"] = $_POST["guess"] ?? null;

    if ($_POST["makeGuess"]) {
        try {
            $_SESSION["result"] = $game->makeGuess($_SESSION["guess"]);
        } catch (Exception $e) {
            $class = get_class($e);
            $message = $e->getMessage();
            $_SESSION["exception"] = "Got exception {$class}: <b>{$message}</b>";
        }
    }

    return $app->response->redirect("guess/play");
});

/**
 * Play the game - cheat.
 */
$app->router->post("guess/cheat", function () use ($app) {
    $game = $_SESSION["game"];

    //Deal with incoming variables
    $_SESSION["cheat"] = $_POST["cheat"] ?? null;

    if ($_POST["cheat"]) {
        try {
            $_SESSION["number"] = $game->getNumber();
        } catch (Exception $e) {
            $class = get_class($e);
            $message = $e->getMessage();
            $_SESSION["exception"] = "Got exception {$class}: <b>{$message}</b>";
        }
    }

    return $app->response->redirect("guess/play");
});

/**
 * End current game session and redirect to reinit the game - GET.
 */
$app->router->get("guess/end-session", function () use ($app) {
    endSession();
    return $app->response->redirect("guess/init");
});

/**
 * End current game session and redirect to reinit the game - POST.
 */
$app->router->post("guess/end-session", function () use ($app) {
    if ($_POST["endSession"] ?? false) {
        endSession();
        return $app->response->redirect("guess/init");
    }
});
