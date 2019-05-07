<?php
namespace Anri16\Dice101;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100SomebodyWon extends TestCase
{
    /**
     * Test that nobody has won the game.
     */
    public function testNobodyHasWonYet()
    {
        $game = new Dice100();

        $somebodyWon = $game->somebodyWon();
        $this->assertEquals(false, $somebodyWon);
    }

    /**
     * Roll the dice until someboy wins.
     */
    public function testSomebodyWins()
    {
        $game = new Dice100();
        $somebodyWon = $game->somebodyWon();

        while (!$somebodyWon) {
            $roundScore = $game->getCurrentRoundScore();
            while ($roundScore === 0) {
                $game->rollDice();
                $roundScore = $game->getCurrentRoundScore();
            }
            $game->saveScore();
            $somebodyWon = $game->somebodyWon();
        }

        $this->assertEquals(true, $somebodyWon);
    }
}
