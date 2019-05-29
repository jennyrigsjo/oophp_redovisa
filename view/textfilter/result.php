<?php

namespace Anax\View;

/**
 * Show game interfce, inluding form/input elements and game status.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<h1>MyTextFilter Demo</h1>

<p>
<navbar class="navbar">
    <a href="init" title="Unparsed text">Original text</a> |
    <a href="bbcode" title="Convert BBCode to HTML">BBCode</a> |
    <a href="link" title="Make links clickable">Link</a> |
    <a href="markdown" title="Convert Markdown to HTML">Markdown</a> |
    <a href="nl2br" title="Convert newlines to HTML linebreaks">nl2br</a> |
    <a href="esc" title="Convert special characters to HTML entities">Esc</a> |
    <a href="strip" title="Remove all HTML tags from the text">Strip</a> |
    <a href="multiple" title="BBCode, Link, Markdown">Multiple filters</a>
</navbar>
</p>

<p>Click one of the links in the navbar to try out the different text filters available in the class MyTextFilter.
The result of applying the filter (the parsed text) is shown below.</p>

<div class="textfilter-demo"><?= $text ?></div>
