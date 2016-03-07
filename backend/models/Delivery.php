<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%delivery}}".
 *
 * @property string $id
 * @property string $name
 * @property string $text
 * @property integer $ua
 * @property integer $min
 * @property integer $discount
 */
class Delivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%delivery}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['name'], 'filter', 'filter' => 'strip_tags', 'skipOnArray' => true],
            [['name'], 'required'],
            [['text'], 'string'],
            [['ua', 'min', 'discount'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'text' => Yii::t('app', 'Text'),
            'ua' => Yii::t('app', 'Цена'),
            'min' => Yii::t('app', 'Заказ на скидку'),
            'discount' => Yii::t('app', 'Скидка'),
        ];
    }

    public static function listDelivery(){
        return ArrayHelper::map(self::find()->orderBy('id')->all(), 'id', 'name');
    }
}
