<?php

namespace console\models;

use Yii;

/**
 * This is the model class for table "{{%delivery}}".
 *
 * @property string $id
 * @property string $old
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
            [['old', 'ua', 'min', 'discount'], 'integer'],
            [['name'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'old' => Yii::t('app', 'Old'),
            'name' => Yii::t('app', 'Name'),
            'text' => Yii::t('app', 'Text'),
            'ua' => Yii::t('app', 'Ua'),
            'min' => Yii::t('app', 'Min'),
            'discount' => Yii::t('app', 'Discount'),
        ];
    }
}
