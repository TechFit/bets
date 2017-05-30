<?php


namespace app\controllers;


use app\models\BetsForm,
    app\models\MatchesForUser,
    app\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class BetsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'game'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'game'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new MatchesForUser();

        $listOfMatches = $model->dataForMatchTable();

        return $this->render('index', [
            'model' => $model,
            'listOfMatches' => $listOfMatches,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     *
     * Page for user bets
     */
    public function actionGame()
    {
        $model = new BetsForm();
        $checkMatch = new MatchesForUser();
        $matchId = Yii::$app->getRequest()->get('id');
        $checkUser = $checkMatch->checkUserBets($matchId, Yii::$app->user->id);
        $checkTime = $checkMatch->checkIsMatchAvailable($matchId);
        if (empty($checkUser) and $checkTime == 1)
        {
            if (Yii::$app->request->post('BetsForm')) {
                $model->attributes = Yii::$app->request->post('BetsForm');
                $model->matchId = $matchId;
                if ($model->validate()) {
                    $model->save();
                    return $this->goHome();
                }
            }

        } else {
            throw new ForbiddenHttpException('Запрещено');
        }

        return $this->render('game', [
            'model' => $model,
            'matchId' => $matchId
        ]);
    }

    public function actionDelete($betId){

        $model = new MatchesForUser();
        $model->deleteUserBet($betId);

        return $this->redirect(['game']);
    }
}