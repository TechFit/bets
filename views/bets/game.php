<?php

use app\models\Teams;
use yii\helpers\ArrayHelper,
    yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Матч';
?>
<div class="site-index">
    <div class="h3">
        Сделать прогноз:
    </div>
    <?php
    $form = ActiveForm::begin([
        'id' => 'bets-form',
        'options' => ['class' => 'form-horizontal'],
    ]);
    ?>

    <?= $form->field($model, 'homeTeamResult')->label('Счет хозяев'); ?>
    :
    <?= $form->field($model, 'guestTeamResult')->label('Счет Гостей'); ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>

