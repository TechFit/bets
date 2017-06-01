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
        foreach ($this->statisticData as $name => $value) {
            echo Html::tag('p', $name);
            echo Html::tag('p', $value);
        }
    }

}