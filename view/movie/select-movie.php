<?php
namespace Anax\View;

/**
 * Select a movie to edit or delete.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<form method="post" action="select">
    <fieldset>
    <legend>Edit or delete a movie</legend>
    <p>
        <label>Movie:<br>
            <select name="movieId">
                <option value="">Select movie...</option>
                <?php foreach ($resultset as $movie) : ?>
                <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <input type="submit" name="doCRUD" value="Edit">
        <input type="submit" name="doCRUD" value="Delete">
    </p>
    </fieldset>
</form>
