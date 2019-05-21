<?php
namespace Anax\View;

/**
 * Show all items (Default/start page).
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if (empty($resultset)) {
    return;
}
?>

<table class="movie-table">
    <tr class="first">
        <th>Row</th>
        <th>Id</th>
        <th>Image</th>
        <th>Title</th>
        <th>Year</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?=$baseUrl?>/<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <td><a href="<?=$baseUrl?>/movie/update?id=<?= $row->id ?>" title="Edit"><i class="fas fa-edit"></i></a></td>
        <td><a href="<?=$baseUrl?>/movie/delete?id=<?= $row->id ?>" title="Delete"><i class="fas fa-trash-alt"></i></a></td>
    </tr>
<?php endforeach; ?>
</table>
