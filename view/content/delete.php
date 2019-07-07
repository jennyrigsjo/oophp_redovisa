<form method="post" action="delete">
    <fieldset>
    <legend>Delete item?</legend>
    <input type="hidden" name="id" value="<?= esc($resultset->id) ?>"/>

    <p>
        <label>Title:<br>
            <input type="text" name="title" value="<?= esc($resultset->title) ?>" readonly/>
        </label>
    </p>

    <p>
        <input type="submit" name="doDelete" value="Delete">
    </p>

    <p>
        <a href="show-all">Cancel</a>
    </p>
    </fieldset>
</form>
