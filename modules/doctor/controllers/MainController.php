<?php


namespace app\modules\doctor\controllers;

use app\modules\doctor\models\SignForm;
use yii\web\Controller;
use Yii;

class MainController extends Controller
{
    /**
     * @return string|\yii\web\Response
     *
     * Form for patient registration
     */
    public function actionSign()
    {
        $model = new SignForm();

        if (Yii::$app->request->post('SignForm')) {
            $model->attributes = Yii::$app->request->post('SignForm');
            if ($model->validate() && $model->sign()) {
                return $this->goHome();
            }
        }

        return $this->render('sign', [
            'model' => $model,
        ]);
    }
}