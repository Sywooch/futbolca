<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_config".
 *
 * @property string $config_name
 * @property string $config_value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['config_name', 'config_value'], 'required'],
            [['config_value'], 'string'],
            [['config_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'config_name' => Yii::t('app', 'Config Name'),
            'config_value' => Yii::t('app', 'Config Value'),
        ];
    }
}
