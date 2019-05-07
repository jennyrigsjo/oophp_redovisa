<?php

namespace Anri16\Dice101;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Dice100Controller implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * Landing page for the game.
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Spela Tärningsspelet 100";
        $baseURL = $this->app->request->getBaseUrl();
        $data = ["startGameUrl" => $baseURL . "/dice101/end-session"];
        $this->app->page->add("dice101/index", $data);
        return $this->app->page->render([
            "title" => $title
        ]);
    }

    /**
     * Initiate the game.
     *
     * @return object
     */
    public function initAction() : object
    {
        $this->app->session->set("game", null);

        if ($this->app->session->get("game") === null) {
            $this->app->session->set("game", new Dice100(null, null, true));
        }

        $game = $this->app->session->get("game");
        $this->app->session->set("firstRound", $game->getCurrentPlayerName());

        return $this->app->response->redirect("dice101/which-player");
    }

    /**
     * Check whose turn it is to roll the dice
     * and redirect to the appropriate route.
     *
     * @return object
     */
    public function whichPlayerAction() : object
    {
        $game = $this->app->session->get("game");

        $player1 = $game->getPlayer1Name();
        $currentPlayer = $game->getCurrentPlayerName();
        $somebodyWon = $game->somebodyWon();

        if ($somebodyWon || $player1 === $currentPlayer) { // somebody won or player is human
            return $this->app->response->redirect("dice101/play");
        } else { //player is computer
            return $this->app->response->redirect("dice101/computer-play");
        }
    }

    /**
     * Show the current game status and let the human player
     * make their move.
     *
     * @return object
     */
    public function playAction() : object
    {
        $title = "Spela Tärningsspelet 100";

        $game = $this->app->session->get("game");

        $firstRound = $this->app->session->getOnce("firstRound", null);

        $currentPlayer = $firstRound ?? $game->getCurrentPlayerName();

        $player1 = $game->getPlayer1Name();
        $player2 = $game->getPlayer2Name();

        $player1score = $game->getPlayer1TotalScore();
        $player2score = $game->getPlayer2TotalScore();

        $currentRoundScore = $game->getCurrentRoundScore();
        $targetScore = $game->getTargetScore();

        $player1Status = $this->app->session->getOnce("player1Status", []);
        $player2Status = $this->app->session->getOnce("player2Status", []);

        $player1LastRolls = $this->app->session->getOnce("player1LastRolls", []);
        $player2LastRolls = $this->app->session->getOnce("player2LastRolls", []);

        $player1Histogram = $game->getPlayer1Histogram();
        $player2Histogram = $game->getPlayer2Histogram();

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
            "player1Status" => $player1Status,
            "player2Status" => $player2Status,
            "player1LastRolls" => $player1LastRolls,
            "player2LastRolls" => $player2LastRolls,
            "somebodyWon" => $somebodyWon,
            "player1Histogram" => $player1Histogram,
            "player2Histogram" => $player2Histogram
        ];

        $this->app->page->add("dice101/play", $data);
        //$this->app->page->add("dice101/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Let the computer make its move.
     *
     * @return object
     */
    public function computerPlayAction() : object
    {
        $game = $this->app->session->get("game");
        $currentRoundScore = $game->getCurrentRoundScore();
        $player1score = $game->getPlayer1TotalScore();
        $player2score = $game->getPlayer2TotalScore();

        if ($currentRoundScore < 15 && $player2score < $player1score) {
            return $this->app->response->redirect("dice101/roll-dice");
        } elseif ($currentRoundScore > 0) {
            return $this->app->response->redirect("dice101/save-score");
        } else {
            return $this->app->response->redirect("dice101/roll-dice");
        }
    }

    /**
     * Roll the dice.
     *
     * @return object
     */
    public function rollDiceAction() : object
    {
        $game = $this->app->session->get("game");
        $currentPlayer = $game->getCurrentPlayerName();
        $game->rollDice();
        if ($currentPlayer === $game->getPlayer1Name()) {
            $this->app->session->set("player1Status", $game->getPlayer1Status());
            $this->app->session->set("player1LastRolls", $game->getPlayer1LastRolls());
        } else {
            $this->app->session->set("player2Status", $game->getPlayer2Status());
            $this->app->session->set("player2LastRolls", $game->getPlayer2LastRolls());
        }
        return $this->app->response->redirect("dice101/which-player");
    }

    /**
     * Save current score and add it to player's total score.
     *
     * @return object
     */
    public function saveScoreAction() : object
    {
        $game = $this->app->session->get("game");
        $currentPlayer = $game->getCurrentPlayerName();
        $game->saveScore();
        if ($currentPlayer === $game->getPlayer2Name()) {
            $this->app->session->set("player2Status", $game->getPlayer2Status());
            $this->app->session->set("player2LastRolls", $game->getPlayer2LastRolls());
        }
        return $this->app->response->redirect("dice101/which-player");
    }

    /**
     * End current game session and redirect to reinit the game.
     *
     * @return object
     */
    public function endSessionAction() : object
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
        //session_destroy();
        $this->app->session->destroy();
        //echo "The session is destroyed.";
        return $this->app->response->redirect("dice101/init");
    }
}
