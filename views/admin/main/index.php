<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Admin';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <ul>
        <li>
            <a href="admin/matches/index">Матчи</a>
        </li>
        <li>
            <a href="admin/tournament/index">Турниры</a>
        </li>
        <li>
            <a href="admin/teams/index">Команды</a>
        </li>
    </ul>


</div>
