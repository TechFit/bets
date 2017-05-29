<?php


namespace app\models;


use yii\base\Model;
use Yii;
use yii\helpers\Html;

/**
 * Class MatchesForUser
 * @package app\models
 *
 * Class for match working with user
 */
class MatchesForUser extends Model
{
    const GOALLESS_DRAW = 0;

    /**
     * @return array
     *
     * Get list of Matches from db with interval (last 24h)
     */
    public function getAvailableMatches()
    {
        $query = Yii::$app->db->createCommand('SELECT * FROM matches WHERE start_time >= now() - INTERVAL 1 DAY ORDER BY start_time ')->queryAll();

        return $query;
    }

    /**
     * @param $userId
     * @param $matchId
     * @param $homeTeamScore
     * @param $guestTeamScore
     *
     * Save user bet in DB
     */
    public function saveUserBet($userId, $matchId, $homeTeamScore, $guestTeamScore)
    {
        $query = Yii::$app->db->createCommand('
                INSERT INTO userBets (
                    id,
                    user_id,
                    match_id,
                    home_team_score,
                    guest_team_score,
                    result,
                    created_at
                )
                VALUE (
                    DEFAULT, 
                    :userId, 
                    :matchId, 
                    :homeTeamScore,
                    :guestTeamScore, 
                    DEFAULT, 
                    DEFAULT
                )
        ')
            ->bindParam(':userId', $userId)
            ->bindParam(':matchId', $matchId)
            ->bindParam(':homeTeamScore', $homeTeamScore)
            ->bindParam(':guestTeamScore', $homeTeamScore)
            ->execute();
    }

    /**
     * @param $matchId
     * @param $userId
     * @return false|null|string
     *
     * Checking, is user already make the bet for current match
     */
    public function checkUserBets($matchId, $userId)
    {
        $query = Yii::$app->db->createCommand('
            SELECT COUNT(match_id) FROM userBets WHERE match_id = :matchId AND user_id = :userId
        ')
            ->bindParam(':matchId', $matchId)
            ->bindParam(':userId', $userId)
            ->queryScalar();

        return $query;
    }

    /**
     * @param $matchId
     * @return false|null|string
     *
     * Checking, is current match is available
     */
    public function checkIsMatchAvailable($matchId)
    {
        $query = Yii::$app->db->createCommand('
            SELECT COUNT(id) FROM matches WHERE start_time > now() AND id = :matchId 
        ')
            ->bindParam(':matchId', $matchId)
            ->queryScalar();

        return $query;
    }

    public function dataForMatchTable()
    {
        $data = [];

        $listOfMatch = self::getAvailableMatches();
        $i = 0;
        foreach ($listOfMatch AS $match){
            $i++;
            $data[$i]['homeTeam'] = Teams::getTeamTitle($match['home_team_id']);
            $data[$i]['guestTeam'] = Teams::getTeamTitle($match['guest_team_id']);
            $data[$i]['matchTime'] = $match['start_time'];
            $data[$i]['matchResult'] = $match['home_team_result'] . ':' . $match['guest_team_result'];
            if (is_null($match['won_team_id'])){
                $data[$i]['winner'] = "-";
            } elseif ($match['won_team_id'] === self::GOALLESS_DRAW) {
                $data[$i]['winner'] = 'Ничья';
            } else {
                $data[$i]['winner'] = Teams::getTeamTitle($match['won_team_id']);
            }

            if (empty(self::checkUserBets($match['id'], Yii::$app->user->getId()))){
                $data[$i]['tag'] = Html::a("Указать счет", "game?id=" . $match['id']);
            } else {
                $data[$i]['tag'] = '<p>Сделан</p>';
            }

        }

        return $data;
    }

}