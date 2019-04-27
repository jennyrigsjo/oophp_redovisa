<?php

namespace Anax\View;

/**
 * Show game interfce, inluding form/input elements and game status.
 */

//Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());
?>

<h1>Dice 100</h1>

<div class="dice100">
    <div class="dice100-forms">
        <form method="post" action="roll-dice" class="guess-button">
            <input type="submit" name="rollDice" value="Roll dice" <?= $somebodyWon ? 'disabled' : ''?>>
        </form>

        <form method="post" action="save-score" class="guess-button">
            <input type="submit" name="saveScore" value="Save score" <?= $somebodyWon || $currentRoundScore === 0 ? 'disabled' : ''?>>
        </form>
    </div>

    <div class="dice100-result">
        <?php if ($firstRound) : ?>
            <p>First round, player '<?= $currentPlayer ?>' starts:</p>
        <?php endif; ?>

        <p><?= $gameStatus ?></p>

        <?php if ($dice) : ?>
            <p>Your last roll:</p>
            <p>
            <?php foreach ($dice as $value) : ?>
                <span class="dice-sprite <?= $value ?>"></span>
            <?php endforeach; ?>
            </p>
        <?php endif; ?>

    </div>

    <span class="dice100-status">
        <p><b>Target score: <?= $targetScore ?></b></p>
        <p><b>Current round score: <?= $currentRoundScore ?></b></p>
        <table>
            <tr>
                <th>Player</th>
                <th>Player Total Score</th>
            </tr>
            <tr>
                <td><?= $player1 ?></td>
                <td class="score"><?= $player1score ?></td>
            </tr>
            <tr>
                <td><?= $player2 ?></td>
                <td class="score"><?= $player2score ?></td>
            </tr>
        </table>
    </span>
</div>
