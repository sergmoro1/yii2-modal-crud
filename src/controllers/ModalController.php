<?php

namespace sergmoro1\modal\controllers;

use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use sergmoro1\modal\Module;

/**
 * Abstract Controller implements the CRUD actions with role based access control by Modal way.
 */
abstract class ModalController extends Controller
{
    abstract public function newModel();
    abstract public function newSearch();

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * List all models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!\Yii::$app->user->can('index', [], false))
            throw new ForbiddenHttpException(\Yii::t('app', 'Access denied.'));

        $searchModel = $this->newSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!\Yii::$app->user->can('view'))
            return $this->alert(\Yii::t('app', 'Access denied.'));

        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionValidate($scenario = false)
    {
        $model = $this->newModel();
        if($scenario)
            $model->scenario = $scenario;
        $request = \Yii::$app->getRequest();

        // Ajax validation including form open in a modal window
        if ($request->isAjax && $model->load($request->post())) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function fillin($model, $update = true)
    {
        return $model;
    }
    
    /**
     * Creates a new model.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!\Yii::$app->user->can('create'))
            return $this->alert(\Yii::t('app', 'Access denied.'));

        $model = $this->newModel();
        $model = $this->fillin($model, false);
        
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!\Yii::$app->user->can('update', ['model' => $model]))
            return $this->alert(\Yii::t('app', 'Access denied.'));

        $model = $this->fillin($model);
        
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			return YII_DEBUG 
                ? $this->redirect(['index'])
			    : $this->redirect(\Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!\Yii::$app->user->can('delete'))
            throw new ForbiddenHttpException(\Yii::t('app', 'Access denied.'));

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function alert($message)
    {
        return '<div class="alert alert-danger" role="alert">'. $message .'</div>';
    }

    /**
     * Finds model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$self = $this->newModel();
        if (($model = $self::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(\Yii::t('app', 'The requested model does not exist.'));
        }
    }
}
