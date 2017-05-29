<?php

use app\models\Teams;
use yii\helpers\ArrayHelper,
    yii\bootstrap\Html;

/* @var $this yii\web\View */

$this->title = 'Bets';
?>
<div class="site-index">
    <div class="h3">
        Расписание игр:
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Хозяин</th>
            <th>Гости</th>
            <th>Начало матча</th>
            <th>Результат</th>
            <th>Победитель</th>
            <th>Ваш прогноз</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listOfMatches as $match) { ?>
        <tr>
            <td><?= $match['homeTeam'] ?></td>
            <td><?= $match['guestTeam'] ?></td>
            <td><?= $match['matchTime'] ?></td>
            <td><?= $match['matchResult'] ?></td>
            <td><?= $match['winner'] ?></td>
            <td><?= $match['tag'] ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

