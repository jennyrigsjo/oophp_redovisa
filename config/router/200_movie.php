<?php
/**
 * Controller for My Movie Database.
 */
return [
    "routes" => [
        [
            "info" => "My Movie Database",
            "mount" => "movie",
            "handler" => "\Anri16\Movie\MovieController", //namespace + controller file name (file name must be same as controller class name)
        ]
    ]
];
