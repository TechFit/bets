<?php


namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Class SignForm
 * @package app\models
 */
class SignForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $repeat_password;

    public function rules()
    {
        return[
            [['email', 'name', 'password', 'repeat_password'], 'required'],
            ['email', 'email'],
            ['name', 'string', 'min' => 3],
            ['email', 'unique', 'targetClass' => 'app\models\User',],
            ['password', 'string', 'min' => 2, 'max' => 10,],
            [
                'repeat_password',
                'compare',
                'compareAttribute'=>'password',
                'skipOnEmpty' => false,
                'message'=>"Пароли не совпадают",
            ],
        ];
    }

    public function sign()
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = sha1($this->password);
        $user->save();
    }
}
