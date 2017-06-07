<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'My Yii Application';

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'firstname',
        'lastname',
        'email',
        'telephone',
        'reg_date',
        [
            'attribute' => 'relevant',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->relevant == 1 ? Html::a('set not relevant', 'admin/relevant?id=' . $data->id) : 'No';
            },
            'format' => 'raw'
        ],
    ],
]);

?>
