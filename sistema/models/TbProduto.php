<?php

namespace app\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tb_produto".
 *
 * @property int $num_produto
 * @property string $nome_produto
 * @property string $estado_produto
 * @property float $preco_produto
 */
class TbProduto extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'tb_produto';
    }

    /**
     * @inheritdoc
     */
	public function behaviors()
	{
		return [
            //Preço Produto

            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => 'preco_produto',
                ActiveRecord::EVENT_BEFORE_UPDATE => 'preco_produto',
                        ActiveRecord::EVENT_BEFORE_VALIDATE => 'preco_produto',


                ],
                'value' => function ($event) {
                return str_replace(",",".",str_replace("R$","", $this->preco_produto));

                },
            ],
            [
            'class' => AttributeBehavior::className(),
            'attributes' => [
            ActiveRecord::EVENT_AFTER_FIND => 'preco_produto',

            ],
            'value' => function ($event) {
                    return $this->preco_produto;
            },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['num_produto', 'nome_produto', 'estado_produto', 'preco_produto'], 'required'],
            [['num_produto'], 'string', 'max' => 10],
            [['nome_produto', 'estado_produto'], 'string', 'max' => 255],
            [['preco_produto'], 'safe'],
            [['num_produto'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'num_produto' => 'Cód. Produto',
            'nome_produto' => 'Nome Produto',
            'estado_produto' => 'Estado Produto',
            'preco_produto' => 'Preço Produto',
        ];
    }

    //Para o select2
        //Num produto não listado ne tb_estoque
        public static function getProdutosSemEstoque()
        {
            // Subquery: busca todos os num_produto que estão no estoque
            $subQuery = (new \yii\db\Query())
                ->select('num_produto')
                ->from('tb_estoque');

            // Busca os produtos que NÃO estão no estoque
            $produtos = self::find()
                ->where(['NOT IN', 'num_produto', $subQuery])
                ->all();

            $data = [];
            foreach ($produtos as $produto) {
                $data[$produto->num_produto] = $produto->num_produto;
            }

            return $data;
        }

        //todos os produtos
        public static function getProdutos()
        {
            $produtos = self::find()->all();
            /*$produtos = self::find()
            ->joinWith('estoque')
            ->where(['>=', 'tb_estoque.qtd_itens', 1])
            ->all();*/
            $data = [];
            foreach ($produtos as $produto) {
                $data[$produto->num_produto] = $produto->num_produto;
                //$data[$produto->nome_produto] = $produto->nome_produto;
                //$data[$produto->estado_produto] = $produto->estado_produto;
                //$data[$produto->preco_produto] = $produto->preco_produto;
            }
            return $data;
        }

    //Para o select2
        public static function getProdutosNome()
        {
            $produtos = self::find()->all();
            /*$produtos = self::find()
            ->joinWith('estoque')
            ->where(['>=', 'tb_estoque.qtd_itens', 1])
            ->all();*/
            $data = [];
            foreach ($produtos as $produto) {
                $data[$produto->nome_produto] = $produto->nome_produto;
            }
            return $data;
        }


    //Para o select2
        public static function getProdutosEstadoProd()
        {
            $produtos = self::find()->all();
            $data = [];
            foreach ($produtos as $produto) {
                $data[$produto->estado_produto] = $produto->estado_produto;
            }
            return $data;
        }

    //Para o select2
        public static function getProdutosPreco()
        {
            $produtos = self::find()->all();
            $data = [];
            foreach ($produtos as $produto) {
                $data[$produto->preco_produto] = $produto->preco_produto;
            }
            return $data;
        }

    //Para o javascript de preenchimento automático
        public static function getProdutos2($num_produto)
        {
            $produtos = TbProduto::find()
            ->where(['num_produto' => $num_produto])
            ->one();

            //var_dump($produtos);

            //return $produtos;

            $itens[] =[

                $produtos['num_produto'],
                $produtos['nome_produto'],
                $produtos['estado_produto'],
                $produtos['preco_produto'],
            ];

            foreach($itens as $data){
                return $data;
            }



            /*$data = [];
            foreach ($produtos as $produto) {
                $data[$produto->num_produto] = $produto->num_produto;
                $data[$produto->nome_produto] = $produto->nome_produto;
                $data[$produto->estado_produto] = $produto->estado_produto;
                $data[$produto->preco_produto] = $produto->preco_produto;
            }
            return $data;*/
        }


    //Para o javascript de preenchimento automático pelo código produto
    public static function getProdutosSaldoEstoque($num_produto, $id_local_deposito=NULL)
    {
        if(empty($id_local_deposito)){
            $query = "
                SELECT
                    p.num_produto,
                    p.nome_produto,
                    p.estado_produto,
                    p.preco_produto,
                    e.id_estoque,
                    e.qtd_itens,
                    e.endereco_item,
                    e.id_local_deposito
                FROM
                    tb_produto p
                JOIN
                    tb_estoque e ON p.num_produto = e.num_produto
                WHERE
                    p.num_produto = :num_produto
            ";

            // Execute a consulta SQL usando o Yii2
            $produtos = Yii::$app->db->createCommand($query)
                ->bindValue(':num_produto', $num_produto)
                ->queryOne();

        }else{
            $query = "
                SELECT
                    p.num_produto,
                    p.nome_produto,
                    p.estado_produto,
                    p.preco_produto,
                    e.id_estoque,
                    e.qtd_itens,
                    e.endereco_item,
                    e.id_local_deposito
                FROM
                    tb_produto p
                JOIN
                    tb_estoque e ON p.num_produto = e.num_produto
                WHERE
                    p.num_produto = :num_produto AND e.id_local_deposito = :id_local_deposito
            ";

            // Execute a consulta SQL usando o Yii2
            $produtos = Yii::$app->db->createCommand($query)
            ->bindValue(':num_produto', $num_produto)
            ->bindValue(':id_local_deposito', $id_local_deposito)
            ->queryOne();
        }

            //var_dump($produtos);die;

            $itens[] =[

                $produtos['num_produto'],
                $produtos['nome_produto'],
                $produtos['estado_produto'],
                $produtos['preco_produto'],
                $produtos['qtd_itens'],
                $produtos['endereco_item'],
                $produtos['id_estoque'],
                $produtos['id_local_deposito']
            ];

            foreach($itens as $data){

            }

            return $data;
    }

    //Para o javascript de preenchimento automático pelo código produto
    public static function getProdutosSaldoEstoqueNomeProduto($nome_produto)
    {
        if(empty($id_local_deposito)){
            $query = "
                SELECT
                    p.num_produto,
                    p.nome_produto,
                    p.estado_produto,
                    p.preco_produto,
                    e.id_estoque,
                    e.qtd_itens,
                    e.endereco_item,
                    e.id_local_deposito
                FROM
                    tb_produto p
                JOIN
                    tb_estoque e ON p.num_produto = e.num_produto
                WHERE
                    p.nome_produto = :nome_produto
            ";

            // Execute a consulta SQL usando o Yii2
            $produtos = Yii::$app->db->createCommand($query)
                ->bindValue(':nome_produto', $nome_produto)
                ->queryOne();
        }else{
            $query = "
                SELECT
                    p.num_produto,
                    p.nome_produto,
                    p.estado_produto,
                    p.preco_produto,
                    e.id_estoque,
                    e.qtd_itens,
                    e.endereco_item,
                    e.id_local_deposito
                FROM
                    tb_produto p
                JOIN
                    tb_estoque e ON p.num_produto = e.num_produto AND e.id_local_deposito = :id_local_deposito
                WHERE
                    p.nome_produto = :nome_produto
            ";

            // Execute a consulta SQL usando o Yii2
            $produtos = Yii::$app->db->createCommand($query)
                ->bindValue(':nome_produto', $nome_produto)
                ->bindValue(':id_local_deposito', $id_local_deposito)
                ->queryOne();
        }

        //var_dump($produtos);die;

        $itens[] =[

            $produtos['num_produto'],
            $produtos['nome_produto'],
            $produtos['estado_produto'],
            $produtos['preco_produto'],
            $produtos['qtd_itens'],
            $produtos['endereco_item'],
            $produtos['id_estoque'],
            $produtos['id_local_deposito']
        ];

        foreach($itens as $data){
            return $data;
        }
    }


    // Relacionamento com a tabela de estoque
    public function getEstoque()
    {
        return $this->hasOne(TbEstoque::className(), ['num_produto' => 'num_produto']);
    }
}
