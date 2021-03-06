<?php
/**
 * This file contains code to implement the class Round.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice101;

/**
 * A supporting class for the game 'Dice 100'.
 */
class Round
{
    /**
     * @var Player $player   The player playing the round.
     */
    private $player = null;

    /**
     * @var DiceHand $diceHand   The dice used in the round.
     */
    private $diceHand = null;

    /**
     * @var int $score   The player's current score in the round.
     */
    private $score = null;

    /**
     * Constructor to initiate the object with current settings.
     *
     * @param Player $player The player of the round.
     *
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
        $emptyArray = [];
        $this->player->setLastRolls($emptyArray);
        $this->player->setStatus(null);
        $this->diceHand = new DiceHand();
        $this->score = 0;
    }

    /**
     * Get the player playing the round.
     *
     * @return Player as the player of the round.
     *
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Get the dice used in the round.
     *
     * @return DiceHand as the dice used in the round.
     *
     */
    public function getDice()
    {
        return $this->diceHand;
    }

    // /**
    //  * Get the values from each roll in the current round.
    //  *
    //  * @return array An array with a list of values for each roll.
    //  */
    // public function getDiceSeries()
    // {
    //     $histogram = new DiceHandHistogram();
    //     $histogram->injectData($this->diceHand);
    //     return $histogram->getSeries();
    // }

    /**
     * Get a graphic representation of the number of instances of each value rolled by the dice hand.
     *
     * @return string as a histogram of the number of instances of each value.
     */
    public function getDiceHistogram()
    {
        $histogram = new DiceHandHistogram();
        $histogram->injectData($this->diceHand);
        return $histogram->getHistogramString();
    }

    /**
     * Get the player's current score in the round.
     *
     * @return int as the current round score of the player.
     *
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Add points earned from the last roll to the current round score.
     *
     * @param int $points The points to be added to the current round score.
     *
     */
    public function addToScore($points)
    {
        $this->score += $points;
    }

    /**
     * Add current round score to current player's total score.
     */
    public function saveScore()
    {
        $this->player->addToScore($this->score);
    }
}
