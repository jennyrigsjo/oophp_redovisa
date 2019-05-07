<?php
namespace Anri16\Dice101;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100GetPlayerStatuses extends TestCase
{
    /**
     * Roll the dice and get the status of the players.
     */
    public function testGetPlayerStatuses()
    {
        $game = new Dice100();

        //player 1 rolls first by default
        $game->rollDice();

        $statusPlayer1 = $game->getPlayer1Status();
        $statusPlayer2 = $game->getPlayer2Status();

        $this->assertIsArray($statusPlayer1);

        $this->assertIsArray($statusPlayer2);

        $this->assertIsString($statusPlayer1[0]);
    }
}
