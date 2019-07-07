<h1>My Content Database</h1>

<p>
    <navbar class="navbar">
        <a href="show-all">Show all content</a> |
        <?php if (isset($user)) : ?>
            <a href="create">Add new content</a> |
        <?php endif; ?>
        <a href="blog">View blog</a> |
        <a href="page">Show all pages</a> |
        <a href="reset">Reset database</a>
    </navbar>
    <span class="cms-login">
        <?php if (isset($user)) : ?>
            <a href="logout" title="logged in as '<?= $user ?>'">Logout</a>
        <?php else : ?>
            <a href="login">Login</a>
        <?php endif; ?>
    </span>
</p>
