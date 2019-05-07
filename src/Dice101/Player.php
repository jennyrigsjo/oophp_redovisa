<?php
/**
 * This file contains code to implement the class Player.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice101;

/**
 * A supporting class for the game 'Dice 100'.
 */
class Player
{
    /**
     * @var string $name    The name of the player.
     */
    private $name = null;

    /**
     * @var int $score    The player's total score.
     */
    private $score = null;

    /**
     * @var string $status    Array of textual descriptions of the player's moves in the last round.
     */
    private $status = null;

    /**
     * @var string $lastRolls    Array containing lists of values from the player's rolls in the last round.
     */
    private $lastRolls = null;

    /**
     * @var string $diceHistogram    A histogram of the frequency of the values rolled in the last round.
     */
    private $diceHistogram = null;

    /**
     * Constructor to initiate the object with current settings.
     *
     * @param string $name The name of the player.
     *
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->score = 0;
        $this->status = [];
        $this->lastRolls = [];
        $this->diceHistogram = "";
    }

    /**
     * Get the name of the player.
     *
     * @return string as the name of the player.
     *
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the player's current total score.
     *
     * @return int as the current total score of the player.
     *
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Add points to the player's total score.
     *
     * @param int $points The points to be added to the player's total score.
     * @return void
     */
    public function addToScore($points)
    {
        $this->score += $points;
    }

    /**
     * Add a description of the player's latest moves.
     * @param string $status Textual description of the player's latest move.
     * If null is passed as an argument, the current list of descriptions is reset/emptied.
     * @return void
     */
    public function setStatus($status)
    {
        if ($status === null) {
            $this->status = [];
        } else {
            array_push($this->status, $status);
        }
    }

    /**
     * Get a description of the player's moves in the latest round.
     * @return array A list of textual descriptions of the player's moves.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Save the values from the last time the player rolled the dice.
     * @param array $values The values from the last roll.
     * @return void
     */
    public function setLastRolls($values)
    {
        if (empty($values)) {
            $this->lastRolls = [];
        } else {
            array_push($this->lastRolls, $values);
        }
    }

    /**
     * Get the values from the rolls of the last round.
     * @return array A list of arrays containing the values from the last rolls.
     */
    public function getLastRolls()
    {
        return $this->lastRolls;
    }

    /**
     * Save the dice histogram from the latest round.
     * @param string $histogram The histogram from the latest round.
     * @return void
     */
    public function setDiceHistogram($histogram)
    {
        $this->diceHistogram = $histogram;
    }

    /**
     * Get the dice histogram from the latest round.
     * @return string $histogram The histogram from the latest round.
     */
    public function getDiceHistogram()
    {
        return $this->diceHistogram;
    }
}
