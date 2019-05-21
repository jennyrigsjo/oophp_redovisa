<?php
namespace Anax\View;

/**
 * Edit a movie.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<form method="post" action="save">
    <fieldset>
    <legend>Edit movie</legend>
    <input type="hidden" name="movieId" value="<?= $resultset->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $resultset->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $resultset->year ?>"/>
        </label>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $resultset->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
    </p>
    </fieldset>
</form>
