<?php

namespace app\controllers\admin;

use app\models\Teams;
use Faker\Provider\cs_CZ\DateTime;
use Yii;
use app\models\Matches,
    app\models\MatchesSearch,
    app\models\User;
use yii\web\Controller,
    yii\web\NotFoundHttpException;
use yii\filters\VerbFilter,
    yii\filters\AccessControl;
use Exception;
use yii\web\ForbiddenHttpException;
use yii\web\NotAcceptableHttpException;

/**
 * MatchesController implements the CRUD actions for Matches model.
 */
class MatchesController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Matches models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MatchesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Matches model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Matches model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Matches();

        $teamModels = new Teams();
        $teams = $teamModels->getListOfTeam();

        if ($model->load(Yii::$app->request->post())) {

            $model->end_time = $model->countEndTimeMatch($model->start_time);

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'teams' => $teams
        ]);
    }

    /**
     *
     * Updates an existing Matches model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (date('Y-m-d H:i:s') < $model->start_time or date('Y-m-d H:i:s') > $model->end_time) {
            throw new ForbiddenHttpException('Редактирование запрещено.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Count total score for user after adding match result by admin
            if (!!is_null($model->won_team_id)) {
                $model->countTotalUserScore($model->id);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Matches model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Matches model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Matches the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Matches::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
