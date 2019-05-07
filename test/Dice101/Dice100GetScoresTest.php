<?php
namespace Anri16\Dice101;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100GetScoresTest extends TestCase
{
    /**
     * Get the current round score and check that it is an integer.
     */
    public function testGetCurrentRoundScore()
    {
        $game = new Dice100();

        $res = $game->getCurrentRoundScore();
        $this->assertIsInt($res);
    }

    /**
     * Get the target score of the game and check that it is an integer.
     */
    public function testGetTargetScore()
    {
        $game = new Dice100();
        $exp = 100;
        $res = $game->getTargetScore();
        $this->assertEquals($exp, $res);
    }

    /**
     * Get the current total score of player 1.
     */
    public function testGetPlayer1TotalScore()
    {
        $game = new Dice100();

        $player1TotalScore = $game->getPlayer1TotalScore();
        $this->assertIsInt($player1TotalScore);
    }

    /**
     * Get the current total score of player 2.
     */
    public function testGetPlayer2TotalScore()
    {
        $game = new Dice100();

        $player2TotalScore = $game->getPlayer2TotalScore();
        $this->assertIsInt($player2TotalScore);
    }
}
