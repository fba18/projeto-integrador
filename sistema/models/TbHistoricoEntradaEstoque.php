<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_historico_entrada_estoque".
 *
 * @property int $id_historico_entrada_estoque
 * @property int $id_local_deposito
 * @property int $id_estoque
 * @property int $num_produto
 * @property string $data_inclusao
 * @property int $qtd_inclusao
 * @property string $tipo_entrada
 * @property int $id_local_deposito_anterior
 * @property int $id_usuario_inclusao
 */
class TbHistoricoEntradaEstoque extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_historico_entrada_estoque';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_local_deposito', 'id_estoque', 'num_produto', 'data_inclusao', 'qtd_inclusao', 'tipo_entrada', 'id_local_deposito_anterior', 'id_usuario_inclusao'], 'required'],
            [['id_local_deposito', 'id_estoque', 'num_produto', 'qtd_inclusao', 'id_local_deposito_anterior', 'id_usuario_inclusao'], 'integer'],
            [['data_inclusao'], 'safe'],
            [['tipo_entrada'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_historico_entrada_estoque' => Yii::t('app', 'Id Historico Entrada Estoque'),
            'id_local_deposito' => Yii::t('app', 'Id Local Deposito'),
            'id_estoque' => Yii::t('app', 'Id Estoque'),
            'num_produto' => Yii::t('app', 'Num Produto'),
            'data_inclusao' => Yii::t('app', 'Data Inclusao'),
            'qtd_inclusao' => Yii::t('app', 'Qtd Inclusao'),
            'tipo_entrada' => Yii::t('app', 'Tipo Entrada'),
            'id_local_deposito_anterior' => Yii::t('app', 'Id Local Deposito Anterior'),
            'id_usuario_inclusao' => Yii::t('app', 'Id Usuario Inclusao'),
        ];
    }
}
