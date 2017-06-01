<?php

namespace app\components\PlayerStats\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class StatisticModel
 * @package app\components\PlayerStats\models
 *
 * Class for getting data from db for statistic widget
 */
class StatisticModel extends Model
{
    /**
     * @return array
     */
    public function getBetsStatistic()
    {
        $sql = Yii::$app->db->createCommand(
            'SELECT name, totalScore FROM user
             ORDER BY totalScore DESC'
        )->queryAll();

        $data = ArrayHelper::map($sql, 'name', 'totalScore');

        return $data;
    }
}