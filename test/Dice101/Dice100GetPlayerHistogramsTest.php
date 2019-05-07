<?php
namespace Anri16\Dice101;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100GetPlayerHistograms extends TestCase
{
    /**
     * Roll the dice and get the histograms of the players.
     */
    public function testGetPlayerHistograms()
    {
        $game = new Dice100();

        //player 1 rolls first by default
        $game->rollDice();

        $histogramPlayer1 = $game->getPlayer1Histogram();
        $histogramPlayer2 = $game->getPlayer2Histogram();

        $this->assertIsString($histogramPlayer1);
        $this->assertIsString($histogramPlayer2);
    }
}
