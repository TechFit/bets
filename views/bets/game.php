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
        'options' => ['class' => 'form-inline'],
    ]);
    ?>
    <div>
        <?= $form->field($model, 'homeTeamResult')->textInput()->label('Счет хозяев'); ?>
    </div>

    <div>
        <?= $form->field($model, 'guestTeamResult')->textInput()->label('Счет Гостей'); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>

