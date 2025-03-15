<?php

namespace app\controllers;

use app\models\TbHistoricoEntradaEstoque;
use app\models\TbHistoricoEntradaEstoqueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TbHistoricoEntradaEstoqueController implements the CRUD actions for TbHistoricoEntradaEstoque model.
 */
class TbHistoricoEntradaEstoqueController extends Controller
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
     * Lists all TbHistoricoEntradaEstoque models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TbHistoricoEntradaEstoqueSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbHistoricoEntradaEstoque model.
     * @param int $id_historico_entrada_estoque Id Historico Entrada Estoque
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_historico_entrada_estoque)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_historico_entrada_estoque),
        ]);
    }

    /**
     * Creates a new TbHistoricoEntradaEstoque model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TbHistoricoEntradaEstoque();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbHistoricoEntradaEstoque model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_historico_entrada_estoque Id Historico Entrada Estoque
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_historico_entrada_estoque)
    {
        $model = $this->findModel($id_historico_entrada_estoque);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_historico_entrada_estoque' => $model->id_historico_entrada_estoque]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbHistoricoEntradaEstoque model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_historico_entrada_estoque Id Historico Entrada Estoque
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_historico_entrada_estoque)
    {
        $this->findModel($id_historico_entrada_estoque)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbHistoricoEntradaEstoque model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_historico_entrada_estoque Id Historico Entrada Estoque
     * @return TbHistoricoEntradaEstoque the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_historico_entrada_estoque)
    {
        if (($model = TbHistoricoEntradaEstoque::findOne(['id_historico_entrada_estoque' => $id_historico_entrada_estoque])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
