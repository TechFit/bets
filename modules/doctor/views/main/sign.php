<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\modules\doctor\models\SignForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\datetime\DateTimePicker;
$this->title = 'Регистрация на прием';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login col-md-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Введите данные для регистрации на прием:</p>

    <?php
    $form = ActiveForm::begin([
        'id' => 'sign-form',
        'options' => ['class' => 'form-horizontal'],
    ]);
    ?>

    <?= $form->field($model, 'firstName')->label('Имя'); ?>

    <?= $form->field($model, 'lastName')->label('Фамилия'); ?>

    <?= $form->field($model, 'email')->label('Email'); ?>

    <?= $form->field($model, 'telephone')->label('Телефон'); ?>

    <?= $form->field($model, 'regDate')->widget(DateTimePicker::className(), [
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd hh:ii:00',
            'autoclose' => true,
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>