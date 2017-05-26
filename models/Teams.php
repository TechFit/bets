<?php

namespace app\models;

use Yii;

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
        return 'Teams';
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
}
