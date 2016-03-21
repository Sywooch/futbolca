<?php

namespace frontend\models\mg;

use Yii;

/**
 * This is the model class for table "mg_dostavka".
 *
 * @property string $do_id
 * @property string $do_name
 * @property string $do_desc
 * @property string $do_ua
 * @property string $do_min
 * @property string $do_discount_ua
 */
class Dostavka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_dostavka';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['do_name', 'do_desc'], 'required'],
            [['do_name', 'do_desc'], 'string'],
            [['do_ua', 'do_min', 'do_discount_ua'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'do_id' => Yii::t('app', 'Do ID'),
            'do_name' => Yii::t('app', 'Do Name'),
            'do_desc' => Yii::t('app', 'Do Desc'),
            'do_ua' => Yii::t('app', 'Do Ua'),
            'do_min' => Yii::t('app', 'Do Min'),
            'do_discount_ua' => Yii::t('app', 'Do Discount Ua'),
        ];
    }
}
