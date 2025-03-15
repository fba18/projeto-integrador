<?php

namespace app\controllers;

use app\models\TbProduto;
use app\models\TbProdutoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;

/**
 * TbProdutoController implements the CRUD actions for TbProduto model.
 */
class TbProdutoController extends Controller
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
                'access'=> [
                    'class' => 'webvimark\modules\UserManagement\components\GhostAccessControl',
                    ],
            ]
        );
    }

    /**
     * Lists all TbProduto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TbProdutoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbProduto model.
     * @param int $num_produto Num Produto
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($num_produto)
    {
        return $this->render('view', [
            'model' => $this->findModel($num_produto),
        ]);
    }

    /**
     * Creates a new TbProduto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TbProduto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('error', 'Dados salvos com sucesso!');
                //return $this->redirect(['view', 'num_produto' => $model->num_produto]);
                return $this->redirect(['update', 'num_produto' => $model->num_produto]);
                //return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbProduto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $num_produto Num Produto
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($num_produto)
    {
        $model = $this->findModel($num_produto);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('error', 'Dados atualizados com sucesso!');
            return $this->redirect(['update', 'num_produto' => $model->num_produto]);
            //return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TbProduto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $num_produto Num Produto
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($num_produto)
    {
        $this->findModel($num_produto)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbProduto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $num_produto Num Produto
     * @return TbProduto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($num_produto)
    {
        if (($model = TbProduto::findOne(['num_produto' => $num_produto])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Base Teste
        //Passo 1 - Gerar produtos iniciais
            public function actionGerarProdutos()
            {
                $nomesBase = [
                    'Chapa de Aço', 'Tubo de Alumínio', 'Ferro Fundido', 'Cobre Laminado', 'Liga de Zinco',
                    'Parafuso Inoxidável', 'Porca de Latão', 'Corrente de Aço', 'Viga Metálica', 'Tela de Arame',
                    'Fita de Aço', 'Eixo de Ferro', 'Chapa Galvanizada', 'Mola de Aço', 'Placa de Alumínio',
                    'Ferro Angular', 'Cilindro de Cobre', 'Disco de Zinco', 'Barra de Aço', 'Suporte de Ferro',
                    'Conector Metálico', 'Gancho de Aço', 'Parafuso Galvanizado', 'Abraçadeira Metálica', 'Prego de Aço',
                    'Arruela de Latão', 'Tubo Galvanizado', 'Grampo de Alumínio', 'Ferro Chato', 'Chave Metálica',
                    'Trilho de Aço', 'Perfil de Alumínio', 'Grade de Ferro', 'Protetor de Aço', 'Abraçadeira de Zinco',
                    'Braçadeira de Ferro', 'Anel de Alumínio', 'Lâmina de Aço', 'Tampa Metálica', 'Base de Ferro',
                    'Prendedor de Aço', 'Cabo de Alumínio', 'Ferro Maleável', 'Chassi Metálico', 'Estribo de Aço',
                    'Painel de Alumínio', 'Grampo de Zinco', 'Ferro Dúctil', 'Espelho Metálico', 'Fixador de Aço'
                ];

                $produtos = [];
                $numerosGerados = [];

                for ($i = 0; $i < 50; $i++) {
                    $nomeProduto = $nomesBase[array_rand($nomesBase)]; // Sem o número no final
                    $precoProduto = number_format(mt_rand(1, 134599) / 100, 2, '.', '');
                    $estadoProduto = (rand(0, 1) === 1) ? 'Novo' : 'Usado';
                    $numProduto = $this->gerarNumeroUnico(7, $numerosGerados);

                    $produtos[] = [
                        'num_produto' => $numProduto,
                        'nome_produto' => $nomeProduto,
                        'estado_produto' => $estadoProduto,
                        'preco_produto' => $precoProduto
                    ];
                }

                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();

                try {
                    foreach ($produtos as $produto) {

                        $connection->createCommand()->insert('tb_produto', [
                            'num_produto' => $produto['num_produto'],
                            'nome_produto' => $produto['nome_produto'],
                            'estado_produto' => $produto['estado_produto'],
                            'preco_produto' => $produto['preco_produto'],
                        ])->execute();

                    }

                    $transaction->commit();
                    return 'Produtos inseridos com sucesso!';
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro ao inserir produtos: ' . $e->getMessage(), __METHOD__);
                    return $e->getMessage(); //'Erro ao inserir estoque!';
                }
            }

            private function gerarNumeroUnico($tamanho = 7, &$numerosGerados = [])
            {
                $min = (int) str_pad('1', $tamanho, '0'); // Exemplo: 1000000
                $max = (int) str_pad('9', $tamanho, '9'); // Exemplo: 9999999

                do {
                    $numero = rand($min, $max);
                } while (in_array($numero, $numerosGerados));

                $numerosGerados[] = $numero;

                return $numero;
            }
        //
    //Fim base teste

}
