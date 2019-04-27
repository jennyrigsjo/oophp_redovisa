<?php
namespace Anri16\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100PlayerWinsTest extends TestCase
{

    /**
     * Roll the dice until a player wins the game.
     */
    public function testPlayerWins()
    {
        $game = new Dice100();

        $player1Name = $game->getPlayer1Name();
        $player2Name = $game->getPlayer2Name();

        $player1Score = $game->getPlayerTotalScore($player1Name);
        $player2Score = $game->getPlayerTotalScore($player2Name);

        $targetScore = $game->getTargetScore();

        while ($player1Score < $targetScore && $player2Score < $targetScore) {
            $res = $game->rollDice();

            while (in_array("die-1", $res, true)) {
                $res = $game->rollDice();
            }

            $game->saveScore();

            $player1Score = $game->getPlayerTotalScore($player1Name);
            $player2Score = $game->getPlayerTotalScore($player2Name);
        }

        $highestScore = max($player1Score, $player2Score);

        $this->assertGreaterThanOrEqual($targetScore, $highestScore);
    }
}
