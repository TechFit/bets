<?php


namespace app\models;


use yii\base\Model;
use Yii;

/**
 * Class MatchesForUser
 * @package app\models
 *
 * Class for match working with user
 */
class MatchesForUser extends Model
{
    public function getAvailableMatches()
    {
        $query = Yii::$app->db->createCommand('SELECT * FROM matches ORDER BY start_time')->queryAll();

        return $query;
    }
}