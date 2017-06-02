<?php

namespace app\models;

use PHPUnit\Framework\Exception;
use Yii;

/**
 * This is the model class for table "Matches".
 *
 * @property integer $id
 * @property integer $home_team_id
 * @property integer $guest_team_id
 * @property string  $start_time
 * @property string  $end_time
 * @property integer $home_team_result
 * @property integer $guest_team_result
 * @property integer $won_team_id
 */
class Matches extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['home_team_id', 'guest_team_id', 'home_team_result', 'guest_team_result', 'won_team_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'home_team_id' => 'Home Team ID',
            'guest_team_id' => 'Guest Team ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'home_team_result' => 'Home Team Result',
            'guest_team_result' => 'Guest Team Result',
            'won_team_id' => 'Won Team ID',
        ];
    }

    /**
     * @param $startTime
     * @return false|string
     *
     * Add 90 minutes to match time
     */
    public function countEndTimeMatch($startTime)
    {
        $time = date("y-m-d H:i:0", strtotime("+90 minutes", strtotime($startTime)));

        return $time;
    }

    public function countTotalUserScore($matchId)
    {
        $matchResult = self::findOne(['id' => $matchId]);

        $userMatchesData = new MatchesForUser();

        $userBetForMatch = $userMatchesData->getUserBetForMatch($matchId, $matchResult->id);

        // todo need to check data from userMatchesData and user betForMatch;
    }
}
