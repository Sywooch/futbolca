<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "mg_individual_order".
 *
 * @property string $io_id
 * @property string $io_name
 * @property string $io_phone
 * @property string $io_email
 * @property string $io_text
 * @property string $io_date
 * @property integer $io_status
 * @property string $io_admintext
 */
class MgIndividualOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_individual_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['io_phone', 'io_text', 'io_admintext'], 'string'],
            [['io_date', 'io_status'], 'integer'],
            [['io_name', 'io_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'io_id' => Yii::t('app', 'Io ID'),
            'io_name' => Yii::t('app', 'Io Name'),
            'io_phone' => Yii::t('app', 'Io Phone'),
            'io_email' => Yii::t('app', 'Io Email'),
            'io_text' => Yii::t('app', 'Io Text'),
            'io_date' => Yii::t('app', 'Io Date'),
            'io_status' => Yii::t('app', 'Io Status'),
            'io_admintext' => Yii::t('app', 'Io Admintext'),
        ];
    }
}
