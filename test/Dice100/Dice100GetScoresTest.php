<?php
namespace Anri16\Dice100;

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

        $res = $game->getTargetScore();
        $this->assertIsInt($res);
    }

    /**
     * Get the current total score of each player and check that they are integers.
     */
    public function testGetPlayerTotalScores()
    {
        $game = new Dice100();

        $player1 = $game->getPlayer1Name();
        $playerTotalScore = $game->getPlayerTotalScore($player1);
        $this->assertIsInt($playerTotalScore);

        //superfluous? testing for one player is enough?
        $player2 = $game->getPlayer2Name();
        $playerTotalScore = $game->getPlayerTotalScore($player2);
        $this->assertIsInt($playerTotalScore);
    }
}
