<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Teams".
 *
 * @property integer $id
 * @property string $title
 * @property integer $tournament_id
 */
class Teams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['tournament_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'tournament_id' => 'Tournament ID',
        ];
    }

    /**
     * @return array
     * List with teams title and id
     */
    public function getListOfTeam()
    {
        $data = self::find()->asArray()->all();
        $teamList = ArrayHelper::map($data, 'id', 'title');

        return $teamList;
    }

    public static function getTeamTitle($teamId)
    {
        $data = self::find()->asArray()->where('id = :teamId', [':teamId' => $teamId])->all();
        $teamTitle = ArrayHelper::getValue(ArrayHelper::map($data, 'id', 'title'), $teamId);

        return $teamTitle;
    }
}
