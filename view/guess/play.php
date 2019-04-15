<?php

namespace Anax\View;

/**
 * Show game interfce, inluding form/input elements and game status.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<h1>Guess my number</h1>

<p>Guess a number between 1 and 100. You have <?= $tries ?> tries left.</p>

<form method="post" action="make-guess" class="guess-button">
    <input type="number" name="guess" value="<?= $guess ?>">
    <input type="submit" name="makeGuess" value="Make guess" <?= $tries <= 0 || strpos($result, 'CORRECT!') !== false ? 'disabled' : '' ?>>
</form>

<form method="post" action="cheat" class="guess-button">
    <input type="submit" name="cheat" value="Cheat">
</form>

<form method="post" action="end-session" class="guess-button">
    <input type="submit" name="endSession" value="Start over">
</form>

<?php if ($exception) : ?>
    <p><?= $exception ?></p>
<?php elseif ($makeGuess) : ?>
    <p><?= $result ?></p>
<?php elseif ($cheat) : ?>
    <p>Psst! The current number is <?= $number ?>.</p>
<?php endif; ?>
