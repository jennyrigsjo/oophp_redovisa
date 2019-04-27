<?php

namespace Anax\View;

/**
 * Print debug information.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<hr>
    <pre>
        SESSION
        <?= var_dump($_SESSION) ?>
        GET
        <?= var_dump($_GET) ?>
        POST
        <?= var_dump($_POST) ?>
    </pre>
<hr>
