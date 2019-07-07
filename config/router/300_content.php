<?php
/**
 * Controller for My Content Database.
 */
return [
    "routes" => [
        [
            "info" => "My Content Database",
            "mount" => "content",
            "handler" => "\Anri16\Content\ContentController", //namespace + controller file name (file name must be same as controller class name)
        ]
    ]
];
