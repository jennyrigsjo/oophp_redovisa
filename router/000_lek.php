<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Showing message Hello World, not using the standard page layout.
 */
$app->router->get("lek/hello-world", function () use ($app) {
    // echo "Some debugging information";
    return "Hello World";
});



/**
 * Returning a JSON message with Hello World.
 */
$app->router->get("lek/hello-world-json", function () use ($app) {
    // echo "Some debugging information";
    return [["message" => "Hello World"]];
});



/**
* Showing message Hello World, rendered within the standard page layout.
 */
$app->router->get("lek/hello-world-page", function () use ($app) {
    $title = "Hello World as a page";
    $data = [
        "class" => "hello-world",
        "content" => "Hello World in " . __FILE__,
    ];

    $app->page->add("anax/v2/article/default", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Showing a test page with a link to the dbwebb youtube channel, rendered within the standard page layout.
 */
$app->router->get("lek/test-page", function () use ($app) {
    $title = "Testsida";
    $data = [
        "class" => "test-page",
        "content" => "Test page in " . __FILE__ . "<br><br>Japp, det verkar fungera. :)<br><br>Här kommer en länk till <a href='https://www.youtube.com/channel/UCxX3bcidovf5MDLeXMcbDyg?&ab_channel=dbwebb'>dbwebbs officiella youtubekanal</a>.",
    ];

    $app->page->add("anax/v2/article/default", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
