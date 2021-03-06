<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Matches */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="matches-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'home_team_id')->dropDownList($teams); ?>

    <?= $form->field($model, 'guest_team_id')->dropDownList($teams); ?>

    <?= $form->field($model, 'start_time')->widget(DateTimePicker::className(), [
        'pluginOptions' => [
                'format' => 'yyyy-mm-dd hh:ii:00',
                'autoclose' => true,
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

