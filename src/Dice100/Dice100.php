<?php
/**
 * This file contains code to implement the class Dice100.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice100;

/**
 * Main class/API for the game 'Dice 100'.
 */
class Dice100
{
    /**
     * @var int $targetScore    The target score to be reached.
     */
    private $targetScore = null;

    /**
     * @var Player $player1     Player 1 participating in the game.
     */
    private $player1 = null;

    /**
     * @var Player $player2     Player 2 participating in the game.
     */
    private $player2 = null;

    /**
     * @var Round $round    The current round of the game.
     */
    private $round = null;

    /**
     * @var string $status     A textual description of the current status of the game.
     */
    private $status = null;


    /**************************************************************************************
                                        Public methods
    ***************************************************************************************/


    /**
     * Constructor to initiate the game with current settings,
     * if available.
     *
     * @param string $player1 The name of player 1, default 'You'.
     * @param string $player2 The name of player 2, default 'Computer'.
     * @param bool $randomPlayer Randomize which player starts, default is player 1.
     *
     */
    public function __construct(string $player1 = null, string $player2 = null, bool $randomPlayer = false)
    {
        $this->targetScore = 100;

        $player1 = ($player1 === null) ? "You" : $player1;
        $player2 = ($player2 === null) ? "Computer" : $player2;

        $this->player1 = new Player($player1);
        $this->player2 = new Player($player2);

        if ($randomPlayer) {
            $playerOne = 0;
            $playerTwo = 0;
            while ($playerOne === $playerTwo) {
                $playerOne = mt_rand(1, 6);
                $playerTwo = mt_rand(1, 6);
            }
            $playerStarts = ($playerOne > $playerTwo) ? $this->player1 : $this->player2;
            $this->round = new Round($playerStarts);
        } else {
            $this->round = new Round($this->player1);
        }

        $this->status = "";
    }

    /**
     * Get the name of player 1.
     *
     * @return string as the name of player 1.
     */
    public function getPlayer1Name()
    {
        return $this->player1->getName();
    }

    /**
     * Get the name of player 2.
     *
     * @return string as the name of player 2.
     */
    public function getPlayer2Name()
    {
        return $this->player2->getName();
    }

    /**
     * Get the name of the player playing the current round.
     *
     * @return string as the name of the player of the current round.
     *
     */
    public function getCurrentPlayerName()
    {
        return $this->round->getPlayer()->getName();
    }

    /**
     * Get the current total score of a player.
     *
     * @param string The name of the player.
     *
     * @return int as the total score of the player.
     */
    public function getPlayerTotalScore($playerName)
    {
        if ($this->player1->getName() === $playerName) {
            return $this->player1->getScore();
        } else {
            return $this->player2->getScore();
        }
    }

    /**
     * Get the current score of the current round.
     *
     * @return int as the score of the current round.
     *
     */
    public function getCurrentRoundScore()
    {
        return $this->round->getScore();
    }

    /**
     * Get the target score of the game.
     *
     * @return int as the target score.
     */
    public function getTargetScore()
    {
        return $this->targetScore;
    }

    /**
     * Get the current status of the game.
     *
     * @return string as a textual description of the game's status.
     *
     */
    public function getGameStatus()
    {
        return $this->status;
    }

    /**
     * Roll the dice used in the current round and get a graphic view of the result.
     *
     * @return array as a list of class names representing the graphic versions of the rolled dice.
     */
    public function rollDice()
    {
        $this->round->getDice()->roll();
        $dice = $this->round->getDice()->getGraphics();
        $this->arbitrateResult();
        return $dice;
    }

    /**
     * Add current round score to current player's total score.
     * Start a new round if current player has not won the game.
     */
    public function saveScore()
    {
        $this->round->saveScore();
        $playerTotalScore = $this->round->getPlayer()->getScore();
        if (!($playerTotalScore >= $this->targetScore)) {
            $this->newRound();
        }
    }

    /**
     * Check if a player has won the game by comparing the players' respective total scores.
     *
     * @return bool as a true or false evaluation of whether a player has won the game.
     */
    public function somebodyWon()
    {
        $player1score = $this->player1->getScore();
        $player2score = $this->player2->getScore();
        return ($player1score >= $this->targetScore || $player2score >= $this->targetScore);
    }


    /**************************************************************************************
                                        Private methods
    ***************************************************************************************/

    /**
     * Calculate points earned from last roll and either start a new round or
     * add the points to the current round score. Check for a winner.
     * Update game status message accordingly.
     */
    private function arbitrateResult()
    {
        $currentPlayer = $this->round->getPlayer()->getName();
        $points = $this->calculatePoints();

        if ($points === 0) {
            $this->status = "{$currentPlayer} rolled a 1-die and got 0 points.";
            $this->newRound();
        } else {
            $this->round->addToScore($points);
            if ($this->currentPlayerWins()) {
                $this->round->saveScore();
                $this->status = "{$currentPlayer} won the game! <a href='end-session'>Play again?</a>";
            } else {
                if ($currentPlayer === $this->player2->getName()) {
                    $this->status = "{$currentPlayer} rolled and got a total round score of {$this->round->getScore()} points.";
                } else {
                    $this->status = "{$currentPlayer} rolled and got {$points} points.";
                }
            }
        }
    }


    /**
     * Calculate the points earned from last roll.
     *
     * @return int as the number of points earned from last roll. If 0 is returned,
     * it means the player rolled at least one die with the value 1 so no points were earned.
     */
    private function calculatePoints()
    {
        $points = 0;
        $values = $this->round->getDice()->getValues(); //get values from last roll

        if (!in_array(1, $values, true)) { //the values from last roll do not include the value 1
            $points = $this->round->getDice()->sumValues(); //calculate points earned from last roll
        }

        return $points;
    }


    /**
     * Check if player's current total score plus current round score is enough to win the game.
     * Note that this method does not update player's total score!
     * @return bool as a true or false evaluation of whether the current player has won the game.
     */
    private function currentPlayerWins()
    {
        $roundScore = $this->round->getScore();
        $playerScore = $this->round->getPlayer()->getScore();
        return (($playerScore + $roundScore) >= $this->targetScore);
    }


    /**
     * Start a new round with next player in turn.
     */
    private function newRound()
    {
        $currentPlayer = $this->round->getPlayer()->getName(); //get the name of the player playing the current round

        if ($currentPlayer === $this->player1->getName()) { //if the current player is player 1...
            $nextPlayer = $this->player2; //...make player 2 the next player
        } else {
            $nextPlayer = $this->player1; //...else make player 1 the next player
            $this->status .= " Your turn.";
        }

        $this->round = new Round($nextPlayer); //initiate a new round with the next player
    }
}
