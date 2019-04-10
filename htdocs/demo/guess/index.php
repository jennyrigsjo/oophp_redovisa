<?php
/**
 * A simple client for the game 'Guess my number'.
 */
include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");
// Class files and/or autoloaders must be included before session starts!

if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}

$game = $_SESSION["game"];
$number = $game->getNumber();
$tries = $game->getTries();

$result = null;
$exception = null;

//Deal with incoming variables
$makeGuess = $_POST["makeGuess"] ?? null;
$cheat = $_POST["cheat"] ?? null;
$guess = $_POST["guess"] ?? null;

if ($makeGuess) {
    try {
        $result = $game->makeGuess($guess);
        $tries = $game->getTries();
    } catch (GuessException $e) {
        $class = get_class($e);
        $message = $e->getMessage();
        $exception = "Got exception {$class}: <b>{$message}</b>";
    }
}

require __DIR__ . "/view/form.php";
