<?php

namespace app\controllers;

use app\models\TbLocalDeposito;
use app\models\TbLocalDepositoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TbLocalDepositoController implements the CRUD actions for TbLocalDeposito model.
 */
class TbLocalDepositoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all TbLocalDeposito models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TbLocalDepositoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbLocalDeposito model.
     * @param int $id_local_deposito Id Local Deposito
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_local_deposito)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_local_deposito),
        ]);
    }

    /**
     * Creates a new TbLocalDeposito model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TbLocalDeposito();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_local_deposito' => $model->id_local_deposito]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbLocalDeposito model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_local_deposito Id Local Deposito
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_local_deposito)
    {
        $model = $this->findModel($id_local_deposito);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_local_deposito' => $model->id_local_deposito]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbLocalDeposito model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_local_deposito Id Local Deposito
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_local_deposito)
    {
        $this->findModel($id_local_deposito)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbLocalDeposito model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_local_deposito Id Local Deposito
     * @return TbLocalDeposito the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_local_deposito)
    {
        if (($model = TbLocalDeposito::findOne(['id_local_deposito' => $id_local_deposito])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
