<?php
namespace Anri16\Dice101;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100RollDiceAndSaveScore extends TestCase
{
    /**
     * Roll the dice and save the score
     */
    public function testRollDiceAndSaveScore()
    {
        $game = new Dice100();

        //player 1 rolls first by default
        $game->rollDice();
        $roundScore = $game->getCurrentRoundScore();

        while ($roundScore === 0) {
            $game->rollDice();
            $roundScore = $game->getCurrentRoundScore();
        }

        $this->assertGreaterThanOrEqual(8, $roundScore);

        $game->saveScore();
    }
}
