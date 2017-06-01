<?php


namespace app\components\PlayerStats;

use app\components\PlayerStats\models\StatisticModel;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class PlayerStatsWidget
 * @package app\components\PlayerStats
 * Widget for showing user statistic
 */
class PlayerStatsWidget extends Widget
{
    private $statisticData;

    public function init()
    {
        parent::init();
        $statisticModel = new StatisticModel();
        $this->statisticData = $statisticModel->getBetsStatistic();
    }

    public function run()
    {
        echo Html::tag('p', 'Топ:');
        echo Html::beginTag('table', ['class' => 'table table-bordered']);
        echo Html::beginTag('thead');
        echo Html::beginTag('tr');
            echo Html::tag('th', 'Имя');
            echo Html::tag('th', 'Рейтинг');
        echo Html::endTag('tr');
        echo Html::endTag('thead');
        echo Html::beginTag('tbody');
        foreach ($this->statisticData as $name => $value) {
            echo Html::beginTag('tr');
            echo Html::tag('td', $name);
            echo Html::tag('td', $value);
            echo Html::endTag('tr');
        }
        echo Html::endTag('tbody');
        echo Html::endTag('table');
    }

}