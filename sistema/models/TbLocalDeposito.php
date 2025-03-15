<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_local_deposito".
 *
 * @property int $id_local_deposito
 * @property string $nome_deposito
 * @property string $endereco_deposito
 * @property string $uf
 *
 * @property TbEstoque[] $tbEstoques
 */
class TbLocalDeposito extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_local_deposito';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome_deposito', 'endereco_deposito', 'uf'], 'required'],
            [['nome_deposito'], 'string', 'max' => 100],
            [['endereco_deposito'], 'string', 'max' => 255],
            [['uf'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_local_deposito' => Yii::t('app', 'Id Local Deposito'),
            'nome_deposito' => Yii::t('app', 'Nome Deposito'),
            'endereco_deposito' => Yii::t('app', 'Endereco Deposito'),
            'uf' => Yii::t('app', 'Uf'),
        ];
    }

    /**
     * Gets query for [[TbEstoques]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTbEstoques()
    {
        return $this->hasMany(TbEstoque::class, ['id_local_deposito' => 'id_local_deposito']);
    }
}
