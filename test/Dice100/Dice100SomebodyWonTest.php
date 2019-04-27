<?php
namespace Anri16\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100SomebodyWonTest extends TestCase
{
    /**
     * Test if a player has won the game.
     */
    public function testSomebodyWon()
    {
        $game = new Dice100();

        $res = $game->somebodyWon();
        $exp = false;
        $this->assertEquals($exp, $res);
    }
}
