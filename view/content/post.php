<article>
    <header>
        <h1><?= esc($resultset->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($resultset->modified_iso8601) ?>" pubdate><?= esc($resultset->modified) ?></time></i></p>
    </header>
    <?= $resultset->data ?>
</article>
