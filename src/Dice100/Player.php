<?php
/**
 * This file contains code to implement the class Player.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice100;

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
     * Constructor to initiate the object with current settings.
     *
     * @param string $name The name of the player.
     *
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->score = 0;
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
     * @param int $points The points to be added to the player's total score
     *
     */
    public function addToScore($points)
    {
        $this->score += $points;
    }
}
