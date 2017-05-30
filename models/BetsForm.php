<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class LoginForm
 * @package app\models
 *
 * Bets form
 */
class BetsForm extends Model
{
    public $matchId;
    public $homeTeamResult;
    public $guestTeamResult;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['matchId', 'homeTeamResult', 'guestTeamResult'], 'required'],
            [['matchId', 'homeTeamResult', 'guestTeamResult'], 'integer'],
        ];
    }

    public function save()
    {
        $userId = Yii::$app->user->id;

        $saveMatch = new MatchesForUser();

        $saveMatch->saveUserBet($userId, $this->matchId, $this->homeTeamResult, $this->guestTeamResult);

    }

}
