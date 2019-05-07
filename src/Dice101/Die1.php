<?php
/**
 * This file contains code to implement the class Die1.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice101;

/**
 * A supporting class for the game 'Dice 100'.
 */
class Die1
{
    /**
    * @var integer $sides    The number of sides (faces) of the die
    */
    private $sides = null;

    /**
    * @var integer $lastRoll    The value generated the last time the die was rolled
    */
    private $lastRoll = null;


    /**
     * Constructor to initiate a single die.
     */
    public function __construct()
    {
        $this->lastRoll = 0;
        $this->sides = 6;
    }


    /**
     * Get the number of sides (faces) of the die.
     *
     * @return int as the number of sides.
     */
    public function getSides()
    {
        return $this->sides;
    }


    /**
    * Roll the die to generate a random value between 1 and 6.
    * @return void.
    */
    public function roll()
    {
        $this->lastRoll = mt_rand(1, 6);
    }


    /**
     * Get the value from the last time the die was rolled.
     *
     * @return int as the value of the last roll.
     * A return value of 0 means that die has not yet been rolled.
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
