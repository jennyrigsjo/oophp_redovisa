<?php if (isset($reset)) : ?>
    <div class="cms-reset"> <?= $reset ?> </div>
<?php elseif (isset($exception)) : ?>
    <p class="cms-error"> <?= $exception ?> </p>
<?php elseif (isset($error)) : ?>
    <p class="cms-error"> <?= $error ?> </p>
<?php elseif (isset($okMessage)) : ?>
    <p class="cms-ok"> <?= $okMessage ?> </p>
<?php endif; ?>
