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
        <?php foreach ($model->getAvailableMatches() as $match) { ?>
        <tr>
            <td><?= Teams::getTeamTitle($match['home_team_id']) ?></td>
            <td><?= Teams::getTeamTitle($match['guest_team_id']) ?></td>
            <td><?= $match['start_time'] ?></td>
            <td><?= $match['home_team_result'] . ':' . $match['guest_team_result'] ?></td>
            <td><?= Teams::getTeamTitle($match['won_team_id']) ?></td>
            <td>
                <?php echo empty(Teams::getTeamTitle($match['won_team_id'])) ? Html::a("Указать счет", "") : 'Завершена' ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

