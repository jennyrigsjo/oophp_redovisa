<?php
/**
 * Controller for the game Dice 100.
 */
return [
    "routes" => [
        [
            "info" => "Dice 100 controller",
            "mount" => "dice101",
            "handler" => "\Anri16\Dice101\Dice100Controller", //namespace + controller file name (file name must be same as controller class name)
        ]
    ]
];
