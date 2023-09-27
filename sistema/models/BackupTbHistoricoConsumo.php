<?php

namespace app\models;

use Yii;
use yii\behaviors\AttibyteBehavior;
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\db\Expression;

/**
 * This is the model class for table "tb_historico_consumo".
 *
 * @property int $id_consumo
 * @property int $id_estoque
 * @property int $id_num_produto
 * @property int $id_cliente_cpf_cnpj
 * @property int $qtd_consumida
 * @property string $data_consumo
 */
class TbHistoricoConsumo extends \yii\db\ActiveRecord
{

    public $nome_produto;
    public $estado_produto;
    public $preco_produto;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_historico_consumo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_consumo', 'id_estoque', 'id_num_produto', 'id_cliente_cpf_cnpj', 'qtd_consumida', 'data_consumo'], 'required'],
            [['id_consumo', 'id_estoque', 'id_num_produto', 'qtd_consumida'], 'integer'],
            [['id_cliente_cpf_cnpj'], 'string', 'max' => 14],
            [['data_consumo'], 'safe'],
            [['id_consumo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_consumo' => Yii::t('app', 'Id Consumo'),
            'id_estoque' => Yii::t('app', 'Id Estoque'),
            'id_num_produto' => Yii::t('app', 'Id Num Produto'),
            'id_cliente_cpf_cnpj' => Yii::t('app', 'Id Cliente Cpf Cnpj'),
            'qtd_consumida' => Yii::t('app', 'Qtd Consumida'),
            'data_consumo' => Yii::t('app', 'Data Consumo'),
        ];
    }


}
