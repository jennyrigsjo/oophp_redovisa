<?php
/**
 * This file contains code to implement the class DiceHand.
 * @author Jenny Rigsjö (anri16)
 * @version 1.0.0
 */

namespace Anri16\Dice100;

/**
 * A supporting class for the game 'Dice 100'.
 */
class DiceHand
{
    /**
     * @var DieGraphic $dice    Array of dice (die objects).
     */
    private $dice = null;

    /**
     * @var integer $values     Array of values from the last time the dice were rolled.
     */
    private $values = null;

    /**
     * Constructor to initiate the dicehand with a given number of dice.
     *
     * @param integer $dice The number of dice to create, defaults to 4.
     */
    public function __construct(int $dice = 4)
    {
        $this->dice = [];
        $this->values = [];

        for ($i = 0; $i < $dice; $i++) {
            $die = new DieGraphic();
            array_push($this->dice, $die);
        }
    }

    /**
     * Roll the dice and save their values.
     *
     * @return void.
     */
    public function roll()
    {
        $this->values = [];
        foreach ($this->dice as $die) {
            $die->roll();
            $value = $die->getLastRoll();
            array_push($this->values, $value);
        }
    }

    /**
     * Get the values from the last time the dice were rolled.
     *
     * @return array with the values (integers) from the last roll.
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Get the sum of the values from the last time the dice were rolled.
     *
     * @return int as the sum of all dice values.
     */
    public function sumValues()
    {
        return array_sum($this->values);
    }

    /**
     * Get graphic representations of the values from the last time the dice were rolled.
     *
     * @return array as a list of class names representing the graphic versions of the values.
     */
    public function getGraphics()
    {
        $classNames = [];
        foreach ($this->dice as $die) {
            $className = $die->graphic();
            array_push($classNames, $className);
        }
        return $classNames;
    }
}
