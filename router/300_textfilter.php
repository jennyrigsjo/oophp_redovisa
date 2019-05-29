<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Reset session variables and initialize the MyTextFilter class.
 */
$app->router->get("textfilter/init", function () use ($app) {
    $_SESSION["textfilter"] = null;
    $_SESSION["text"] = null;
    $_SESSION["textfilter"] = new Anri16\MyTextFilter\MyTextFilter();
    return $app->response->redirect("textfilter/result");
});

/**
 * Show the parsed text.
 */
$app->router->get("textfilter/result", function () use ($app) {
    $title = "MyTextFilter Demo";

    $textfilter = $_SESSION["textfilter"];

    $text = $_SESSION["text"] ?? $textfilter->exampleText();
    $_SESSION["text"] = null;

    $data = [
        "text" => $text,
    ];

    $app->page->add("textfilter/result", $data);
    //$app->page->add("textfilter/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Parse the text using the 'bbcode' filter.
 */
$app->router->get("textfilter/bbcode", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "bbcode");
    return $app->response->redirect("textfilter/result");
});

/**
 * Parse the text using the 'link' filter.
 */
$app->router->get("textfilter/link", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "link");
    return $app->response->redirect("textfilter/result");
});

/**
 * Parse the text using the 'markdown' filter.
 */
$app->router->get("textfilter/markdown", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "markdown");
    return $app->response->redirect("textfilter/result");
});

/**
 * Parse the text using the 'nl2br' filter.
 */
$app->router->get("textfilter/nl2br", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "nl2br");
    return $app->response->redirect("textfilter/result");
});

/**
 * Parse the text using the 'esc' filter.
 */
$app->router->get("textfilter/esc", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "esc,nl2br");
    return $app->response->redirect("textfilter/result");
});

/**
 * Parse the text using the 'strip' filter.
 */
$app->router->get("textfilter/strip", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "strip,nl2br");
    return $app->response->redirect("textfilter/result");
});

/**
 * Parse the text using multiple filters.
 */
$app->router->get("textfilter/multiple", function () use ($app) {
    $textfilter = $_SESSION["textfilter"];
    $text = $textfilter->exampleText();
    $_SESSION["text"] = $textfilter->parse($text, "bbcode,link,markdown");
    return $app->response->redirect("textfilter/result");
});
