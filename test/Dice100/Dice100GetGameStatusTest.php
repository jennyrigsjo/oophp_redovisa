<?php
namespace Anri16\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100GetGameStatusTest extends TestCase
{
    /**
     * Get a textual description of the current status of the game.
     */
    public function testGetGameStatus()
    {
        $game = new Dice100();

        $res = $game->getGameStatus();
        $exp = "";
        $this->assertEquals($exp, $res);
    }
}
