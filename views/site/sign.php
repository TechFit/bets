<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login col-md-5">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Введите данные для регистрации:</p>

    <?php
    $form = ActiveForm::begin([
        'id' => 'sign-form',
        'options' => ['class' => 'form-horizontal'],
    ]);
    ?>

    <?= $form->field($model, 'name')->label('Имя'); ?>

    <?= $form->field($model, 'email')->label('Email'); ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Пароль'); ?>

    <?= $form->field($model, 'repeat_password')->passwordInput()->label('Повторите пароль'); ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>