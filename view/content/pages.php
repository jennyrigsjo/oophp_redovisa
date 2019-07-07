<?php
if (!$resultset) {
    return;
}
?>

<article>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h2><a href="page/<?= esc($row->path) ?>"><?= esc($row->title) ?></a></h2>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
</section>
<?php endforeach; ?>

</article>
