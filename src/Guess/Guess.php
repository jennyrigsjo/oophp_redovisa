<?php

namespace Anri16\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int $number   The current secret number.
     * @var int $tries    Number of times a guess can be made.
     */
    private $number = null;
    private $tries = null;


    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to generate
     *                    a random number.
     * @param int $tries  Number of times a guess can be made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        if ($number === -1) {
            $this->randomNumber();
        } else {
            $this->number = $number;
        }

        $this->tries = $tries;
    }


    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    private function randomNumber()
    {
        $this->number = mt_rand(1, 100);
    }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function getTries()
    {
        return $this->tries;
    }



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function getNumber()
    {
        return $this->number;
    }



    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     *
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($number)
    {
        if ($number < 1 || $number > 100) {
            throw new GuessException("Guess must be a number between 1 and 100!");
        }

        $result = null;

        if ($this->tries > 0) {
            if ($number == $this->number) {
                $result = "CORRECT!";
            } elseif ($number > $this->number) {
                $result = "TOO HIGH.";
            } elseif ($number < $this->number) {
                $result = "TOO LOW.";
            }
        }

        $this->tries = ($this->tries > 0) ? $this->tries - 1 : 0;

        if ($this->tries == 0) {
            $result .= " You have no guesses left.";
        }

        return $result;
    }
}
