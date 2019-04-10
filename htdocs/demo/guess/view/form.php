<h1>Guess my number</h1>

<p>Guess a number between 1 and 100. You have <?= $tries ?> tries left.</p>

<form method="post">
    <input type="number" name="guess" value="<?= $guess ?>">
    <input type="submit" name="makeGuess" value="Make guess" <?= $tries <= 0 || $guess == $number ? 'disabled' : '' ?>>
    <input type="submit" name="cheat" value="Cheat">
</form>

<form method="post" action="session_destroy.php">
    <input type="submit" name="initGame" value="Start over">
</form>

<?php if ($exception) : ?>
    <p><?= $exception ?></p>
<?php elseif ($makeGuess) : ?>
    <p><?= $result ?></p>
<?php elseif ($cheat) : ?>
    <p>Psst! The current number is <?= $number ?>.</p>
<?php endif; ?>

<!--
<pre><?= var_dump($number) ?></pre>
<pre><?= var_dump($_POST) ?></pre>
