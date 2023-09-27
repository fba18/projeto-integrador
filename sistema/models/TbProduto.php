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
        public static function getProdutos()
        {
            $produtos = self::find()->all();
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


    //Para o javascript de preenchimento automático
        public static function getProdutosSaldoEstoque($num_produto)
        {
            $query = "
                SELECT
                    p.num_produto,
                    p.nome_produto,
                    p.estado_produto,
                    p.preco_produto,
                    e.id_estoque,
                    e.qtd_itens,
                    e.endereco_item
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

                //var_dump($produtos);die;

                $itens[] =[

                    $produtos['num_produto'],
                    $produtos['nome_produto'],
                    $produtos['estado_produto'],
                    $produtos['preco_produto'],
                    $produtos['qtd_itens'],
                    $produtos['endereco_item'],
                    $produtos['id_estoque']
                ];

                foreach($itens as $data){
                    return $data;
                }
        }

}
