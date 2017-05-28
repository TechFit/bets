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

    public function checkIsMatchAvailable($matchId)
    {
        $query = Yii::$app->db->createCommand('
            SELECT COUNT(id) FROM matches WHERE start_time > now() AND id = :matchId 
        ')
            ->bindParam(':matchId', $matchId)
            ->queryScalar();

        return $query;
    }
}