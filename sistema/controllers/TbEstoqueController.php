<?php

namespace app\controllers;

use app\models\TbEstoque;
use app\models\TbEstoqueSearch;
use app\models\TbLocalDeposito;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use app\models\TbProduto;
use app\models\TbProdutoSearch;
use Yii;

/**
 * TbEstoqueController implements the CRUD actions for TbEstoque model.
 */
class TbEstoqueController extends Controller
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
     * Lists all TbEstoque models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TbEstoqueSearch();

        /*$dataProvider = new \yii\data\ActiveDataProvider([
            'query' => TbEstoque::find()
                ->select(['tb_estoque.*', 'tb_produto.nome_produto', 'tb_produto.estado_produto', 'tb_produto.preco_produto'])
                ->leftJoin('tb_produto', 'tb_estoque.num_produto = tb_produto.num_produto'),
            'sort' => [
                'attributes' => [

                    'id_estoque',
                    'num_produto',
                    'qtd_itens',
                    'endereco_item',
                    'nome_produto',
                    'estado_produto',
                    'preco_produto',
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);*/

        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TbEstoque model.
     * @param int $id_estoque Id Estoque
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_estoque)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_estoque),
        ]);
    }

    /**
     * Creates a new TbEstoque model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TbEstoque();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('error', 'Dados atualizados com sucesso!');

                //Inserir na tb_historico_entrada_estoque
                    $id_local_deposito = $model->id_local_deposito;
                    $id_estoque = $model->id_estoque;
                    $num_produto = $model->num_produto;
                    $qtd_itens = $model->qtd_itens;
                    $endereco_item = $model->endereco_item;
                    $data_inclusao = date('Y-m-d');
                    //$qtd_inclusao = $model->qtd_inclusao;
                    $id_usuario_inclusao = Yii::$app->user->identity->id;

                    $connection = Yii::$app->db;
                    $transaction = $connection->beginTransaction();

                    try {
                        $connection->createCommand()->insert('tb_historico_entrada_estoque', [
                            'id_local_deposito' => $id_local_deposito,
                            'id_estoque' => $id_estoque,
                            'num_produto' => $num_produto,
                            'data_inclusao' => $data_inclusao,
                            'qtd_inclusao' => $qtd_itens,
                            'tipo_entrada' => 'Inclusão',
                            'id_local_deposito_anterior' => 0,
                            'id_usuario_inclusao' => $id_usuario_inclusao
                        ])->execute();

                        /*$connection->createCommand(
                            "INSERT tb_historico_entrada_estoque
                            (
                                id_local_deposito,
                                id_estoque,
                                num_produto,
                                data_inclusao,
                                qtd_inclusao,
                                tipo_entrada,
                                id_local_deposito_anterior,
                                id_usuario_inclusao
                            )
                            values
                            (
                                $id_local_deposito,
                                $id_estoque,
                                $num_produto,
                                '$data_inclusao',
                                $qtd_itens,
                                'Inclusão',
                                0,
                                $id_usuario_inclusao
                            )
                            "
                        )->execute();*/

                        $transaction->commit();
                        return $this->redirect(['update', 'id_estoque' => $model->id_estoque]);
                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        Yii::error('Erro ao inserir estoque: ' . $e->getMessage(), __METHOD__);
                        return $e->getMessage(); //'Erro ao inserir estoque!';
                    }
                //

                //return $this->redirect(['update', 'id_estoque' => $model->id_estoque]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TbEstoque model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_estoque Id Estoque
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_estoque)
    {

        $model = $this->findModel($id_estoque);


        /*if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_estoque' => $model->id_estoque]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);*/

        $produtoModel = TbProduto::findOne($model->num_produto);

        if ($model->load(Yii::$app->request->post())/* && $model->save()*/) {

            //Inserir na tb_historico_entrada_estoque
                $id_local_deposito = $model->id_local_deposito;
                $id_estoque = $model->id_estoque;
                $num_produto = $model->num_produto;
                $qtd_itens = $model->qtd_itens;
                $endereco_item = $model->endereco_item;
                $data_inclusao = date('Y-m-d');
                //$qtd_inclusao = $model->qtd_inclusao;
                $id_usuario_inclusao = Yii::$app->user->identity->id;

                $qtdExistente = (new \yii\db\Query())
                    ->select(['qtd_itens'])
                    ->from('tb_estoque')
                    ->where([
                        'id_estoque' => $id_estoque
                    ])
                    ->one();

                //$qtdExistente = Yii::$app->db->createCommand("SELECT qtd_itens FROM tb_estoque WHERE id_estoque = $id_estoque")->queryOne();

                if (empty($qtdExistente)) {
                    $qtdExistente = 0;
                    echo "Vazio";
                }

                $qtd_inclusao = $qtd_itens - $qtdExistente;

                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();

                try {
                    $connection->createCommand()->insert('tb_historico_entrada_estoque', [
                        'id_local_deposito' => $id_local_deposito,
                        'id_estoque' => $id_estoque,
                        'num_produto' => $num_produto,
                        'data_inclusao' => $data_inclusao,
                        'qtd_inclusao' => $qtd_inclusao,
                        'tipo_entrada' => 'Inclusão',
                        'id_local_deposito_anterior' => 0,
                        'id_usuario_inclusao' => $id_usuario_inclusao
                    ])->execute();

                    /*$connection->createCommand(
                        "INSERT tb_historico_entrada_estoque
                        (
                            id_local_deposito,
                            id_estoque,
                            num_produto,
                            data_inclusao,
                            qtd_inclusao,
                            tipo_entrada,
                            id_local_deposito_anterior,
                            id_usuario_inclusao
                        )
                        values
                        (
                            $id_local_deposito,
                            $id_estoque,
                            $num_produto,
                            '$data_inclusao',
                            $qtd_inclusao,
                            'Inclusão',
                            0,
                            $id_usuario_inclusao
                        )
                        "
                    )->execute();*/

                    $transaction->commit();
                    if($model->save()){
                        return $this->redirect(['update', 'id_estoque' => $model->id_estoque]);
                    }else{
                        $transaction->rollBack();
                        Yii::error('Erro ao salvar:' .$model->errors);
                        return var_dump($model->errors);
                    }

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro ao inserir estoque: ' . $e->getMessage(), __METHOD__);
                    return $e->getMessage(); //'Erro ao inserir estoque!';
                }
            //

            //echo $model->id_estoque;die;
            Yii::$app->session->setFlash('error', 'Dados atualizados com sucesso!');
            return $this->redirect(['update', 'id_estoque' => $model->id_estoque]);
            //return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'produtoModel' => $produtoModel,
        ]);

    }

    public function actionTransferirEstoque($id_estoque)
    {
        $model = $this->findModel($id_estoque);

        $produtoModel = TbProduto::findOne($model->num_produto);

        // Obtendo os dados da tabela TbLocalDeposito e ordenando pelo nome_deposito
        $localDepositos = TbLocalDeposito::find()
        ->select(['id_local_deposito', 'nome_deposito']) // Seleciona apenas as colunas desejadas
        ->where(['not in', 'id_local_deposito', $model->id_local_deposito])
        ->orderBy('nome_deposito') // Ordena pela coluna nome_deposito
        ->all();

        //$localDepositos = Yii::$app->db->createCommand("SELECT id_local_deposito, nome_deposito FROM tb_local_deposito ORDER BY nome_deposito")->queryAll();

        $xb = $produtoModel;

        if ($model->load(Yii::$app->request->post())/* && $model->save()*/) {

            $modelConsulta = $this->findModel($id_estoque);
            $id_local_origem  = $model->id_local_deposito; //De onde sai
            $id_local_destino = $modelConsulta->id_local_deposito; //Para onde vai
            $num_produto = $model->num_produto;
            $endereco_destino_no_deposito = $modelConsulta->endereco_item;

            if(!$id_local_origem){
                //throw new \Exception("Local de origem não pode ficar vazio");
                throw new BadRequestHttpException("Local de origem não pode ficar vazio");
            }

            $qtd_transferencia = $model->qtd_itens;

            $saldoDisponivelOrigem = Yii::$app->db->createCommand("SELECT qtd_itens FROM tb_estoque WHERE num_produto = $num_produto AND id_local_deposito = $id_local_origem")->queryScalar()??0;

            if ($qtd_transferencia >  $saldoDisponivelOrigem){
                throw new BadRequestHttpException("Quantidade requisitada ($qtd_transferencia) é maior que a quantidade disponível ($saldoDisponivelOrigem)");
            }

            $saldoAtual = $modelConsulta->qtd_itens;

            $novaQtde =  (int)$saldoAtual + (int)$qtd_transferencia;

            //Local de onde vai sair os produtos
                $dados_estoque_origem = (new \yii\db\Query())
                    ->select(['id_estoque', 'id_local_deposito', 'num_produto','qtd_itens', 'endereco_item'])
                    ->from('tb_estoque')
                    ->where([
                        'num_produto' => $num_produto,
                        'id_local_deposito' => $id_local_origem
                    ])
                    ->one()??null;

                if(!$dados_estoque_origem || $dados_estoque_origem['qtd_itens']===0){
                    throw new BadRequestHttpException("Não há saldo disponível no depósito requisitado");
                }

                $novo_saldo_origem_atualizado = (int)$dados_estoque_origem['qtd_itens'] - (int) $qtd_transferencia;

                $endereco_origem_no_deposito = $dados_estoque_origem['endereco_item']??'';

                $nomeDepositoOrigem =  (new \yii\db\Query())
                ->select(['nome_deposito']) // Seleciona apenas as colunas desejadas
                ->from('tb_local_deposito')
                ->where(['=', 'id_local_deposito', "$id_local_origem"])
                ->scalar();
            //

            $nomeDepositoDestino =  (new \yii\db\Query())
                ->select(['nome_deposito']) // Seleciona apenas as colunas desejadas
                ->from('tb_local_deposito')
                ->where(['=', 'id_local_deposito', "$id_local_destino"])
                ->scalar();

            //Dados produto
                $dados_produto = (new \yii\db\Query())
                ->select(['num_produto', 'nome_produto'])
                ->from('tb_produto')
                ->where([
                    'num_produto' => $num_produto,
                ])
                ->one()??null;

                $nome_produto = $dados_produto['nome_produto'];
            //

            //Inserir na tb_historico_entrada_estoque
                $id_local_deposito = $id_local_destino;
                $endereco_item = $model->endereco_item;
                $data_inclusao = date('Y-m-d');
                //$qtd_inclusao = $model->qtd_inclusao;
                $id_usuario_inclusao = Yii::$app->user->identity->id;

                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();

                try {
                    $connection->createCommand()->insert('tb_historico_entrada_estoque', [
                        'id_local_deposito' => $id_local_deposito,
                        'id_estoque' => $id_estoque,
                        'num_produto' => $num_produto,
                        'data_inclusao' => $data_inclusao,
                        'qtd_inclusao' => $qtd_transferencia,
                        'tipo_entrada' => 'Transferência',
                        'id_local_deposito_anterior' => $id_local_origem,
                        'id_usuario_inclusao' => $id_usuario_inclusao
                    ])->execute();

                    $connection->createCommand()->insert('tb_historico_transferencia_produtos', [
                        'num_produto' => $num_produto,
                        'id_local_origem' => $id_local_origem,
                        'id_local_destino' => $id_local_destino,
                        'qtd_enviada' => $qtd_transferencia,
                        'data_solicitacao_transferencia' => $data_inclusao,
                        'id_usuario_solicitante' => $id_usuario_inclusao
                    ])->execute();

                    $connection->createCommand()->update('tb_estoque', [
                        'qtd_itens' => $novaQtde,
                    ], 'id_estoque = :id_estoque', [':id_estoque' => $id_estoque])->execute();

                    //Subtrair na origem
                    $connection->createCommand()->update('tb_estoque', [
                        'qtd_itens' => $novo_saldo_origem_atualizado,
                    ], 'id_estoque = :id_estoque', [':id_estoque' => $dados_estoque_origem['id_estoque']])->execute();

                    $transaction->commit();

                    $setHtmlBody = "<p><strong style='color:red;'><u>ALERTA DE TRANSFERÊNCIA DE ESTOQUE:</u></strong></p><br>

                        <p>Foi solicitado a transferência de:</p><br>

                        <p><strong>Código produto: </strong><em>$num_produto</em><br>
                            <strong>Nome: </strong><em>$nome_produto</em><br>
                            <strong>Endereço: </strong> $endereco_origem_no_deposito</em><br>
                            <strong>Qtde. Solicitada: </strong> <em style='color:red;'> $qtd_transferencia unidades</em><br>
                            <strong>Depósito: </strong><em>$nomeDepositoOrigem</em>.<br>
                        </p>
                        <br>
                        <p>Para o depósito de:</p><br>
                        <p>
                        <strong>Depósito: </strong><em>$nomeDepositoDestino</em><br>
                        <strong>Endereço: </strong> $endereco_destino_no_deposito</em>.<br>

                        <p><em>Esta é uma mensagem automática gerada pelo sistema EIG para controle de Estoque.</em></p>
                    ";


                    Yii::$app->mailer->compose()
                        ->setFrom('projeto.integrador.univesp@outlook.com')
                        ->setTo('2101648@aluno.univesp.br')
                        ->setHtmlBody($setHtmlBody)
                        ->setSubject("Alerta de transferência de estoque - $nome_produto")
                        ->send();


                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro ao inserir estoque: ' . $e->getMessage(), __METHOD__);
                    return $e->getMessage(); //'Erro ao inserir estoque!';
                }
            //

            //echo $model->id_estoque;die;
            Yii::$app->session->setFlash('error', 'Dados atualizados com sucesso!');
            //return $this->redirect(['update', 'id_estoque' => $model->id_estoque]);
            return $this->redirect(['index']);
        }

        return $this->render('transferencia_estoque', [
            'model' => $model,
            'produtoModel' => $produtoModel,
            'localDepositos' => $localDepositos,
            'xb' => $xb

        ]);

    }

    public function actionEnviarRelatorioEstoque()
    {
        // Conexão com o banco de dados
        $db = Yii::$app->db;

        // Sua query SQL (sem alterações)

        $sql = "SELECT
                hc.id_estoque,

                -- Menor e maior datas de consumo
                -- MIN(hc.data_consumo) AS data_inicial,
                -- MAX(hc.data_consumo) AS data_final,

                -- Total de meses de consumo no período (pelo menos 1 mês para não dividir por zero)
                GREATEST(TIMESTAMPDIFF(MONTH, MIN(hc.data_consumo), MAX(hc.data_consumo)) + 1, 1) AS meses_periodo,

                -- Total consumido no período (mantido como inteiro porque já é uma soma)
                SUM(hc.qtd_consumida) AS total_consumido,

                -- Consumo médio mensal, arredondado para inteiro
                /*ROUND(
                    SUM(hc.qtd_consumida) / GREATEST(TIMESTAMPDIFF(MONTH, MIN(hc.data_consumo), MAX(hc.data_consumo)) + 1, 1)
                ) AS consumo_medio_mensal,*/

                -- Consumo médio mensal dividido por 10, arredondado para inteiro
                ROUND(
                    (SUM(hc.qtd_consumida) / GREATEST(TIMESTAMPDIFF(MONTH, MIN(hc.data_consumo), MAX(hc.data_consumo)) + 1, 1)) / 10
                ) AS consumo_medio_dividido_por_10,

                -- Expectativa de venda no mês, que é o consumo médio dividido por 10 (mesmo cálculo acima)
                ROUND(
                    (SUM(hc.qtd_consumida) / GREATEST(TIMESTAMPDIFF(MONTH, MIN(hc.data_consumo), MAX(hc.data_consumo)) + 1, 1)) / 10
                ) AS expectativa_venda_mes,

                -- Estoque atual
                e.qtd_itens AS estoque_atual,

                -- Quantidade necessária para reabastecimento (inteiro)
                ROUND(
                    (
                        (SUM(hc.qtd_consumida) / GREATEST(TIMESTAMPDIFF(MONTH, MIN(hc.data_consumo), MAX(hc.data_consumo)) + 1, 1)) / 10
                    ) - e.qtd_itens
                ) AS qtd_para_reabastecer,

                -- Status de estoque com base na expectativa de venda
                CASE
                    WHEN e.qtd_itens < ROUND(
                        (SUM(hc.qtd_consumida) / GREATEST(TIMESTAMPDIFF(MONTH, MIN(hc.data_consumo), MAX(hc.data_consumo)) + 1, 1)) / 10
                    )
                    THEN 'Necessário reabastecer'
                    ELSE 'Estoque OK'
                END AS status_estoque

            FROM
                tb_historico_consumo hc

            LEFT JOIN tb_estoque e ON e.id_estoque = hc.id_estoque

            GROUP BY
                hc.id_estoque
        ";

        // Executa a query
        $result = $db->createCommand($sql)->queryAll();

        // Filtra apenas os que precisam reabastecer
        $itensParaReabastecer = array_filter($result, function($item) {
            return $item['status_estoque'] === 'Necessário reabastecer';
        });

        if (empty($itensParaReabastecer)) {
            Yii::$app->session->setFlash('success', 'Todos os estoques estão OK! Nenhum item precisa de reabastecimento.');
            return $this->redirect(['index']); // Redireciona para onde quiser
        }

        // Monta a tabela HTML para o e-mail
        $html = "
            <h3>RELATÓRIO DE NECESSIDADE DE REABASTECIMENTO DE ESTOQUE</h3>
            <table border='1' cellpadding='5' cellspacing='0' style='border-collapse: collapse; width: 100%;'>
                <thead>
                    <tr style='background-color: #f2f2f2;'>
                        <th>ID Estoque</th>
                        <th>Meses no Período</th>
                        <th>Total Consumido</th>
                        <th>Consumo Médio</th>
                        <th>Expectativa Venda Mês</th>
                        <th>Estoque Atual</th>
                        <th>Qtd para Reabastecer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
        ";

        // Monta as linhas da tabela com os dados
        foreach ($itensParaReabastecer as $item) {
            $html .= "
                <tr>
                    <td>{$item['id_estoque']}</td>
                    <td>{$item['meses_periodo']}</td>
                    <td>{$item['total_consumido']}</td>
                    <td>{$item['consumo_medio_dividido_por_10']}</td>
                    <td>{$item['expectativa_venda_mes']}</td>
                    <td>{$item['estoque_atual']}</td>
                    <td>{$item['qtd_para_reabastecer']}</td>
                    <td>{$item['status_estoque']}</td>
                </tr>
            ";
        }

        $html .= "
                </tbody>
            </table>
            <p>Este é um relatório automático. Por favor, verifique os itens e tome as providências necessárias.</p>
        ";

        // Envia o e-mail
        $enviado = Yii::$app->mailer->compose()
            ->setFrom(['projeto.integrador.univesp.eig@gmail.com' => 'Sistema EIG']) // Remetente
            ->setTo('2101648@aluno.univesp.br') // Destinatário (pode ser array)
            ->setSubject('RELATÓRIO DE NECESSIDADE DE REABASTECIMENTO DE ESTOQUE')
            ->setHtmlBody($html)
            ->send();

        if ($enviado) {
            Yii::$app->session->setFlash('success', 'E-mail de reabastecimento enviado com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao enviar o e-mail de reabastecimento.');
        }

        // Redireciona de volta (ou exibe algo)
        return $this->redirect(['index']);
    }


    public static function actionObterSaldoDisponivelTransferencia($num_produto, $id_local_deposito){

        $data = Yii::$app->db->createCommand("SELECT id_estoque, num_produto, qtd_itens FROM tb_estoque WHERE num_produto = $num_produto AND id_local_deposito = $id_local_deposito")->queryAll();
        //var_dump($data);
       // echo $item['preco_produto'];
        return json_encode($data);
    }

    //Para o javascript de preenchimento automático view estoque
    public  static function actionObterDados($num_produto){


        $produtoModel = new TbProduto();
        $data = $produtoModel->getProdutos2($num_produto);
        //var_dump($data);
       // echo $item['preco_produto'];
        return json_encode($data);
    }

    //Para o javascript de preenchimento automático view consumo cliente pelo código do Produto
    public  static function actionObterDadosSaldoEstoque($num_produto, $id_local_deposito=NULL){
        //echo $num_produto;die;

        $produtoModel = new TbProduto();
        if(empty($id_local_deposito)){
            $data = $produtoModel->getProdutosSaldoEstoque($num_produto);
        }else{
            $data = $produtoModel->getProdutosSaldoEstoque($num_produto,$id_local_deposito);
        }

        //var_dump($data);
       // echo $item['preco_produto'];
        return json_encode($data);
    }

    //Para o javascript de preenchimento automático view consumo cliente pelo código do Produto
    public  static function actionObterDadosSaldoEstoqueNomeProduto($nome_produto, $id_local_deposito=NULL){
        //echo $num_produto;die;

        $produtoModel = new TbProduto();
        if(empty($id_local_deposito)){
            $data = $produtoModel->getProdutosSaldoEstoqueNomeProduto($nome_produto);
        }else{
            $data = $produtoModel->getProdutosSaldoEstoqueNomeProduto($nome_produto,$id_local_deposito);
        }

        //var_dump($data);
       // echo $item['preco_produto'];
        return json_encode($data);
    }

    /**
     * Deletes an existing TbEstoque model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_estoque Id Estoque
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_estoque)
    {
        $this->findModel($id_estoque)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TbEstoque model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_estoque Id Estoque
     * @return TbEstoque the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_estoque)
    {
        if (($model = TbEstoque::findOne(['id_estoque' => $id_estoque])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //Base Teste
        //Passo 2 - Gerar estoque inicial
            public function actionGerarEstoque()
            {
                // Passo 1: Buscar os num_produto existentes na tb_produto
                $numProdutos = (new \yii\db\Query())
                    ->select(['num_produto'])
                    ->from('tb_produto')
                    ->all();

                if (empty($numProdutos)) {
                    return 'Nenhum produto encontrado na tabela tb_produto!';
                }

                // Passo 2: Gerar os dados para o array $inserir_estoque
                $inserirEstoque = [];

                foreach ($numProdutos as $produto) {
                    $numProduto = $produto['num_produto'];

                    // Para cada produto, criar duas entradas (depósito 1 e 2)
                    for ($deposito = 1; $deposito <= 2; $deposito++) {
                        $qtdItens = rand(1, 250);
                        $enderecoItem = $this->gerarEnderecoAleatorio();

                        $inserirEstoque[] = [
                            'num_produto' => $numProduto,
                            'id_local_deposito' => $deposito,
                            'qtd_itens' => $qtdItens,
                            'endereco_item' => $enderecoItem
                        ];
                    }
                }

                // Exemplo de exibição (opcional)
                // echo '<pre>';
                // print_r($inserirEstoque);
                // echo '</pre>';

                // Passo 3: Inserir no banco de dados usando transação
                $connection = Yii::$app->db;
                $transaction = $connection->beginTransaction();

                try {
                    foreach ($inserirEstoque as $estoque) {
                        $connection->createCommand()->insert('tb_estoque', [
                            'num_produto' => $estoque['num_produto'],
                            'id_local_deposito' => $estoque['id_local_deposito'],
                            'qtd_itens' => $estoque['qtd_itens'],
                            'endereco_item' => $estoque['endereco_item'],
                        ])->execute();
                    }

                    $transaction->commit();
                    return 'Estoque gerado e inserido com sucesso!';
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro ao inserir estoque: ' . $e->getMessage(), __METHOD__);
                    return $e->getMessage(); //'Erro ao inserir estoque!';
                }
            }

            private function gerarEnderecoAleatorio()
            {
                $letras = '';
                for ($i = 0; $i < 3; $i++) {
                    $letras .= chr(rand(65, 90)); // Letras de A-Z
                }

                $numeros = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT); // De 000 a 999

                return $letras . '-' . $numeros;
            }
        //

        //Passo 3 - Gerar histórico de consumo
            public function actionGerarConsumo()
            {
                $connection = Yii::$app->db;

                // 1 - Buscar todos os clientes (cpf_cnpj)
                $clientes = (new \yii\db\Query())
                    ->select(['cpf_cnpj'])
                    ->from('tb_cliente')
                    ->all();

                if (empty($clientes)) {
                    return 'Nenhum cliente encontrado na tabela tb_cliente!';
                }

                // Criar array com os cpfs/cnpjs
                $idClientes = array_column($clientes, 'cpf_cnpj');

                // 2 - Buscar todos os num_produto da tb_produto
                $produtos = (new \yii\db\Query())
                    ->select(['num_produto'])
                    ->from('tb_produto')
                    ->all();

                if (empty($produtos)) {
                    return 'Nenhum produto encontrado na tabela tb_produto!';
                }

                $transaction = $connection->beginTransaction();

                try {
                    foreach ($produtos as $produto) {
                        $numProduto = $produto['num_produto'];

                        // 3 - Gerar 400 registros para cada produto
                        for ($i = 0; $i < 400; $i++) {
                            // id_local_deposito aleatório
                            $idLocalDeposito = rand(1, 2);

                            // quantidade consumida entre 1 e 300
                            $qtdConsumida = rand(1, 300);

                            // data_consumo aleatória entre 2022-01-01 e 2025-03-12
                            $dataConsumo = $this->gerarDataAleatoria('2022-01-01', '2025-03-12');

                            // cliente aleatório
                            $idCliente = $idClientes[array_rand($idClientes)];

                            // Consultar saldo atual da tb_estoque
                            $estoque = (new \yii\db\Query())
                                ->select(['id_estoque', 'qtd_itens'])
                                ->from('tb_estoque')
                                ->where([
                                    'num_produto' => $numProduto,
                                    'id_local_deposito' => $idLocalDeposito
                                ])
                                ->one();

                            if (!$estoque) {
                                // Se não existe registro no estoque, cria um
                                throw new \Exception("Estoque não encontrado para produto {$numProduto} no depósito {$idLocalDeposito}");
                            }

                            $idEstoque = $estoque['id_estoque'];
                            $saldoAtual = $estoque['qtd_itens'];

                            // Se o saldo não for suficiente, precisa incluir saldo
                            if ($saldoAtual < $qtdConsumida) {
                                $diferenca = $qtdConsumida - $saldoAtual;

                                // Inserir no histórico de entrada de estoque
                                $connection->createCommand()->insert('tb_historico_entrada_estoque', [
                                    'id_local_deposito' => $idLocalDeposito,
                                    'id_estoque' => $idEstoque,
                                    'num_produto' => $numProduto,
                                    'data_inclusao' => $dataConsumo,
                                    'qtd_inclusao' => $diferenca,
                                    'tipo_entrada' => 'Inclusão',
                                    'id_local_deposito_anterior' => 0,
                                    'id_usuario_inclusao' => 1
                                ])->execute();

                                // Atualizar o estoque para adicionar a diferença
                                $connection->createCommand()->update('tb_estoque', [
                                    'qtd_itens' => $saldoAtual + $diferenca
                                ], [
                                    'id_estoque' => $idEstoque
                                ])->execute();

                                $saldoAtual += $diferenca;
                            }

                            // Agora sim, debita o saldo consumido
                            $novoSaldo = $saldoAtual - $qtdConsumida;

                            $connection->createCommand()->update('tb_estoque', [
                                'qtd_itens' => $novoSaldo
                            ], [
                                'id_estoque' => $idEstoque
                            ])->execute();

                            // Inserir no histórico de consumo
                            $connection->createCommand()->insert('tb_historico_consumo', [
                                'id_estoque' => $idEstoque,
                                'id_num_produto' => $numProduto,
                                'id_cliente_cpf_cnpj' => $idCliente,
                                'qtd_consumida' => $qtdConsumida,
                                'data_consumo' => $dataConsumo
                            ])->execute();
                        }
                    }

                    $transaction->commit();
                    return 'Histórico de consumo gerado com sucesso!';
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro ao gerar histórico de consumo: ' . $e->getMessage(), __METHOD__);
                    return $e->getMessage(); //'Erro ao gerar histórico de consumo!';
                }
            }

            private function gerarDataAleatoria($inicio, $fim)
            {
                $inicioTimestamp = strtotime($inicio);
                $fimTimestamp = strtotime($fim);

                $dataAleatoriaTimestamp = rand($inicioTimestamp, $fimTimestamp);

                return date('Y-m-d', $dataAleatoriaTimestamp);
            }
        //

        //Passo 4 - Atualizar consumo após histórico de consumo
            public function actionAtualizarEstoque()
            {
                $connection = Yii::$app->db;

                // 1 - Consultar todos os registros da tb_estoque
                $estoques = (new \yii\db\Query())
                    ->select(['id_estoque', 'num_produto', 'id_local_deposito', 'qtd_itens'])
                    ->from('tb_estoque')
                    ->all();

                if (empty($estoques)) {
                    return 'Nenhum registro encontrado na tb_estoque!';
                }

                $transaction = $connection->beginTransaction();

                try {
                    foreach ($estoques as $estoque) {
                        $idEstoque = $estoque['id_estoque'];
                        $idLocalDeposito = $estoque['id_local_deposito'];
                        $num_produto = $estoque['num_produto'];
                        $qtdItensAtual = $estoque['qtd_itens'];

                        // 2 - Obter a última data_inclusao da tb_historico_entrada_estoque para o id_estoque
                        $ultimaEntrada = (new \yii\db\Query())
                            ->select(['data_inclusao'])
                            ->from('tb_historico_entrada_estoque')
                            ->where(['id_estoque' => $idEstoque])
                            ->orderBy(['data_inclusao' => SORT_DESC])
                            ->one();

                        if ($ultimaEntrada) {
                            $dataUltimaInclusao = $ultimaEntrada['data_inclusao'];
                        } else {
                            // Se não tiver histórico, usa uma data inicial (opcionalmente pode ser '2022-01-01')
                            $dataUltimaInclusao = '2022-01-01';
                        }

                        // 3 - Gerar qtd_inclusao de 1 a 30
                        $qtdInclusao = rand(1, 30);

                        // 4 - Gerar data_inclusao maior que a última e menor ou igual a 2025-03-12
                        $dataInclusao = $this->gerarDataPosterior($dataUltimaInclusao, '2025-03-12');

                        // 5 - Atualizar tb_estoque, somando a qtd_inclusao
                        $novoQtdItens = $qtdItensAtual + $qtdInclusao;

                        $connection->createCommand()->update('tb_estoque', [
                            'qtd_itens' => $novoQtdItens
                        ], [
                            'id_estoque' => $idEstoque
                        ])->execute();

                        // 6 - Inserir no tb_historico_entrada_estoque
                        $connection->createCommand()->insert('tb_historico_entrada_estoque', [
                            'id_local_deposito' => $idLocalDeposito,
                            'id_estoque' => $idEstoque,
                            'num_produto' => $num_produto,
                            'data_inclusao' => $dataInclusao,
                            'qtd_inclusao' => $qtdInclusao,
                            'tipo_entrada' => 'Inclusão',
                            'id_local_deposito_anterior' => 0,
                            'id_usuario_inclusao' => 1
                        ])->execute();
                    }

                    $transaction->commit();
                    return 'Estoque atualizado com sucesso!';
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro ao atualizar estoque: ' . $e->getMessage(), __METHOD__);
                    return $e->getMessage();//'Erro ao atualizar estoque!';
                }
            }

            private function gerarDataPosterior($dataInicio, $dataFim)
            {
                $inicioTimestamp = strtotime($dataInicio . ' +1 day');
                $fimTimestamp = strtotime($dataFim);

                if ($inicioTimestamp > $fimTimestamp) {
                    // Se não for possível gerar uma data no futuro, retorna a data final
                    return date('Y-m-d', $fimTimestamp);
                }

                $dataAleatoriaTimestamp = rand($inicioTimestamp, $fimTimestamp);
                return date('Y-m-d', $dataAleatoriaTimestamp);
            }
        //

        //Passo 5 - Gerar transferência entre estoques
            public function actionTransferirProdutos()
            {
                $connection = Yii::$app->db;

                // Consulta ordenada de todos os estoques
                $estoques = (new \yii\db\Query())
                    ->select(['id_estoque', 'num_produto', 'id_local_deposito', 'qtd_itens'])
                    ->from('tb_estoque')
                    ->orderBy(['num_produto' => SORT_ASC])
                    ->all();

                if (empty($estoques)) {
                    return 'Nenhum produto encontrado em estoque!';
                }

                $transaction = $connection->beginTransaction();

                try {
                    $produtosAgrupados = [];

                    // Agrupa os estoques por num_produto
                    foreach ($estoques as $estoque) {
                        $produtosAgrupados[$estoque['num_produto']][] = $estoque;
                    }

                    foreach ($produtosAgrupados as $numProduto => $estoquesDoProduto) {

                        // Contadores de transferências por origem
                        $transferenciasOrigem = [
                            1 => 0,
                            2 => 0
                        ];

                        // Pega dados dos dois estoques (depot 1 e 2)
                        $estoque1 = null;
                        $estoque2 = null;

                        foreach ($estoquesDoProduto as $estoque) {
                            if ($estoque['id_local_deposito'] == 1) {
                                $estoque1 = $estoque;
                            } elseif ($estoque['id_local_deposito'] == 2) {
                                $estoque2 = $estoque;
                            }
                        }

                        if (!$estoque1 || !$estoque2) {
                            Yii::error("Produto {$numProduto} não tem os dois depósitos configurados.");
                            continue;
                        }

                        // Inicializando saldos locais
                        $saldoEstoque = [
                            1 => $estoque1['qtd_itens'],
                            2 => $estoque2['qtd_itens']
                        ];

                        $idEstoque = [
                            1 => $estoque1['id_estoque'],
                            2 => $estoque2['id_estoque']
                        ];

                        // Enquanto não tiver 50 transferências de cada origem
                        while ($transferenciasOrigem[1] < 50 || $transferenciasOrigem[2] < 50) {

                            // Decide de onde vai sair (se os dois não chegaram nos 50, escolhe aleatório)
                            if ($transferenciasOrigem[1] < 50 && $transferenciasOrigem[2] < 50) {
                                $origemLocal = rand(1, 2);
                            } elseif ($transferenciasOrigem[1] < 50) {
                                $origemLocal = 1;
                            } else {
                                $origemLocal = 2;
                            }

                            $destinoLocal = ($origemLocal == 1) ? 2 : 1;

                            // Saldo de origem atual
                            $saldoOrigem = $saldoEstoque[$origemLocal];

                            // Se saldo for <= 1, não pode transferir. Então tenta inverter
                            if ($saldoOrigem <= 1) {

                                // Tenta inverter origem/destino
                                $origemLocal = $destinoLocal;
                                $destinoLocal = ($origemLocal == 1) ? 2 : 1;

                                $saldoOrigem = $saldoEstoque[$origemLocal];

                                // Se saldo do outro também for <= 1, não pode mais fazer transferência
                                if ($saldoOrigem <= 1) {
                                    Yii::warning("Saldo insuficiente no produto {$numProduto} nos depósitos para continuar.");
                                    break; // Ou continue, se quiser pular esse caso
                                }
                            }

                            // Define o máximo que pode enviar: nunca zera o estoque, deixa pelo menos 1
                            $maxEnviar = $saldoOrigem - 1;

                            // Se mesmo assim não dá pra enviar, pula
                            if ($maxEnviar <= 0) {
                                Yii::warning("Saldo insuficiente no depósito {$origemLocal} do produto {$numProduto}.");
                                continue;
                            }

                            $qtdEnviada = rand(1, $maxEnviar);

                            $dataSolicitacao = $this->gerarDataAleatoriaTransferencia('2022-01-01', '2025-03-12');

                            // INSERE EM tb_historico_transferencia_produtos
                            $connection->createCommand()->insert('tb_historico_transferencia_produtos', [
                                'num_produto' => $numProduto,
                                'id_local_origem' => $origemLocal,
                                'id_local_destino' => $destinoLocal,
                                'qtd_enviada' => $qtdEnviada,
                                'data_solicitacao_transferencia' => $dataSolicitacao,
                                'id_usuario_solicitante' => 1
                            ])->execute();

                            // ATUALIZA SALDOS LOCAIS
                            $saldoEstoque[$origemLocal] -= $qtdEnviada;
                            $saldoEstoque[$destinoLocal] += $qtdEnviada;

                            // ATUALIZA tb_estoque ORIGEM (subtrai)
                            $connection->createCommand()->update('tb_estoque', [
                                'qtd_itens' => $saldoEstoque[$origemLocal]
                            ], [
                                'id_estoque' => $idEstoque[$origemLocal]
                            ])->execute();

                            // ATUALIZA tb_estoque DESTINO (soma)
                            $connection->createCommand()->update('tb_estoque', [
                                'qtd_itens' => $saldoEstoque[$destinoLocal]
                            ], [
                                'id_estoque' => $idEstoque[$destinoLocal]
                            ])->execute();

                            // INSERE EM tb_historico_entrada_estoque para o DESTINO
                            $connection->createCommand()->insert('tb_historico_entrada_estoque', [
                                'id_local_deposito' => $destinoLocal,
                                'id_estoque' => $idEstoque[$destinoLocal],
                                'num_produto' => $numProduto,
                                'data_inclusao' => $dataSolicitacao,
                                'qtd_inclusao' => $qtdEnviada,
                                'tipo_entrada' => 'Transferência',
                                'id_local_deposito_anterior' => $origemLocal,
                                'id_usuario_inclusao' => 1
                            ])->execute();

                            // Incrementa contagem de transferências da origem
                            $transferenciasOrigem[$origemLocal]++;
                        }
                    }

                    $transaction->commit();
                    return 'Transferências garantidas com sucesso!';
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::error('Erro na transferência garantida: ' . $e->getMessage(), __METHOD__);
                    return 'Erro na transferência garantida!';
                }
            }

            private function gerarDataAleatoriaTransferencia($dataInicio, $dataFim)
            {
                $inicioTimestamp = strtotime($dataInicio);
                $fimTimestamp = strtotime($dataFim);

                if ($inicioTimestamp > $fimTimestamp) {
                    return date('Y-m-d', $fimTimestamp);
                }

                $dataAleatoriaTimestamp = rand($inicioTimestamp, $fimTimestamp);
                return date('Y-m-d', $dataAleatoriaTimestamp);
            }
        //

    //Fim base teste

}