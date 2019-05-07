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

    <div class="dice100-console">
        <div class="dice100-forms">
            <form method="post" action="roll-dice" class="dice100-button">
                <input type="submit" name="rollDice" value="Roll dice" <?= $somebodyWon ? 'disabled' : ''?>>
            </form>

            <form method="post" action="save-score" class="dice100-button">
                <input type="submit" name="saveScore" value="Save score" <?= $somebodyWon || $currentRoundScore === 0 ? 'disabled' : ''?>>
            </form>
        </div>
        <div class="dice100-statistics">
            <h5>Last round dice histograms</h5>
            <div class="dice100-histograms">
                <div class="dice100-histogram">
                    <p class="histogram-header"><?= $player1 ?></p>
                    <p><?= $player1Histogram ?></p>
                </div>
                <div class="dice100-histogram">
                    <p class="histogram-header"><?= $player2 ?></p>
                    <p><?= $player2Histogram ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="dice100-result">

        <div class="dice100-player-status">

            <div class="dice100-player1-status">
                <h5> <?= $player1 ?></h5>
                <div>
                    <?php foreach ($player1LastRolls as $roll) : ?>
                        <p>
                        <?php foreach ($roll as $value) : ?>
                            <span class="dice-sprite <?= $value ?>"></span>
                        <?php endforeach; ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                <?php  foreach ($player1Status as $description) : ?>
                    <p><?= $description ?></p>
                <?php endforeach; ?>
            </div>

            <div class="dice100-player2-status">
                <h5> <?= $player2 ?></h5>
                <div>
                    <?php foreach ($player2LastRolls as $roll) : ?>
                        <p>
                        <?php foreach ($roll as $value) : ?>
                            <span class="dice-sprite <?= $value ?>"></span>
                        <?php endforeach; ?>
                        </p>
                    <?php endforeach; ?>
                </div>
                <?php  foreach ($player2Status as $description) : ?>
                    <p><?= $description ?></p>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

    <span class="dice100-status">
        <h5>Game status</h5>
        <table>
            <tr>
                <th>Player</th>
                <th>Player Total Score</th>
            </tr>
            <tr>
                <td><?= $player1 ?></td>
                <td class="score"><?= $player1score ?> / <?= $targetScore ?></td>
            </tr>
            <tr>
                <td><?= $player2 ?></td>
                <td class="score"><?= $player2score ?> / <?= $targetScore ?></td>
            </tr>
        </table>
        <?php if ($firstRound) : ?>
            <p>First round, player '<?= $currentPlayer ?>' starts.</p>
        <?php elseif ($somebodyWon) : ?>
            <p><?= $currentPlayer ?> won the game. <a href='end-session'>Play again?</a></p>
        <?php endif; ?>
    </span>
</div>
