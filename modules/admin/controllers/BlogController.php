<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Blog;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    public function actionShow()
    {
        $model = new Blog();

        return $this->render($model->settings()['page'], [
            'model' => $model,
            'rows'=> $model->GetRows(Yii::$app->request->get('Blog'))
        ]);
    }

    public function actionEdit($id)
    {
        $model =  Blog::findOne($id);

        if($model->user_id != yii::$app->user->id)
        {
            throw new NotFoundHttpException('Страница не найдена');

        }

        if($model->load(Yii::$app->request->post())){
            $model->Up($id,Yii::$app->request->post($model->settings()['model_name']));
            $this->basicRedirect($model);
        }

        return $this->render('form' , [
            'model' => $model
        ]);
    }



    public function actionDelete($id)
    {
        $model = new Blog();
        $model->findOne($id)->delete();
        $this->basicRedirect($model);
    }


    public function actionForm()
    {


        $model = new Blog();

        if($model->load(Yii::$app->request->post())){

            $model->Add(Yii::$app->request->post($model->settings()['model_name']));

            return $this->basicRedirect($model);

        }

        return $this->render('form' , compact('model'));
    }


    private function basicRedirect($model)
    {
        $this->redirect( Url::Toroute($model->settings()['baseUrl'].'/show'),301)->send();
    }

    public function actions()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(Url::Toroute(['site/login']), 301)->send();
        }
    }
}
