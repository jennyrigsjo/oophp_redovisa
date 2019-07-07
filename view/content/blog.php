<?php
if (!$resultset) {
    return;
}
?>

<article>

<?php foreach ($resultset as $row) : ?>
<section>
    <header>
        <h2><a href="blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h2>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= $row->data ?>
</section>
<?php endforeach; ?>

</article>
