<?php
namespace Anax\View;

/**
 * Header and navbar.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<h1>My Movie Database</h1>

<navbar class="movie-navbar">
    <a href="<?=$baseUrl?>/movie">Show all movies</a> |
    <a href="<?=$baseUrl?>/movie/search-title">Search by title</a> |
    <a href="<?=$baseUrl?>/movie/search-year">Search by year</a> |
    <a href="<?=$baseUrl?>/movie/add">Add a movie</a> |
    <!-- <a href="<?=$baseUrl?>/movie/select">Edit or delete a movie</a> | -->
    <a href="<?=$baseUrl?>/movie/reset">Reset database</a>
</navbar>
