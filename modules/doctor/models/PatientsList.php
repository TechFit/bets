<?php

namespace app\modules\doctor\models;

use Yii;

/**
 * This is the model class for table "patientsList".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $telephone
 * @property string $email
 * @property string $reg_date
 * @property integer $relevant
 */
class PatientsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patientsList';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['reg_date'], 'safe'],
            [['relevant'], 'integer'],
            [['firstname', 'lastname', 'telephone', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'telephone' => 'Telephone',
            'email' => 'Email',
            'reg_date' => 'Reg Date',
            'relevant' => 'Relevant',
        ];
    }

    public function setNotRelevant($id)
    {
        $this->updateAll(['relevant' => 0], ['id' => $id]);
    }
}
