<?php
namespace Anax\View;

/**
 * Edit a movie.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<form method="post" action="add">
    <fieldset>
    <legend>Add a movie</legend>
    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="" placeholder="Movie title"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="" placeholder="e.g. 2019"/>
        </label>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="" placeholder="img/movie/myimage.jpg"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doAdd" value="Add">
    </p>
    </fieldset>
</form>
