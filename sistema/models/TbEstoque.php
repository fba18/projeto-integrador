<?php

namespace app\models;


use Yii;
use yii\behaviors\AttibyteBehavior;
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\db\Expression;

/**
 * This is the model class for table "tb_estoque".
 *
 * @property int $id_estoque
 * @property int $num_produto
 * @property int $qtd_itens
 * @property string $endereco_item
 */
class TbEstoque extends \yii\db\ActiveRecord
{
    public $nome_produto;
    public $estado_produto;
    public $preco_produto;
    public $nome_deposito;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_estoque';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'num_produto', 'qtd_itens', 'endereco_item'], 'required'],
            [['id_estoque', 'id_local_deposito', 'num_produto', 'qtd_itens'], 'integer'],
            [['endereco_item'], 'string', 'max' => 20],
            [['id_estoque'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_estoque' => 'Id Estoque',
            'id_local_deposito' => 'Id local Depósito',
            'num_produto' => 'Cód. Produto',
            'qtd_itens' => 'Qtd. Itens',
            'endereco_item' => 'Endereço Item',

            'nome_produto' => 'Nome do Produto',
            'estado_produto' => 'Estado do Produto',
            'preco_produto' => 'Preço do Produto'
        ];
    }

    //Para o select2
    public static function getEstoques()
    {
        $estoques = self::find()->all();
        $data = [];
        foreach ($estoques as $estoque) {
            $data[$estoque->num_produto] = $estoque->num_produto;
        }
        return $data;
    }

    //Para o select2
    public static function getEstoquesNomeProduto()
    {
        // Faz o JOIN entre tb_estoque e tb_local_deposito
        $estoques = self::find()
            ->alias('e')
            ->select(['e.num_produto', 'p.nome_produto'])
            ->leftJoin('tb_produto p', 'p.num_produto = e.num_produto')
            ->groupBy(['e.num_produto']) // Evita repetições se tiver vários produtos
            ->orderBy(['p.nome_produto' => SORT_ASC])
            ->all();

        $data = [];
        foreach ($estoques as $estoque) {
            $data[$estoque->nome_produto] = $estoque->nome_produto;
        }

        return $data;
    }

    //Para o select2
    public static function getEstoquesEnd()
    {
        $estoques = self::find()->all();
        $data = [];
        foreach ($estoques as $estoque) {
            $data[$estoque->endereco_item] = $estoque->endereco_item;
        }
        return $data;
    }

    //Para o select2
    public static function getEstoquesDepositos()
    {
        // Faz o JOIN entre tb_estoque e tb_local_deposito
        $estoques = self::find()
            ->alias('e')
            ->select(['e.id_local_deposito', 'ld.nome_deposito'])
            ->leftJoin('tb_local_deposito ld', 'ld.id_local_deposito = e.id_local_deposito')
            ->groupBy(['e.id_local_deposito']) // Evita repetições se tiver vários produtos no mesmo depósito
            ->all();

        $data = [];
        foreach ($estoques as $estoque) {
            $data[$estoque->id_local_deposito] = $estoque->nome_deposito;
        }

        return $data;
    }

    public function getProduto()
    {
        return $this->hasOne(TbProduto::className(), ['num_produto' => 'num_produto']);
    }

    public function getLocalDeposito()
    {
        return $this->hasOne(TbLocalDeposito::className(), ['id_local_deposito' => 'id_local_deposito']);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'nome_produto';
        $fields[] = 'estado_produto';
        $fields[] = 'preco_produto';
        return $fields;
    }
}
