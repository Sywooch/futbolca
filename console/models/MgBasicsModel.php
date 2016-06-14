<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "mg_basics_model".
 *
 * @property string $bm_id
 * @property string $bm_name
 * @property string $bm_price
 */
class MgBasicsModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_basics_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bm_name'], 'required'],
            [['bm_price'], 'integer'],
            [['bm_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bm_id' => Yii::t('app', 'Bm ID'),
            'bm_name' => Yii::t('app', 'Bm Name'),
            'bm_price' => Yii::t('app', 'Bm Price'),
        ];
    }
}
