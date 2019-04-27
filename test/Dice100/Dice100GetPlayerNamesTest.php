<?php
namespace Anri16\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100GetPlayerNamesTest extends TestCase
{
    /**
     * Get the name of player 1.
     */
    public function testGetPlayer1Name()
    {
        $game = new Dice100();

        $res = $game->getPlayer1Name();
        $exp = "You";
        $this->assertEquals($exp, $res);
    }

    /**
     * Get the name of player 2.
     */
    public function testGetPlayer2Name()
    {
        $game = new Dice100();

        $res = $game->getPlayer2Name();
        $exp = "Computer";
        $this->assertEquals($exp, $res);
    }

    /**
     * Get the name of the current player and check that it is a string.
     */
    public function testGetCurrentPlayerName()
    {
        $game = new Dice100();
        $currentPlayerName = $game->getCurrentPlayerName();
        $this->assertIsString($currentPlayerName);
    }
}
