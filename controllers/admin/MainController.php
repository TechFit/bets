<?php

namespace app\controllers\admin;

use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use app\models\User;

class MainController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isUserAdmin(Yii::$app->user->identity->email);
                        }
                    ],
                ],
            ],
        ];
    }


    /**
     * Displays Admin page.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('/admin/main/index');
    }
}
