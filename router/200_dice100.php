<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Initialize the game and redirect to play the game.
 */
$app->router->get("dice100/init", function () use ($app) {
    $_SESSION["game"] = null;
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Anri16\Dice100\Dice100(null, null, true);
    }
    $game = $_SESSION["game"];
    $_SESSION["firstRound"] = true;
    $_SESSION["whoStarts"] = $game->getCurrentPlayerName();
    return $app->response->redirect("dice100/which-player");
});

/**
 * Check who the current player is and redirect to let them make their move.
 */
$app->router->get("dice100/which-player", function () use ($app) {
    $game = $_SESSION["game"];
    $player1 = $game->getPlayer1Name();
    $currentPlayer = $game->getCurrentPlayerName();
    $somebodyWon = $game->somebodyWon();

    if ($somebodyWon || $player1 === $currentPlayer) { // player is human
        return $app->response->redirect("dice100/play");
    } else { //player is computer
        $_SESSION["redirectToComputerPlay"] = true;
        return $app->response->redirect("dice100/computer-play");
    }
});

/**
 * Show current game status.
 */
$app->router->get("dice100/play", function () use ($app) {
    $title = "Spela Tärningsspelet 100";
    $game = $_SESSION["game"];

    $firstRound = $_SESSION["firstRound"] ?? null;
    $_SESSION["firstRound"] = null;

    $currentPlayer = $_SESSION["whoStarts"] ?? $game->getCurrentPlayerName();
    $_SESSION["whoStarts"] = null;

    $player1 = $game->getPlayer1Name();
    $player2 = $game->getPlayer2Name();

    $player1score = $game->getPlayerTotalScore($player1);
    $player2score = $game->getPlayerTotalScore($player2);

    $currentRoundScore = $game->getCurrentRoundScore();
    $targetScore = $game->getTargetScore();

    $sessionStatus = $_SESSION["status"] ?? null;
    $_SESSION["status"] = null;

    $gameStatus = $game->getGameStatus();
    $gameStatus = ($sessionStatus === $gameStatus) ? $gameStatus : $sessionStatus . " " . $gameStatus;

    $dice = $_SESSION["dice"] ?? null;
    $_SESSION["dice"] = null;

    $somebodyWon = $game->somebodyWon();

    $data = [
        "firstRound" => $firstRound,
        "currentPlayer" => $currentPlayer,
        "player1" => $player1,
        "player2" => $player2,
        "player1score" => $player1score,
        "player2score" => $player2score,
        "currentRoundScore" => $currentRoundScore,
        "targetScore" => $targetScore,
        "gameStatus" => $gameStatus,
        "dice" => $dice,
        "somebodyWon" => $somebodyWon
    ];

    $app->page->add("dice100/play", $data);
    //$app->page->add("dice100/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Computer makes its move.
 */
$app->router->get("dice100/computer-play", function () use ($app) {
    $game = $_SESSION["game"];
    $game->rollDice();
    $currentRoundScore = $game->getCurrentRoundScore();

    if ($currentRoundScore >= 15) {
        $game->saveScore();
    }

    return $app->response->redirect("dice100/which-player");
});

/**
 * Roll the dice.
 */
$app->router->post("dice100/roll-dice", function () use ($app) {
    if ($_POST["rollDice"] ?? false) {
        $game = $_SESSION["game"];
        $_SESSION["dice"] = $game->rollDice();
        $_SESSION["status"] = $game->getGameStatus();
        return $app->response->redirect("dice100/which-player");
    }
});

/**
 * Save current score and add it to player's total score.
 */
$app->router->post("dice100/save-score", function () use ($app) {
    if ($_POST["saveScore"] ?? false) {
        $game = $_SESSION["game"];
        $game->saveScore();
        return $app->response->redirect("dice100/which-player");
    }
});

/**
 * End current game session and redirect to reinit the game - GET.
 */
$app->router->get("dice100/end-session", function () use ($app) {
    endSession();
    return $app->response->redirect("dice100/init");
});

/**
 * End current game session and redirect to reinit the game - POST.
 */
$app->router->post("dice100/end-session", function () use ($app) {
    if ($_POST["endSession"] ?? false) {
        endSession();
        return $app->response->redirect("dice100/init");
    }
});
