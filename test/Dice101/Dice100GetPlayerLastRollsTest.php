<?php
namespace Anri16\Dice101;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100GetPlayerLastRolls extends TestCase
{
    /**
     * Roll the dice and get the last roll(s) of the players.
     */
    public function testGetPlayerLastRolls()
    {
        $game = new Dice100();

        //player 1 rolls first by default
        $game->rollDice();

        $lastRollsPlayer1 = $game->getPlayer1LastRolls();
        $lastRollsPlayer2 = $game->getPlayer2LastRolls();

        $this->assertIsArray($lastRollsPlayer1);

        $this->assertIsArray($lastRollsPlayer2);

        $this->assertIsArray($lastRollsPlayer1[0]);

        $this->assertIsString($lastRollsPlayer1[0][0]);
    }
}
