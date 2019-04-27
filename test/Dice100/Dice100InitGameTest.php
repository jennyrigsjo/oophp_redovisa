<?php
namespace Anri16\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice100.
 */
class Dice100InitGameTest extends TestCase
{
    /**
     * Construct object using no arguments.
     */
    public function testInitGameNoArguments()
    {
        $game = new Dice100();
        $this->assertInstanceOf("\Anri16\Dice100\Dice100", $game);
    }

    /**
     * Construct object using one argument.
     */
    public function testInitGameOneArgument()
    {
        $game = new Dice100("Jenny");
        $this->assertInstanceOf("\Anri16\Dice100\Dice100", $game);
    }

    /**
     * Construct object using two arguments.
     */
    public function testInitGameTwoArguments()
    {
        $game = new Dice100("Jenny", "Aron");
        $this->assertInstanceOf("\Anri16\Dice100\Dice100", $game);
    }

    /**
     * Construct object using all (three) arguments.
     */
    public function testInitGameAllArguments()
    {
        $game = new Dice100("Jenny", "Aron", true);
        $this->assertInstanceOf("\Anri16\Dice100\Dice100", $game);
    }
}
