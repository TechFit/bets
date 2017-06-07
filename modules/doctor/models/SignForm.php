<?php


namespace app\modules\doctor\models;


use yii\base\Model;
use Yii;

class SignForm extends Model
{
    public $firstName;
    public $lastName;
    public $telephone;
    public $email;
    public $regDate;

    public function rules()
    {
        return[
            [['firstName', 'lastName'], 'required'],
            ['email', 'email'],
            [['email', 'telephone'], 'contactRequired', 'skipOnEmpty'=> false],
            ['regDate', 'safe'],
        ];
    }

    /**
     * @param $attribute_name
     * @param $params
     * @return bool
     *
     * Validation (telephone or email) is not empty;
     */
    public function contactRequired($attribute_name, $params)
    {
        if (empty($this->telephone) && empty($this->email)
        ) {
            $this->addError($attribute_name, Yii::t('user', 'At least 1 of the field must be filled up properly'));

            return false;
        }

        return true;
    }

    public function sign()
    {
        $patient = new PatientsList();
        $patient->firstname = $this->firstName;
        $patient->lastname = $this->lastName;
        $patient->email = $this->email;
        $patient->telephone = $this->telephone;
        $patient->reg_date = $this->regDate;
        $patient->save();
    }


}