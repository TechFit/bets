<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Teams;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MatchesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Matches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="matches-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Matches', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Home team',
                'value' => function($data){
                    return Teams::getTeamTitle($data->home_team_id);
                }
            ],
            [
                'label' => 'Guest team',
                'value' => function($data){
                    return Teams::getTeamTitle($data->guest_team_id);
                }
            ],
            'start_time',
            'end_time',
            'guest_team_result',
            'won_team_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
