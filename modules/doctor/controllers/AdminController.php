<?php

namespace app\modules\doctor\controllers;

use app\modules\doctor\models\PatientsList;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class AdminController extends Controller
{
    /**
     * @return string
     *
     * Action for admin table
     */
    public function actionIndex()
    {

        $query = PatientsList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'reg_date' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     *
     * Action for change status of patient
     */
    public function actionRelevant($id)
    {
        $patient = new PatientsList();

        $patient->setNotRelevant($id);

        return $this->redirect('index');
    }
}