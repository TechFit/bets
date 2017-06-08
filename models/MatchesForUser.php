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
            ->bindParam(':guestTeamScore', $guestTeamScore)
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
            SELECT id, home_team_score, guest_team_score FROM userBets WHERE match_id = :matchId AND user_id = :userId
        ')
            ->bindParam(':matchId', $matchId)
            ->bindParam(':userId', $userId)
            ->queryAll();

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

    /**
     * @param $matchId integer
     * @return false|null|string
     *
     * Get total count bets for match
     */
    public function totalBetsForMatch($matchId)
    {
        $query = Yii::$app->db->createCommand('
            SELECT count(id) FROM userBets WHERE match_id = :matchId 
        ')
            ->bindParam(':matchId', $matchId)
            ->queryScalar();

        return $query;
    }

    /**
     * @return array
     *
     * Return array with data for table on bets page
     */
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
            } elseif ((int)$match['won_team_id'] === self::GOALLESS_DRAW) {
                $data[$i]['winner'] = 'Ничья';
            } else {
                $data[$i]['winner'] = Teams::getTeamTitle($match['won_team_id']);
            }

            if (self::checkIsMatchAvailable($match['id']) and empty(self::checkUserBets($match['id'], Yii::$app->user->getId()))){
                $data[$i]['tag'] = Html::a("Указать счет", "game?id=" . $match['id']);
            } elseif (!self::checkIsMatchAvailable($match['id'])) {
                $data[$i]['tag'] = '<p>Завершен</p>';
            } else {
                $userBet = self::checkUserBets($match['id'], Yii::$app->user->getId());
                $data[$i]['tag'] = '<span>'. $userBet[0]['home_team_score'] . ':' . $userBet[0]['guest_team_score'] . '</span> ' .
                $data[$i]['tagDel'] = Html::a("Удалить", "bets/delete?betId=" . $userBet[0]['id']);
            }

            $data[$i]['totalBets'] = self::totalBetsForMatch($match['id']);

        }

        return $data;
    }

    /**
     * @param $betId
     *
     * Delete user's bet
     */
    public function deleteUserBet($betId)
    {
        $userId = Yii::$app->user->getId();

        $query = Yii::$app->db->createCommand('DELETE FROM userBets WHERE id = :betId AND user_id = :user_id')
            ->bindParam(':betId', $betId)
            ->bindParam(':user_id', $userId)
            ->execute();
    }

    /**
     * @param $matchId
     * @param $userId
     * @return array
     *
     * Return info about user bet for match
     */
    public function getUserBetForMatch($matchId, $userId)
    {
        $query = Yii::$app->db->createCommand('SELECT * FROM userBets WHERE id = :matchId AND user_id = :user_id')
            ->bindParam(':matchId', $matchId)
            ->bindParam(':user_id', $userId)
            ->execute();

        return $query;
    }

    /**
     * @param $userId
     *
     * Add one point for user result
     */
    public function updateUserResult($userId)
    {
        $query = Yii::$app->db->createCommand('UPDATE userBets SET result = result + 1 WHERE user_id = :userId')
            ->bindParam(':userId', $userId)
            ->execute();
    }

}