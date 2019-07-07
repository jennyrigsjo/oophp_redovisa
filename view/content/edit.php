<form method="post" action="edit">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="id" value="<?= esc($resultset->id) ?>"/>

    <p>
        <label>Title:<br>
            <input type="text" name="title" value="<?= esc($resultset->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
            <input type="text" name="path" value="<?= esc($resultset->path) ?>"/>
        </label>
    </p>

    <p>
        <label>Slug:<br>
            <input type="text" name="slug" value="<?= esc($resultset->slug) ?>"/>
        </label>
    </p>

    <p>
        <label>Text:<br>
            <textarea rows="10" cols="50" name="data">
                <?= esc($resultset->data) ?>
            </textarea>
        </label>
    </p>

    <p>
        <label>Type:<br>
            <input type="text" name="type" value="<?= esc($resultset->type) ?>"/>
        </label>
    </p>

    <p>
        <label>Filter:<br>
            <input type="text" name="filter" value="<?= esc($resultset->filter) ?>"/>
        </label>
    </p>

    <p>
        <label>Published:<br>
            <input type="text" name="published" value="<?= esc($resultset->published) ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
    </p>
    </fieldset>
</form>
