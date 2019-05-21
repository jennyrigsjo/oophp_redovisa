<?php
namespace Anax\View;

/**
 * Search for an item with a particular title.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<form class="movie-form" method="post" action="search-title">
    <fieldset>
    <legend>Search by title</legend>
    <p>
        <label for="search-title">Title (use % as wildcard):</label>
        <input id="search-title" type="search" name="searchTitle" value="<?= esc($searchTitle) ?>">
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>
