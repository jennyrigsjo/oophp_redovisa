<?php
namespace Anax\View;

/**
 * Search for an item from a certain year or time period.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<form class="movie-form" method="get" action="search-year">
    <fieldset>
    <legend>Search by year</legend>
    <p>
        <label>Created between:
        <input type="number" name="year1" value="<?= $year1 ?: 1900 ?>" min="1900" max="2100"/>
        -
        <input type="number" name="year2" value="<?= $year2  ?: 2100 ?>" min="1900" max="2100"/>
        </label>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>
