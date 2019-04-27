<?php
namespace Anri16\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100RollDiceTest extends TestCase
{
    /**
     * Roll the dice and check that an array of strings is returned.
     */
    public function testRollDice()
    {
        $game = new Dice100();

        $res = $game->rollDice();
        $this->assertIsArray($res);

        $str = $res[0];
        $this->assertIsString($str);
    }

    /**
     * Roll (at least one) die with the value 1 and start a new round.
     */
    public function testRollValue1()
    {
        $game = new Dice100();

        $res = $game->rollDice();

        while (!in_array("die-1", $res, true)) {
            $res = $game->rollDice();
        }

        $this->assertContains("die-1", $res);

        $game->saveScore();
    }

    /**
     * Score points by not rolling a die with the value 1 and save the score to player's total score.
     */
    public function testDoNotRollValue1()
    {
        $game = new Dice100();

        $res = $game->rollDice();

        while (in_array("die-1", $res, true)) {
            $res = $game->rollDice();
        }

        $this->assertNotContains("die-1", $res);

        $game->saveScore();
    }
}
