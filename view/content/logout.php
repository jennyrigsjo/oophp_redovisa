<form method="post" action="logout">
    <fieldset>
    <legend>Log out?</legend>

    <p>Currently logged in as user '<?= $user ?>'. Log out?</p>

    <p>
        <input type="submit" name="doLogout" value="Logout">
    </p>

    <p>
        <a href="show-all">Cancel</a>
    </p>
    </fieldset>
</form>
