<?php
if (!$resultset) {
    return;
}
?>

<p>Items per page: <?=paginate("show-all", 2, $hits)?> | <?=paginate("show-all", 4, $hits)?> | <?=paginate("show-all", 8, $hits)?></p>

<table class="cms-table">
    <tr class="first">
        <th>Id <?= orderby("id", "show-all")?></th>
        <th>Title <?= orderby("title", "show-all")?></th>
        <th>Type <?= orderby("type", "show-all")?></th>
        <th>Path</th>
        <th>Slug</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <?php if (isset($user)) : ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($resultset as $row) :
        $path = $row->path;
        $slug = $row->slug;
        $href = ($row->type === "page") ? "page/$path" : "blog/$slug";
        ?>
    <tr class="cms-row">
        <td><?= esc($row->id) ?></td>
        <td><a href="<?= $href ?>"><?= esc($row->title) ?></a></td>
        <td><?= esc($row->type) ?></td>
        <td><?= esc($row->path) ?></td>
        <td><?= esc($row->slug) ?></td>
        <td><?= esc($row->published) ?></td>
        <td><?= esc($row->created) ?></td>
        <td><?= esc($row->updated) ?></td>
        <td><?= esc($row->deleted) ?></td>
        <?php if (isset($user)) : ?>
            <td>
                <a href="edit?id=<?=$row->id?>" title="edit"><i class="fas fa-edit"></i></a>
                <a href="delete?id=<?=$row->id?>" title="delete"><i class="fas fa-trash"></i></a>
                <a href="restore?id=<?=$row->id?>" title="restore">Restore</a>
            </td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>

<p>Pages:
    <?php for ($i = 1; $i < $pages + 1; $i++) { ?>
        <?= page("show-all", $hits, $i, $page); ?>
    <?php } ?>
</p>
