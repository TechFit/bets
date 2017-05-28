<?php


namespace app\controllers;


use app\models\BetsForm,
    app\models\MatchesForUser;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl,
    yii\filters\VerbFilter;
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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

        return $this->render('index', [
            'model' => $model,
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
        if ($checkUser == 0 and $checkTime == 1)
        {
            if (Yii::$app->request->post('BetsForm')) {
                $model->attributes = Yii::$app->request->post('BetsForm');
                $model->matchId = $matchId;
                if ($model->validate() && $model->save()) {
                    return Yii::$app->getResponse()->redirect('/');
                }
            }

        } else {
            throw new ForbiddenHttpException('Прогноз уже сделан');
        }

        return $this->render('game', [
            'model' => $model,
            'matchId' => $matchId
        ]);
    }
}